<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelAccountSubmodule\Models\Preference;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{

    /*
     * Request $request Preference $preference
     * @return Response
     */
    public function update(Request $request, Preference $preference)
    {
        $preference->update([
            'pagination' => $request->input('pagination'),
            'language_id' => $request->input('language_id') ?? null
        ]);

        if (config('laravel-i18n')) {
            session()->put('locale', auth()->user()->preference->language->locale);
        }

        return redirect('admin')
            ->withSuccess(trans('Preference').' '.trans('successfully updated!'));
    }
}
