<?php

namespace Akkurate\LaravelCore\Http\Controllers\Me\Back;

use Akkurate\LaravelCore\Forms\Me\PasswordForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

class PasswordController extends Controller
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
        $form = $formBuilder->create(PasswordForm::class, [
            'method' => 'PUT',
            'url' => route('brain.me.password.update', ['uuid' => $uuid]),
            'id' => 'passwordForm',
            'model' => auth()->user()->preference,
        ]);

        return view('me::back.password', compact('form'));
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
            'password_actual' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validator->after(function ($validator) {
            if (! Hash::check($validator->validated()['password_actual'], auth()->user()->password)) {
                $validator->errors()->add('password_actual', 'Votre mot de passe actuel n\'est pas valide !');
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.password.edit', ['uuid' => $uuid])
                ->withErrors($validator)
                ->withInput();
        }

        auth()->user()->update([
            'password' => Hash::make($validator->validated()['password']),
        ]);

        return redirect()->route('brain.me.password.edit', ['uuid' => $uuid])
            ->withSuccess(__('Votre mot de passe a été mis à jour avec succès'));
    }
}
