<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feedback;
use App\Repositories\FeedbackRepository;
use App\Http\Requests\Admin\Feedback\EditRequest;
use App\Http\Requests\Admin\Feedback\DeleteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __construct(private FeedbackRepository $feedbackRepository)
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.feedback.index')->with('title', 'Сообщения с сайта');
    }


    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $row = $this->feedbackRepository->find($id);

        if (!$row) abort(404);

        $options = Feedback::getOption();

        return view('cp.feedback.edit', compact('row', 'options'))->with('title', 'Редактирование');
    }

    /**
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
        $this->feedbackRepository->updateWithMapping($request->id, $request->all());

        return redirect()->route('admin.feedback.index')->with('success', 'Данные обновлены');
    }

    /**
     * @param DeleteRequest $request
     * @return void
     */
    public function destroy(DeleteRequest $request): void
    {
        $this->feedbackRepository->delete($request->id);
    }
}