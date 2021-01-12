<?php

namespace Akkurate\LaravelCore\Http\Controllers\Me\Back;

use Akkurate\LaravelCore\Forms\Me\ProfileForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

class ProfileController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param  FormBuilder $formBuilder
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(ProfileForm::class, [
            'method' => 'PUT',
            'url' => route('brain.me.profile.update', ['uuid' => $uuid]),
            'id' => 'profileForm',
            'model' => auth()->user()
        ]);
        return view('me::back.profile', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param  Request $request
     * @return RedirectResponse
     */
    public function update($uuid, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gender' => 'required',
            'lastname' => 'required|max:255',
            'firstname' => 'required|max:255',
            'email' => 'required|email:dns|max:255|unique:users,email,' . auth()->user()->id,
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.profile.edit', ['uuid' => $uuid])
                ->withErrors($validator)
                ->withInput();
        }

        auth()->user()->update($validator->validated());

        return redirect()
            ->route('brain.me.profile.edit', ['uuid' => $uuid])
            ->withSuccess(__('Votre profil a été mis à jour avec succès'));
    }
}
