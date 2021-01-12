<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Illuminate\Http\Request;
use Akkurate\LaravelCore\Models\Preference;
use Akkurate\LaravelCore\Http\Controllers\Controller;

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
        	'language_id' => $request->input('language_id')
		]);

		session()->put('locale', auth()->user()->preference->language->locale);

		return redirect('admin')
            ->withSuccess(trans('Preference').' '.trans('successfully updated!'));
    }

}
