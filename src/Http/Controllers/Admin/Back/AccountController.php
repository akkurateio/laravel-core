<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Akkurate\LaravelAccountSubmodule\Http\Requests\Account\CreateAccountRequest;
use Akkurate\LaravelAccountSubmodule\Http\Requests\Account\UpdateAccountRequest;
use Akkurate\LaravelContact\Models\Address;
use Akkurate\LaravelContact\Models\Email;
use Akkurate\LaravelContact\Models\Phone;
use Akkurate\LaravelContact\Models\Type;
use Akkurate\LaravelCore\Forms\Admin\Account\AccountCreateForm;
use Akkurate\LaravelCore\Forms\Admin\Account\AccountSearchForm;
use Akkurate\LaravelCore\Forms\Admin\Account\AccountUpdateForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Repositories\Admin\AccountsRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(accountClass(), 'account');
    }

    /**
     * Display a listing of the resource.
     * @param  $uuid
     * @param FormBuilder $formBuilder
     * @param AccountsRepository $repository
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function index($uuid, FormBuilder $formBuilder, AccountsRepository $repository)
    {
        $form = $formBuilder->create(AccountSearchForm::class, [
            'method' => 'GET',
            'url' => route('brain.admin.accounts.index', ['uuid' => $uuid]),
            'id' => 'accountSearchForm'
        ]);
        $q = (string)request('q');
        $search = $q ;
        $searchResults = $repository->search($q);
        $all = account()->administrable()->get()->mapToGroups(function ($item, $key) {
            return [strtoupper(substr($item['name'], 0, 1)) => $item];
        })->sortKeys();

        $lastUpdated = account()->administrable()->orderBy('updated_at', 'desc')->take(pagination())->get();
        $lastCreated = account()->administrable()->orderBy('created_at', 'desc')->take(pagination())->get();

        return view('admin::back.accounts.search', compact('form', 'q', 'search', 'searchResults', 'all', 'lastUpdated', 'lastCreated'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  $uuid
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(AccountCreateForm::class, [
            'method' => 'POST',
            'url' => route('brain.admin.accounts.store', ['uuid' => $uuid]),
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
        $account = account()->create($request->validated());

        $params = json_encode([
            'registry_siret' => $request['registry_siret'] ?? '',
            'registry_rcs' => $request['registry_rcs'] ?? '',
            'registry_intra' => $request['registry_intra'] ?? '',
            'capital' => $request['capital'] ?? '',
            'ape' => $request['ape'] ?? '',
            'legal_form_id' => class_exists(\Akkurate\LaravelBusiness\Models\LegalForm::class) ? \Akkurate\LaravelBusiness\Models\LegalForm::where('id', $request['legal_form_id'])->first()->name ?? '' : ''
        ]);

        $account->update([
            'params' => $params
        ]);

        if (config('laravel-contact')) {
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
        }

        $account->preference()->create();

        auth()->user()->accounts()->attach($account);

        return redirect()->route('brain.admin.accounts.edit', ['uuid' => $uuid, 'account' => $account])
            ->withSuccess(trans('Compte') . ' ' . trans('créé avec succès'));
    }

    public function show($uuid, $accountId)
    {
        $account = account()->where('id', $accountId)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        return redirect()->route('brain.admin.accounts.edit', ['account' => $account, 'uuid' => $uuid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $uuid
     * @param FormBuilder $formBuilder
     * @param $accountId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function edit($uuid, FormBuilder $formBuilder, $accountId)
    {
        $account = account()->where('id', $accountId)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        $form = $formBuilder->create(AccountUpdateForm::class, [
            'method' => 'PUT',
            'url' => route('brain.admin.accounts.update', ['account' => $account, 'uuid' => $uuid]),
            'id' => 'accountForm',
            'model' => $account
        ]);

        return view('admin::back.accounts.edit', compact('account', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $uuid
     * @param UpdateAccountRequest $request
     * @param $accountId
     * @return RedirectResponse
     */
    public function update($uuid, $accountId, UpdateAccountRequest $request)
    {
        $account = account()->where('id', $accountId)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        $account->update(array_merge(
            $request->validated(),
            ['is_active' => $request->filled('is_active')]
        ));

        if (config('laravel-media')) {
            $account->syncResources($request);
        }

        $account->preference->update([
            'pagination' => $request->pagination,
        ]);

        if (config('laravel-i18n')) {
            $account->preference->update([
                'language_id' => $request->language
            ]);
        }

        return redirect()
            ->back()
            ->withSuccess(trans('Compte') . ' ' . trans('mis à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $uuid
     * @param $accountId
     * @return RedirectResponse
     */
    public function destroy($uuid, $accountId)
    {
        $account = account()->where('id', $accountId)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        $account->delete();

        return redirect()->route('brain.admin.accounts.index', ['uuid' => $uuid])
            ->withSuccess(trans('Compte') . ' ' . trans('supprimé avec succès'));
    }

    public function toggle($accountId)
    {
        $account = account()->where('id', $accountId)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        $account->update([
            'is_active' => ! $account->is_active
        ]);

        return back();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTarget($uuid)
    {
        $account = account()->where('uuid', $uuid)->first();

        if (empty($account)) {
            return back()->withError('Aucun compte trouvé');
        }

        return response()->json($account->target(), 200);
    }
}
