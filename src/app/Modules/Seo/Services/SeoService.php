<?php

namespace App\Modules\Seo\Services;

use App\Modules\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SeoService
{

    public function all(): Collection
    {
        return Seo::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Seo::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Seo|null
    {
        return Seo::findOrFail($id);
    }

    public function getBySlug(String $slug): Seo|null
    {
        return Seo::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): Seo
    {
        $seo = Seo::create($data);
        $seo->user_id = auth()->user()->id;
        $seo->save();
        return $seo;
    }

    public function update(array $data, Seo $seo): Seo
    {
        $seo->update($data);
        return $seo;
    }

    public function delete(Seo $seo): bool|null
    {
        return $seo->delete();
    }

    public function getBySlugMain(String $slug): Seo|null
    {
        return Seo::where('slug', $slug)->firstOrFail();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('page_name', 'LIKE', '%' . $value . '%')
        ->orWhere('meta_title', 'LIKE', '%' . $value . '%')
        ->orWhere('og_title', 'LIKE', '%' . $value . '%')
        ->orWhere('meta_description', 'LIKE', '%' . $value . '%');
    }
}
