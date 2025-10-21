<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function __invoke(): View
    {
        return view('cp.feedback.index')->with('title', 'Сообщения с сайта');
    }
}