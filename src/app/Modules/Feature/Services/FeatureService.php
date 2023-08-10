<?php

namespace App\Modules\Feature\Services;

use App\Http\Services\FileService;
use App\Modules\Feature\Models\Feature;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;

class FeatureService
{

    public function all(): Collection
    {
        return Feature::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Feature::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Feature|null
    {
        return Feature::findOrFail($id);
    }

    public function create(array $data): Feature
    {
        $feature = Feature::create($data);
        $feature->user_id = auth()->user()->id;
        $feature->save();
        return $feature;
    }

    public function update(array $data, Feature $feature): Feature
    {
        $feature->update($data);
        return $feature;
    }

    public function saveImage(Feature $feature): Feature
    {
        $this->deleteImage($feature);
        $image = (new FileService)->save_file('image', (new Feature)->image_path);
        return $this->update([
            'image' => $image,
        ], $feature);
    }

    public function delete(Feature $feature): bool|null
    {
        return $feature->delete();
    }

    public function deleteImage(Feature $feature): void
    {
        if($feature->image){
            $path = str_replace("storage","app/public",$feature->image);
            (new FileService)->delete_file($path);
        }
    }

    public function main_all(): Collection
    {
        return Cache::remember('features_main', 60*60*24, function(){
            return Feature::where('is_draft', true)->get();
        });
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('description', 'LIKE', '%' . $value . '%');
    }
}
