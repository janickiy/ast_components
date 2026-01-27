<?php

namespace App\Http\Controllers\Frontend;


use App\DTO\FeedbackCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contacts\FeedbackRequest;
use App\Models\Seo;
use App\Repositories\FeedbackRepository;
use App\Services\FeedbackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Exception;

class FeedbackController extends Controller
{
    public function __construct(
        private FeedbackRepository $feedbackRepository,
        private FeedbackService $feedbackService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $seo = Seo::getSeo('frontend.contacts', 'Контакты');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        return view('frontend.contacts', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical'
            )
        )->with('title', $title);
    }

    /**
     * @param FeedbackRequest $request
     * @return RedirectResponse
     */
    public function send(FeedbackRequest $request): RedirectResponse
    {
        try {
            $this->feedbackService->notify($request);

            $this->feedbackRepository->add(new FeedbackCreateData(
                name: $request->input('name'),
                email: $request->input('email'),
                phone: $request->input('phone'),
                ip: $request->ip(),
                message: $request->input('message'),
            ));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Ошибка отправки сообщения.')
                ->withInput();
        }

        return redirect()->back()->with('success', 'Ваш запрос успешно отправлен');
    }
}