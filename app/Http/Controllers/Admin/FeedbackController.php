<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\ArrayData;
use App\Http\Requests\Admin\Feedback\DeleteRequest;
use App\Http\Requests\Admin\Feedback\EditRequest;
use App\Models\Feedback;
use App\Repositories\FeedbackRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __construct(
        private readonly FeedbackRepository $feedbackRepository,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.feedback.index')
            ->with('title', 'Сообщения с сайта');
    }

    public function edit(int $id): View
    {
        $row = $this->feedbackRepository->find($id);

        abort_if($row === null, 404);

        $options = Feedback::getOption();

        return view('cp.feedback.edit', compact('row', 'options'))
            ->with('title', 'Редактирование');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $this->feedbackRepository->updateWithMapping(
            $request->id,
            ArrayData::from($request->validated()),
        );

        return redirect()
            ->route('admin.feedback.index')
            ->with('success', 'Данные обновлены');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->feedbackRepository->delete($request->id);
    }
}