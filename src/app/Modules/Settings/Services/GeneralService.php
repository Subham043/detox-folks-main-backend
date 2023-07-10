<?php

namespace App\Modules\Settings\Services;

use App\Http\Services\FileService;
use App\Modules\Settings\Models\General;
use Illuminate\Support\Facades\Cache;

class GeneralService
{

    public function getById(Int $id): General|null
    {
        return Cache::remember('general_settings_main_'.$id, 60*60*24, function() use($id){
            return General::where('id', $id)->first();
        });
    }

    public function createOrUpdate(array $data): General
    {
        $general = General::updateOrCreate(
            ['id' => 1],
            [...$data]
        );

        $general->user_id = auth()->user()->id;
        $general->save();

        return $general;
    }

    public function saveLogoImage(General $general): General
    {
        $this->deleteLogo($general);
        $website_logo = (new FileService)->save_file('website_logo', (new General)->logo_path);
        $general->update([
            'website_logo' => $website_logo,
        ]);
        return $general;
    }

    public function deleteLogo(General $general): void
    {
        if($general->website_logo){
            $path = str_replace("storage","app/public",$general->website_logo);
            (new FileService)->delete_file($path);
        }
    }

    public function saveFooterLogoImage(General $general): General
    {
        $this->deleteFooterLogo($general);
        $website_footer_logo = (new FileService)->save_file('website_footer_logo', (new General)->footer_logo_path);
        $general->update([
            'website_footer_logo' => $website_footer_logo,
        ]);
        return $general;
    }

    public function deleteFooterLogo(General $general): void
    {
        if($general->website_footer_logo){
            $path = str_replace("storage","app/public",$general->website_footer_logo);
            (new FileService)->delete_file($path);
        }
    }

    public function saveFaviconImage(General $general): General
    {
        $this->deleteFavicon($general);
        $website_favicon = (new FileService)->save_file('website_favicon', (new General)->favicon_path);
        $general->update([
            'website_favicon' => $website_favicon,
        ]);
        return $general;
    }

    public function deleteFavicon(General $general): void
    {
        if($general->website_favicon){
            $path = str_replace("storage","app/public",$general->website_favicon);
            (new FileService)->delete_file($path);
        }
    }

}
