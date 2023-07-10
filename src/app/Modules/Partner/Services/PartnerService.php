<?php

namespace App\Modules\Partner\Services;

use App\Http\Services\FileService;
use App\Modules\Partner\Models\Partner;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;

class PartnerService
{

    public function all(): Collection
    {
        return Partner::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Partner::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Partner|null
    {
        return Partner::findOrFail($id);
    }

    public function create(array $data): Partner
    {
        $partner = Partner::create($data);
        $partner->user_id = auth()->user()->id;
        $partner->save();
        return $partner;
    }

    public function update(array $data, Partner $partner): Partner
    {
        $partner->update($data);
        return $partner;
    }

    public function saveImage(Partner $partner): Partner
    {
        $this->deleteImage($partner);
        $partner_image = (new FileService)->save_file('image', (new Partner)->image_path);
        return $this->update([
            'image' => $partner_image,
        ], $partner);
    }

    public function delete(Partner $partner): bool|null
    {
        $this->deleteImage($partner);
        return $partner->delete();
    }

    public function deleteImage(Partner $partner): void
    {
        if($partner->image){
            $path = str_replace("storage","app/public",$partner->image);
            (new FileService)->delete_file($path);
        }
    }

    public function main_all(): Collection
    {
        return Cache::remember('partner_main', 60*60*24, function(){
            return Partner::where('is_draft', true)->latest()->get();
        });
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('image_title', 'LIKE', '%' . $value . '%')
        ->orWhere('image_alt', 'LIKE', '%' . $value . '%');
    }
}
