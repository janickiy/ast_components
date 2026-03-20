<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\DTO\InvitesCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Invite\SendRequest;
use App\Models\Invites;
use App\Models\Seo;
use App\Repositories\InvitesRepository;
use App\Services\InvitesService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvitesController extends Controller
{
    public function __construct(
        private readonly InvitesRepository $invitesRepository,
        private readonly InvitesService $invitesService,
    ) {
    }

    public function index(): View
    {
        $seo = Seo::getSeo('frontend.invite', 'Пригласить АСТ Компонентс к участию в тендере');

        return view('frontend.invite.index', [
            'meta_description' => $seo['meta_description'],
            'meta_keywords' => $seo['meta_keywords'],
            'meta_title' => $seo['meta_title'],
            'h1' => $seo['h1'],
            'seo_url_canonical' => $seo['seo_url_canonical'],
            'options' => Invites::getPlatformList(),
            'title' => $seo['title'],
        ]);
    }

    public function add(SendRequest $request): RedirectResponse
    {
        try {
            $this->invitesService->notify($request);

            $this->invitesRepository->add(new InvitesCreateData(
                name: $request->input('name'),
                company: $request->input('company'),
                email: $request->input('email'),
                phone: $request->input('phone'),
                message: $request->input('message'),
                ip: $request->ip(),
                numb: $request->input('numb'),
                platform: $request->input('platform'),
            ));
        } catch (Exception $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Не удалось создать запрос номенклатуры. Попробуйте позже.' . $exception->getMessage());
        }

        return back()
            ->with('success', 'Ваше приглашение успешно отправлено');
    }
}