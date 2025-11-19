<?php

namespace App\Console\Commands;

use App\Models\Catalog;
use App\Models\Pages;
use App\Models\Seo;
use App\Models\Products;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create()->add('/');

        $seoPages = Seo::where('seo_sitemap', true)->get();

        foreach ($seoPages as $seoPage) {
            $sitemap->add(Url::create(route($seoPage->type))
                ->setLastModificationDate($seoPage->updated_at));
        }

        $pages = Pages::where('seo_sitemap', true)->published()->get();

        foreach ($pages as $page) {
            $sitemap->add(Url::create('/page/' . $page->slug)
                ->setLastModificationDate($page->updated_at));
        }

        $catalogs = Catalog::where('seo_sitemap', true)->get();

        foreach ($catalogs as $catalog) {
            $sitemap->add(Url::create('/catalog/' . $catalog->slug)
                ->setLastModificationDate($catalog->updated_at));
        }

        $products = Products::where('seo_sitemap', true)->published()->get();

        foreach ($products as $product) {
            $sitemap->add(Url::create('/product/' . $product->slug)
                ->setLastModificationDate($product->updated_at));
        }

        $sitemap->writeToFile(env('SITEMAP_PATH'));
    }
}
