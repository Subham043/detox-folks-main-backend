<?php

namespace App\Modules\SubCategory\Services;

use App\Http\Services\FileService;
use App\Modules\SubCategory\Models\SubCategory;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SubCategoryService
{

    public function all(): Collection
    {
        return SubCategory::with('categories')->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = SubCategory::with('categories')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = SubCategory::where('is_draft', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::callback('has_categories', function (Builder $query, $value) {
                        $query->whereHas('categories', function($q) use($value) {
                            $q->where('is_draft', true)->where(function($qr) use($value){
                                $qr->where('category_id', $value);
                            });
                        });
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): SubCategory|null
    {
        return SubCategory::with('categories')->findOrFail($id);
    }

    public function getBySlug(String $slug): SubCategory|null
    {
        return SubCategory::where('is_draft', true)->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): SubCategory
    {
        $sub_category = SubCategory::create($data);
        $sub_category->user_id = auth()->user()->id;
        $sub_category->save();
        return $sub_category;
    }

    public function update(array $data, SubCategory $sub_category): SubCategory
    {
        $sub_category->update($data);
        return $sub_category;
    }

    public function saveImage(SubCategory $sub_category): SubCategory
    {
        $this->deleteImage($sub_category);
        $image = (new FileService)->save_file('image', (new SubCategory)->image_path);
        return $this->update([
            'image' => $image,
        ], $sub_category);
    }

    public function delete(SubCategory $sub_category): bool|null
    {
        $this->deleteImage($sub_category);
        return $sub_category->delete();
    }

    public function deleteImage(SubCategory $sub_category): void
    {
        if($sub_category->image){
            $path = str_replace("storage","app/public",$sub_category->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_categories(SubCategory $sub_category, array $data): SubCategory
    {
        $sub_category->categories()->sync($data);
        return $sub_category;
    }

    public function get_subcategories(array $data): Collection
    {
        return SubCategory::with([
            'categories' => function($q) use($data) {
                $q->whereIn('category_id', $data);
            }
        ])
        ->wherehas('categories', function($q) use($data){
            $q->whereIn('category_id', $data);
        })
        ->get();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%')
        ->orWhere('slug', 'LIKE', '%' . $value . '%')
        ->orWhere('heading', 'LIKE', '%' . $value . '%')
        ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
    }
}
