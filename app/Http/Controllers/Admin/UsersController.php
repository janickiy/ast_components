<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Users\DeleteRequest;
use App\Http\Requests\Admin\Users\EditRequest;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.users.index', [
            'title' => 'Администраторы',
        ]);
    }

    public function create(): View
    {
        return view('cp.users.create_edit', [
            'options' => User::$role_name,
            'title' => 'Добавить администратора',
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $this->userRepository->create(
                ArrayData::from([
                    ...$request->validated(),
                    'password' => Hash::make($request->password),
                ]),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Информация успешно добавлена!');
    }

    public function edit(int $id): View
    {
        $row = $this->userRepository->find($id);

        abort_if($row === null, 404);

        return view('cp.users.create_edit', [
            'row' => $row,
            'options' => User::$role_name,
            'title' => 'Редактировать администратора',
        ]);
    }

    public function update(EditRequest $request): RedirectResponse
    {
        try {
            $this->userRepository->update(
                $request->id,
                ArrayData::from($request->validated()),
            );
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Данные успешно обновлены!');
    }

    public function destroy(DeleteRequest $request): void
    {
        if ($request->id !== Auth::id()) {
            $this->userRepository->delete($request->id);
        }
    }
}