<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Models\Blog;
use App\Modules\Legal\Models\Legal;
use App\Modules\ServicePage\Models\Service;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:update sitemap', ['only' => ['get','generate']]);
    }

    public function get(){
        return view('admin.pages.setting.sitemap');
    }

    public function generate(){

        Sitemap::create()
        // ->add(Url::create('/')
        ->add(Url::create('/')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Url::create('/about-us')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Url::create('/contact-us')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Url::create('/services')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Service::where('is_draft', true)->latest()->get())
        ->add(Url::create('/projects')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Url::create('/blogs')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.1))
        ->add(Blog::where('is_draft', true)->latest()->get())
        ->add(Legal::where('is_draft', true)->latest()->get())
        ->writeToFile(base_path().'/public/sitemap.xml');
        return redirect()->back()->with('success_status', 'Sitemap generated successfully.');
    }
}
