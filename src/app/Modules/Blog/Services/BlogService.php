<?php

namespace App\Modules\Blog\Services;

use App\Http\Services\FileService;
use App\Modules\Blog\Models\Blog;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class BlogService
{

    public function all(): Collection
    {
        return Blog::all();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Blog::where('is_draft', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Blog::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Blog|null
    {
        return Blog::findOrFail($id);
    }

    public function getBySlug(String $slug): Blog|null
    {
        return Blog::where('slug', $slug)->where('is_draft', true)->firstOrFail();
    }

    public function create(array $data): Blog
    {
        $blog = Blog::create($data);
        $blog->user_id = auth()->user()->id;
        $blog->save();
        return $blog;
    }

    public function update(array $data, Blog $blog): Blog
    {
        $blog->update($data);
        return $blog;
    }

    public function saveImage(Blog $blog): Blog
    {
        $this->deleteImage($blog);
        $image = (new FileService)->save_file('image', (new Blog)->image_path);
        return $this->update([
            'image' => $image,
        ], $blog);
    }

    public function delete(Blog $blog): bool|null
    {
        $this->deleteImage($blog);
        return $blog->delete();
    }

    public function deleteImage(Blog $blog): void
    {
        if($blog->image){
            $path = str_replace("storage","app/public",$blog->image);
            (new FileService)->delete_file($path);
        }
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
