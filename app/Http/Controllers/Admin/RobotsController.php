<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Robots\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class RobotsController extends Controller
{
    public function edit(): View
    {
        $path = public_path('robots.txt');

        return view('cp.robots.edit', [
            'file' => File::exists($path) ? File::get($path) : '',
            'title' => 'Редактирование Robots.txt',
        ]);
    }

    public function update(UpdateRequest $request): RedirectResponse
    {
        File::put(
            public_path('robots.txt'),
            $request->input('content'),
        );

        return redirect()
            ->route('admin.robots.edit')
            ->with('success', 'Данные успешно обновлены');
    }
}