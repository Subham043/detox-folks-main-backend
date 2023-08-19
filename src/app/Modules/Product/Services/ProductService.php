<?php

namespace App\Modules\Product\Services;

use App\Http\Services\FileService;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

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
            'categories' => function($q){
                $q->where('is_draft', true);
            },
            'sub_categories' => function($q){
                $q->where('is_draft', true);
            },
            'product_specifications',
            'product_prices',
        ])->where('is_draft', true)->latest();
        return QueryBuilder::for($query)
                ->allowedIncludes(['categories', 'sub_categories', 'product_specifications', 'product_prices'])
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    'is_new',
                    'is_on_sale',
                    AllowedFilter::callback('has_categories', function (Builder $query, $value) {
                        $query->whereHas('categories', function($q) use($value) {
                            $q->where('is_draft', true)->where(function($qr) use($value){
                                $qr->where('slug', $value);
                            });
                        });
                    }),
                    AllowedFilter::callback('has_sub_categories', function (Builder $query, $value) {
                        $query->whereHas('sub_categories', function($q) use($value) {
                            $q->where('is_draft', true)->where(function($qr) use($value){
                                $qr->where('slug', $value);
                            });
                        });
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Product|null
    {
        return Product::with('categories')->findOrFail($id);
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
            'product_prices',
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
        $this->deleteImage($product);
        $image = (new FileService)->save_file('image', (new Product)->image_path);
        return $this->update([
            'image' => $image,
        ], $product);
    }

    public function delete(Product $product): bool|null
    {
        $this->deleteImage($product);
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

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%')
        ->orWhere('slug', 'LIKE', '%' . $value . '%')
        ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
    }
}
