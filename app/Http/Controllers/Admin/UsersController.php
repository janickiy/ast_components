<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Requests\Admin\Users\EditRequest;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Exception;;

class UsersController extends Controller
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.users.index')->with('title', 'Администраторы');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = User::$role_name;

        return view('cp.users.create_edit', compact('options'))->with('title', 'Добавить администратора');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->userRepository->create(array_merge($request->all(), ['password' => Hash::make($request->password)]));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', 'Информация успешно добавлена!');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->userRepository->find($id);

        if (!$row) abort(404);

        $options = User::$role_name;

        return view('cp.users.create_edit', compact('row', 'options'))->with('title', 'Редактировать администратора');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->userRepository->update($request->id, $request->all());
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', 'Данные успешно обновлены!');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        if ($request->id !== Auth::id()) $this->userRepository->delete($request->id);
    }
}
