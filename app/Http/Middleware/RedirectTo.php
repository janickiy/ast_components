<?php

namespace App\Http\Middleware;


use App\Models\Redirect;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class RedirectTo
{
    /**
     * Creates a new instance of the middleware.
     *
     */
    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentURL = request()->path();
        $redirect = Redirect::where('from', $currentURL)->first();

        if ($redirect) {
            return redirect()->to($redirect->to, (int)$redirect->status);
        } else {
            return $next($request);
        }
    }
}