<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Catalog, Pages, Products, News, Manufacturers};
use App\Helpers\StringHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AjaxController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->input('action')) {
            switch ($request->input('action')) {
                case 'get_page_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = Pages::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_manufacturer_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = Manufacturers::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_products_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = Products::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_news_slug':
                    $slug = StringHelper::slug(trim($request->title));
                    $count = News::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);

                case 'get_catalog_slug':
                    $slug = StringHelper::slug(trim($request->name));
                    $count = Catalog::where('slug', 'LIKE', $slug)->count();
                    $slug = $count > 0 ? substr($slug, 0, -1) . ($count + 1) : $slug;

                    return response()->json(['slug' => $slug]);


            }
        }
    }
}