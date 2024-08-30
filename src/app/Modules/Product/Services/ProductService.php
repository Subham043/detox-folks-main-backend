<?php

namespace App\Modules\Product\Services;

use App\Http\Services\FileService;
use App\Modules\Product\Models\Product;
use App\Modules\ProductPrice\Models\ProductPrice;
use App\Modules\ProductSpecification\Models\ProductSpecification;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Sorts\Sort;

class ProductService
{

    public function all(): Collection
    {
        return Product::with('categories')->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Product::with('categories')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Product::with([
            'categories',
            'sub_categories',
            'product_specifications',
            'product_images',
            'product_colors',
            'product_prices'=>function($q){
                $q->orderBy('min_quantity', 'asc');
            },
        ])->where('is_draft', true);
        return QueryBuilder::for($query)
                ->allowedIncludes(['categories', 'sub_categories', 'product_specifications', 'product_prices', 'product_images', 'product_colors'])
                ->defaultSort('-id')
                // ->allowedSorts('id', 'name')
                ->allowedSorts([
                    AllowedSort::custom('name', new StringLengthSort(), 'name'),
                    AllowedSort::custom('id', new StringLengthSort(), 'id'),
                ])
                ->allowedFilters([
                    'is_new',
                    'is_on_sale',
                    'is_featured',
                    AllowedFilter::callback('has_categories', function (Builder $query, $value) {
                        $query->whereHas('categories', function($q) use($value) {
                            $q->where('is_draft', true)->where(function($qr) use($value){
                                $arr = array_map('intval', explode('_', $value));
                                $qr->whereIn('category_id', $arr);
                            });
                        });
                    }),
                    AllowedFilter::callback('has_sub_categories', function (Builder $query, $value) {
                        $query->whereHas('sub_categories', function($q) use($value) {
                            $q->where('is_draft', true)->where(function($qr) use($value){
                                $arr = array_map('intval', explode('_', $value));
                                $qr->whereIn('sub_category_id', $arr);
                            });
                        });
                    }),
                    AllowedFilter::callback('is_random', function (Builder $query, $value) {
                        if($value && $value==true){
                            $query->inRandomOrder();
                        }
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Product|null
    {
        return Product::with(['categories', 'product_specifications', 'product_colors', 'product_prices'])->findOrFail($id);
    }

    public function getBySlug(String $slug): Product|null
    {
        return Product::with([
            'categories' => function($q){
                $q->where('is_draft', true);
            },
            'sub_categories' => function($q){
                $q->where('is_draft', true);
            },
            'product_specifications',
            'product_images',
            'product_colors',
            'product_prices'=>function($q){
                $q->orderBy('min_quantity', 'asc');
            },
        ])->where('is_draft', true)->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Product
    {
        $product = Product::create($data);
        $product->user_id = auth()->user()->id;
        $product->save();
        return $product;
    }

    public function update(array $data, Product $product): Product
    {
        $product->update($data);
        return $product;
    }

    public function saveImage(Product $product): Product
    {
        $image = (new FileService)->save_file('image', (new Product)->image_path);
        return $this->update([
            'image' => $image,
        ], $product);
    }

    public function delete(Product $product): bool|null
    {
        return $product->delete();
    }

    public function deleteImage(Product $product): void
    {
        if($product->image){
            $path = str_replace("storage","app/public",$product->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_categories(Product $product, array $data): Product
    {
        $product->categories()->sync($data);
        return $product;
    }

    public function save_sub_categories(Product $product, array $data): Product
    {
        $product->sub_categories()->sync($data);
        return $product;
    }

    public function create_specifications(Product $product, array $data): Product
    {
        $product->product_specifications()->createMany($data);
        $product->refresh();
        return $product;
    }

    public function save_specifications(Product $product, array $data): Product
    {
        foreach ($data as $value) {
            # code...
            if(!empty($value['id'])){
                ProductSpecification::where('id', $value['id'])->update(['title'=> $value['title'], 'description'=> $value['description']]);
            }else{
                ProductSpecification::create([...$value, 'product_id' => $product->id]);
            }
        }
        $product->refresh();
        return $product;
    }

    public function create_prices(Product $product, array $data): Product
    {
        $product->product_prices()->createMany($data);
        $product->refresh();
        return $product;
    }

    public function save_prices(Product $product, array $data): Product
    {
        foreach ($data as $value) {
            # code...
            if(!empty($value['id'])){
                ProductPrice::where('id', $value['id'])->update(['min_quantity'=> $value['min_quantity'], 'price'=> $value['price'], 'discount' => $value['discount']]);
            }else{
                ProductPrice::create([...$value, 'product_id' => $product->id]);
            }
        }
        $product->refresh();
        return $product;
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}

class StringLengthSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query->orderByRaw("LENGTH(`{$property}`) {$direction}")->orderBy($property, $direction);
    }
}
