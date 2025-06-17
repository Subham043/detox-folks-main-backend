<?php

namespace App\Modules\HomePageBanner\Services;

use App\Http\Services\FileService;
use App\Modules\HomePageBanner\Models\HomePageBanner;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class HomePageBannerService
{

    public function all(): Collection
    {
        return HomePageBanner::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = HomePageBanner::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): HomePageBanner|null
    {
        return HomePageBanner::findOrFail($id);
    }

    public function create(array $data): HomePageBanner
    {
        $home_page_banner = HomePageBanner::create($data);
        return $home_page_banner;
    }

    public function update(array $data, HomePageBanner $home_page_banner): HomePageBanner
    {
        $home_page_banner->update($data);
        return $home_page_banner;
    }

    public function saveDesktopImage(HomePageBanner $home_page_banner): HomePageBanner
    {
        $this->deleteDesktopImage($home_page_banner);
        $desktop_image = (new FileService)->save_file('desktop_image', (new HomePageBanner)->image_path);
        return $this->update([
            'desktop_image' => $desktop_image,
        ], $home_page_banner);
    }

    public function saveMobileImage(HomePageBanner $home_page_banner): HomePageBanner
    {
        $this->deleteMobileImage($home_page_banner);
        $mobile_image = (new FileService)->save_file('mobile_image', (new HomePageBanner)->image_path);
        return $this->update([
            'mobile_image' => $mobile_image,
        ], $home_page_banner);
    }

    public function delete(HomePageBanner $home_page_banner): bool|null
    {
        return $home_page_banner->delete();
    }

    public function deleteDesktopImage(HomePageBanner $home_page_banner): void
    {
        if($home_page_banner->desktop_image){
            $path = str_replace("storage","app/public",$home_page_banner->desktop_image);
            (new FileService)->delete_file($path);
        }
    }

    public function deleteMobileImage(HomePageBanner $home_page_banner): void
    {
        if($home_page_banner->mobile_image){
            $path = str_replace("storage","app/public",$home_page_banner->mobile_image);
            (new FileService)->delete_file($path);
        }
    }

    public function main_all(): Collection
    {
        return HomePageBanner::where('is_draft', true)->get();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('image_alt', 'LIKE', '%' . $value . '%')
            ->orWhere('image_title', 'LIKE', '%' . $value . '%');
        });
    }
}
