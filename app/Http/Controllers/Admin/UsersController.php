<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\EditRequest;
use Hash;

class UsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('users.index')->with('title', 'Пользователи');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('users.create_edit', compact('options'))->with('title', 'Добавить пользователя');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        User::create(array_merge($request->all(), ['password' => Hash::make($request->password)]));

        return redirect()->route('admin.users.index')->with('success', 'Информация успешно добавлена!');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = User::find($id);

        if (!$user) abort(404);

        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('users.create_edit', compact('user', 'options'))->with('title', 'Редактировать пользователя');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::find($request->id);

        if (!$user) abort(404);

        $user->login = $request->input('login');
        $user->name = $request->input('name');

        if (!empty($request->role)) $user->role = $request->input('role');

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Данные успешно обновлены!');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        if ($request->id !== Auth::id()) User::find($request->id)->delete();
    }
}
