<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Api;

use Akkurate\LaravelContact\Models\Address;
use Akkurate\LaravelContact\Models\Email;
use Akkurate\LaravelContact\Models\Phone;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelAccountSubmodule\Http\Requests\Account\CreateAccountRequest;
use Akkurate\LaravelAccountSubmodule\Http\Requests\Account\UpdateAccountRequest;
use Akkurate\LaravelAccountSubmodule\Http\Resources\Account\Account as AccountResource;
use Akkurate\LaravelAccountSubmodule\Http\Resources\Account\AccountCollection;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(accountClass(), 'account');
    }

    /**
     * Display a listing of the resource.
     * @return AccountCollection
     *
     */
    public function index()
    {
        return new AccountCollection(
            QueryBuilder::for(accountClass())
            ->administrable()
            ->allowedFilters([
                'uuid',
                'name',
                'internal_reference',
                'is_active',
                AllowedFilter::exact('id'),
                AllowedFilter::scope('search'),
                AllowedFilter::scope('firstLevel')
            ])
            ->allowedSorts(['name'])
            ->allowedIncludes(['users', 'country', 'phones', 'addresses', 'emails', 'permissions','children'])
            ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @todo Refactoriser les store back et api (ils sont identiques)
     * @param $uuid
     * @param CreateAccountRequest $request
     * @return AccountResource
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
                    'type' => 'WORK',
                    'name' => $account->name,
                    'street1' => $request['street1'],
                    'street2' => $request['street2'] ?? '',
                    'street3' => $request['street3'] ?? '',
                    'zip' => $request['zip'],
                    'city' => $request['city'],
                    'addressable_type' => get_class($account),
                    'addressable_id' => $account->id
                ]);
                $account->update([
                    'address_id' => $address->id,
                ]);
            }

            if (! empty($request['number'])) {
                $phone = Phone::create([
                    'type' => 'WORK',
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
                    'type' => 'WORK',
                    'name' => $account->name,
                    'email' => $request['email'],
                    'emailable_type' => get_class($account),
                    'emailable_id' => $account->id
                ]);
                $account->update([
                    'email_id' => $email->id,
                ]);
            }
        }

        $account->preference()->create();

        auth()->user()->accounts()->attach($account);

        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param $accountId
     * @param UpdateAccountRequest $request
     * @return AccountResource
     */
    public function update($uuid, $accountId, UpdateAccountRequest $request)
    {
        $account = account()->where('id', $accountId)->firstOrFail();
        $account->update($request->validated());

        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     * @param $accountId
     * @return JsonResponse | AccountResource
     */
    public function show($uuid, $accountId)
    {
        $account = account()->where('id', $accountId)->firstOrFail();

        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     * @param $accountId
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($uuid, $accountId)
    {
        $account = account()->where('id', $accountId)->firstOrFail();
        
        if ($account->id === auth()->user()->account->id) {
            return response()->json([
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ]);
        }

        $account->delete();

        return response()->json(null, 204);
    }

    /**
     * @param $uuid
     * @param $accountId
     * @return JsonResponse
     */
    public function findUsers($uuid, $accountId)
    {
        $account = account()->where('id', $accountId)->firstOrFail();

        return response()->json($account->users, 200);
    }

    /**
     * @param $uuid
     * @param $accountId
     * @param Request $request
     * @return JsonResponse
     */
    public function attachUser($uuid, $accountId, Request $request)
    {
        $account = account()->where('id', $accountId)->firstOrFail();

        $account->users()->attach(user()->whereIn('id', $request->get('users'))->get());

        return response()->json($account, 200);
    }

    /**
     * @param $uuid
     * @param $accountId
     * @param Request $request
     * @return JsonResponse
     */
    public function detachUser($uuid, $accountId, Request $request)
    {
        $account = account()->where('id', $accountId)->firstOrFail();

        $account->users()->detach(user()->whereIn('id', $request->get('users'))->get());

        return response()->json($account, 200);
    }

    /**
     * @param $uuid
     * @return JsonResponse
     */
    public function getTarget($uuid)
    {
        $account = account()->where('uuid', $uuid)->firstOrFail();

        return response()->json($account->target(), 200);
    }
}
