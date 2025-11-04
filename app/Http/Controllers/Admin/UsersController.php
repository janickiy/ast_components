<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Requests\Admin\Users\EditRequest;
use App\Http\Requests\Admin\Users\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.users.index')->with('title', 'Пользователи');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = User::getOption();

        return view('cp.users.create_edit', compact('options'))->with('title', 'Добавить пользователя');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->userRepository->create(array_merge($request->all(), ['password' => Hash::make($request->password)]));

        return redirect()->route('cp.users.index')->with('success', 'Информация успешно добавлена!');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = $this->userRepository->find($id);

        if (!$user) abort(404);

        $options = User::getOption();

        return view('cp.users.create_edit', compact('user', 'options'))->with('title', 'Редактировать пользователя');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $this->userRepository->update($request->id, $request->all());

        return redirect()->route('cp.users.index')->with('success', 'Данные успешно обновлены!');
    }

    /**
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        if ($request->id !== Auth::id()) $this->userRepository->delete($request->id);
    }
}
