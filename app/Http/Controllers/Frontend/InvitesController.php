<?php

namespace App\Http\Controllers\Frontend;

use App\DTO\InvitesCreateData;
use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Invite\SendRequest;
use App\Mail\InviteMailer;
use App\Models\Invites;
use App\Models\Seo;
use App\Repositories\InvitesRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Exception;

class InvitesController extends Controller
{
    public function __construct(private InvitesRepository $invitesRepository)
    {
    }

    /**
     * Запрос номенклатуры
     *
     * @return View
     */
    public function index(): View
    {
        $seo = Seo::getSeo('frontend.invite', 'Пригласить АСТ Компонентс к участию в тендере');
        $title = $seo['title'];
        $meta_description = $seo['meta_description'];
        $meta_keywords = $seo['meta_keywords'];
        $meta_title = $seo['meta_title'];
        $seo_url_canonical = $seo['seo_url_canonical'];
        $h1 = $seo['h1'];

        $options = Invites::getPlatformList();

        return view('frontend.invite.index', compact(
                'meta_description',
                'meta_keywords',
                'meta_title',
                'h1',
                'seo_url_canonical',
                'options',
            )
        )->with('title', $title);
    }

    /**
     * Добавляем запрос на номенклатуру
     *
     * @param SendRequest $request
     * @return RedirectResponse
     */
    public function add(SendRequest $request): RedirectResponse
    {
        try {
            $data = [
                'company' => $request->company,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'platform' => $request->input('platform'),
                'numb' => $request->input('numb'),
                'message' => $request->input('message'),
            ];

            Mail::to(explode(",", SettingsHelper::getInstance()->getValueForKey('EMAIL_NOTIFY')))->send(new InviteMailer($data));

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
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', 'Не удалось создать запрос номенклатуры. Попробуйте позже.' . $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->back()
            ->with('success', 'Ваше приглашение успешно отправлено');
    }
}