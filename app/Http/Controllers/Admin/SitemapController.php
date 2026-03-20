<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Sitemap\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function index(): View
    {
        return view('cp.sitemap.index', [
            'title' => 'Загрузка и выгрузка файла карты сайта sitemap.xml',
        ]);
    }

    public function export(): Response
    {
        $file = public_path('sitemap.xml');

        return response()->download(
            $file,
            'sitemap.xml',
            ['Content-Type' => 'text/xml'],
        );
    }

    public function importForm(): View
    {
        return view('cp.sitemap.import', [
            'title' => 'Выгрузка карты sitemap.xml',
        ]);
    }

    public function import(EditRequest $request): RedirectResponse
    {
        $request->file('file')->move(public_path(), 'sitemap.xml');

        return redirect()
            ->route('admin.sitemap.index')
            ->with('success', 'Данные обновлены');
    }
}