<?php

namespace Akkurate\LaravelCore\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect to brain when /admin.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        if (! Auth::user()) {
            return redirect()->route('login');
        }
        if (Auth::user()->account) {
            return redirect()->route('brain', ['uuid' => auth()->user()->account->slug]);
        } else {
            return redirect()->route('brain', ['uuid' => auth()->user()->uuid]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function brain(Request $request)
    {
        return view('core::back.dashboard');
    }
}
