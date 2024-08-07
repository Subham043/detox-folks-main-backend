<?php

namespace App\Modules\Category\Services;

use App\Http\Services\FileService;
use App\Modules\Category\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryService
{

    public function all(): Collection
    {
        return Category::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Category::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Category::with([
            'sub_categories' => function($q) {
                $q->where('is_draft', true);
            }
        ])->where('is_draft', true);
        return QueryBuilder::for($query)
                ->allowedIncludes(['sub_categories'])
                ->defaultSort('-id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Category|null
    {
        return Category::findOrFail($id);
    }

    public function getBySlug(String $slug): Category|null
    {
        return Category::with([
            'sub_categories' => function($q) {
                $q->where('is_draft', true);
            }
        ])->where('is_draft', true)->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Category
    {
        $category = Category::create($data);
        $category->user_id = auth()->user()->id;
        $category->save();
        return $category;
    }

    public function update(array $data, Category $category): Category
    {
        $category->update($data);
        return $category;
    }

    public function saveImage(Category $category): Category
    {
        $image = (new FileService)->save_file('image', (new Category)->image_path);
        return $this->update([
            'image' => $image,
        ], $category);
    }

    public function delete(Category $category): bool|null
    {
        return $category->delete();
    }

    public function deleteImage(Category $category): void
    {
        if($category->image){
            $path = str_replace("storage","app/public",$category->image);
            (new FileService)->delete_file($path);
        }
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%')
            ->orWhere('heading', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}