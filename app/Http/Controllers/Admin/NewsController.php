<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use App\Http\Requests\Admin\News\StoreRequest;
use App\Http\Requests\Admin\News\EditRequest;
use App\Helpers\StringHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class NewsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.news.index')->with('title', 'Новости');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('maxUploadFileSize'))->with('title', 'Добавление новости');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('image')->storeAs('public/news', $filename)) {
                $img = Image::make(Storage::path('/public/news/') . $filename);
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(Storage::path('/public/news/') . $filename);
            }
        }

        News::create(array_merge(array_merge($request->all()), [
            'image' => $filename ?? null,
        ]));

        return redirect()->route('cp.news.index')->with('success', 'Данные успешно добавлены');

    }

    /**
     * @param int $id
     * @return View
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function edit(int $id): View
    {
        $row = News::find($id);

        if (!$row) abort(404);

        $maxUploadFileSize = StringHelper::maxUploadFileSize();

        return view('cp.news.create_edit', compact('row', 'maxUploadFileSize'))->with('title', 'Редактирование новости');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $row = News::find($request->id);

        if (!$row) abort(404);

        $row->title = $request->input('title');
        $row->text = $request->input('text');
        $row->preview = $request->input('preview');
        $row->meta_title = $request->input('meta_title');
        $row->meta_description = $request->input('meta_description');
        $row->meta_keywords = $request->input('meta_keywords');
        $row->slug = $request->input('slug');
        $row->seo_h1 = $request->input('seo_h1');
        $row->seo_url_canonical = $request->input('seo_url_canonical');

        if ($request->hasFile('image')) {

            $image = $request->pic;

            if ($image != null) {
                if (Storage::disk('public')->exists('news/' . $row->image) === true) Storage::disk('public')->delete('news/' . $row->image);
            }

            if (Storage::disk('public')->exists('news/' . $row->image) === true) Storage::disk('public')->delete('news/' . $row->image);

            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '.' . $extension;

            if ($request->file('image')->storeAs('public/news', $filename)) {
                $img = Image::make(Storage::path('/public/news/') . $filename);
                $img->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });

                if ($img->save(Storage::path('/public/news/') . $filename)) $row->image = $filename;
            }
        }

        $row->image_title = $request->input('image_title');
        $row->image_alt = $request->input('image_alt');
        $row->save();

        return redirect()->route('cp.news.index')->with('success', 'Данные успешно обновлены');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $news = News::find($request->id);

        if ($news) {
            if (Storage::disk('public')->exists('news/' . $news->image) === true) Storage::disk('public')->delete('news/' . $news->image);
        }

        $news->delete();
    }
}