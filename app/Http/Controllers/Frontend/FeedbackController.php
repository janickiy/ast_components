<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\DTO\FeedbackCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contacts\FeedbackRequest;
use App\Models\Seo;
use App\Repositories\FeedbackRepository;
use App\Services\FeedbackService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __construct(
        private readonly FeedbackRepository $feedbackRepository,
        private readonly FeedbackService $feedbackService,
    ) {
    }

    public function index(): View
    {
        $seo = Seo::getSeo('frontend.contacts', 'Контакты');

        return view('frontend.contacts', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'title' => $seo['title'],
        ]);
    }

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
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Ошибка отправки сообщения.');
        }

        return back()
            ->with('success', 'Ваш запрос успешно отправлен');
    }
}