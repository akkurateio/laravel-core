<?php

namespace Akkurate\LaravelCore\Http\Controllers\Me\Back;

use Akkurate\LaravelBusiness\Models\LegalForm;
use Akkurate\LaravelContact\Models\Address;
use Akkurate\LaravelContact\Models\Email;
use Akkurate\LaravelContact\Models\Phone;
use Akkurate\LaravelContact\Models\Type;
use Akkurate\LaravelCore\Forms\Me\AccountForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Http\Requests\Admin\Account\CreateAccountRequest;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelAccountSubmodule\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

class AccountController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  $uuid
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AccountForm::class, [
            'method' => 'POST',
            'url' => route('brain.me.account.store', ['uuid' => $uuid]),
            'id' => 'accountForm'
        ]);

        return view('admin::back.accounts.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     * @param CreateAccountRequest $request
     * @return RedirectResponse
     */
    public function store($uuid, CreateAccountRequest $request)
    {
        $account = Account::create($request->validated());

        $params = json_encode([
            'registry_siret' => $request['registry_siret'] ?? '',
            'registry_rcs' => $request['registry_rcs'] ?? '',
            'registry_intra' => $request['registry_intra'] ?? '',
            'capital' => $request['capital'] ?? '',
            'ape' => $request['ape'] ?? '',
            'legal_form_id' => LegalForm::where('id', $request['legal_form_id'] ?? null)->first()->name ?? ''
        ]);

        $account->update([
            'params' => $params
        ]);

        if (! empty($request['street1']) && ! empty($request['zip']) && ! empty($request['city'])) {
            $address = Address::create([
                'type_id' => Type::where('code', 'WORK')->first()->id,
                'name' => $account->name,
                'street1' => $request['street1'],
                'street2' => $request['street2'],
                'street3' => $request['street3'],
                'zip' => $request['zip'],
                'city' => $request['city'],
                'addressable_type' => get_class($account),
                'addressable_id' => $account->id
            ]);
            $account->update([
                'address_id' => $address->id
            ]);
        }

        if (! empty($request['number'])) {
            $phone = Phone::create([
                'type_id' => Type::where('code', 'WORK')->first()->id,
                'name' => $account->name,
                'number' => $request['number'],
                'phoneable_type' => get_class($account),
                'phoneable_id' => $account->id
            ]);
            $account->update([
                'phone_id' => $phone->id
            ]);
        }

        if (! empty($request['email'])) {
            $email = Email::create([
                'type_id' => Type::where('code', 'WORK')->first()->id,
                'name' => $account->name,
                'email' => $request['email'],
                'emailable_type' => get_class($account),
                'emailable_id' => $account->id
            ]);
            $account->update([
                'email_id' => $email->id
            ]);
        }

        $language = Language::where('locale', 'fr')->firstOrFail();

        $account->preference()->create([
            'language_id' => $language->id
        ]);

        auth()->user()->accounts()->attach($account);

        return redirect()
            ->route('brain.me.account.edit', ['uuid' => $uuid])
            ->withSuccess(__('Votre organisation a été créée avec succès'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param  FormBuilder $formBuilder
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AccountForm::class, [
            'method' => 'PUT',
            'url' => route('brain.me.account.update', ['uuid' => $uuid]),
            'id' => 'accountForm',
            'model' => auth()->user()->account
        ]);

        return view('me::back.account', compact('form'));
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
            'siren' => 'nullable|max:9',
            'name' => 'required|max:255',
            'website' => 'nullable|max:255',
            'internal_reference' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.account.edit', ['uuid' => $uuid])
                ->withErrors($validator)
                ->withInput();
        }

        auth()->user()->account->update($validator->validated());

        return redirect()
            ->route('brain.me.account.edit', ['uuid' => $uuid])
            ->withSuccess(__('Votre organisation a été mise à jour avec succès'));
    }
}
