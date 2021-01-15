<?php

namespace Akkurate\LaravelCore\Http\Controllers\Me\Back;

use Akkurate\LaravelCore\Forms\Me\PreferencesForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

class PreferenceController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder)
    {
        $forms = [];

        $forms[] = (object)[
            'title' => 'Mes préférences utilisateur',
            'fields' => $formBuilder->create(PreferencesForm::class, [
                'method' => 'PUT',
                'url' => route('brain.me.preferences.update', ['uuid' => $uuid]),
                'id' => 'preferencesForm',
                'model' => auth()->user()->preference
            ])
        ];

        if (! empty(config('laravel-me.extends.preferences'))) {
            foreach (config('laravel-me.extends.preferences') as $formConfig) {
                if (isset($formConfig['guard']) && ! auth()->user()->can($formConfig['guard'])) {
                    continue;
                }
//                if (Route::has($formConfig['routeSubmit'])) {
                $forms[] = (object)[
                        'title' => $formConfig['title'],
                        'fields' => $formBuilder->create($formConfig['formClass'], [
                            'method' => 'PUT',
                            'url' => route($formConfig['routeSubmit'], ['uuid' => $uuid]),
                            'id' => $formConfig['formId']
                        ])
                    ];
//                }
            }
        }

        return view('me::back.preferences', compact('forms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($uuid, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pagination' => 'required|integer',
            'language_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.preferences.edit', ['uuid' => $uuid])
                ->withErrors($validator)
                ->withInput();
        }

        auth()->user()->preference->update($validator->validated());

        if (config('laravel-i18n')) {
            session()->put('locale', auth()->user()->preference->language->locale);
        }

        return redirect()->route('brain.me.preferences.edit', ['uuid' => $uuid])
            ->withSuccess(__('Vos préférences utilisateur ont été mises à jour avec succès'));
    }
}
