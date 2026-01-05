<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\UpdateProfileRequest;
use App\Http\Requests\Frontend\Profile\ChangePasswordRequest;
use App\Helpers\MenuHelper;
use App\Models\Catalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    protected function getViewData(string $title = 'Личный кабинет'): array
    {
        $menu = MenuHelper::getMenuList();
        $catalogsList = Catalog::getCatalogList();
        $catalogs = Catalog::orderBy('name')->where('parent_id', 0)->get();

        return [
            'title' => $title,
            'meta_description' => '',
            'meta_keywords' => '',
            'meta_title' => $title,
            'seo_url_canonical' => '',
            'h1' => $title,
            'menu' => $menu,
            'catalogsList' => $catalogsList,
            'catalogs' => $catalogs,
        ];
    }

    public function index(): View
    {
        $user = Auth::user();
        $data = $this->getViewData('Личный кабинет');

        return view('frontend.profile.index', array_merge($data, [
            'user' => $user,
        ]));
    }

    public function edit(): View
    {
        $user = Auth::user();
        $data = $this->getViewData('Редактирование профиля');

        return view('frontend.profile.edit', array_merge($data, [
            'user' => $user,
        ]));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('frontend.profile.index')
            ->with('success', 'Профиль успешно обновлен');
    }

    public function showChangePasswordForm(): View
    {
        $data = $this->getViewData('Смена пароля');

        return view('frontend.profile.change-password', $data);
    }

    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('frontend.profile.index')
            ->with('success', 'Пароль успешно изменен');
    }
}
