<?php

namespace Akkurate\LaravelCore\Http\Controllers\Me\Back;

use Akkurate\LaravelCore\Forms\Me\User\CreateForm;
use Akkurate\LaravelCore\Forms\Me\User\UpdateForm;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Notifications\Me\InvitationNotification;
use Akkurate\LaravelCore\Rules\Firstname;
use Akkurate\LaravelCore\Rules\Lastname;
use Akkurate\LaravelAccountSubmodule\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use RegistersUsers;

    /**
     * Show the list of resources.
     *
     * @param $uuid
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function index($uuid)
    {
        $all = User::where('account_id', auth()->user()->account_id)
            ->get();

        return view('me::back.users.index', compact('all'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return Application|Factory|View|Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CreateForm::class, [
            'method' => 'POST',
            'url' => route('brain.me.users.store', uuid()),
            'id' => 'invitUserForm'
        ]);

        return view('me::back.users.create', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param Request $request
     * @return RedirectResponse
     */
    public function store($uuid, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255', new Firstname],
            'lastname' => ['required', 'string', 'max:255', new Lastname],
            'email' => 'required|email:dns|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.users.create', ['uuid' => $uuid])
                ->withErrors($validator)
                ->withInput();
        }

        $language = Language::where('is_default', true)->first();
        $userEmailAlreadyExist = User::where('email', $validator->validated()['email'])->withTrashed()->first();

        if (! empty($userEmailAlreadyExist) && $userEmailAlreadyExist->restore()) {
            $user = User::where('email', $validator->validated()['email'])->first();

            $user->preference()->updateOrCreate([
                'language_id' => $language->id
            ]);

            return redirect()
                ->route('brain.me.users.index', ['uuid' => $uuid])
                ->withSuccess(__($validator->validated()['firstname'] . ' ' . $validator->validated()['lastname'] . ' a été réactivé avec succès'));
        } else {
            $user = User::create([
                'firstname' => ucfirst($validator->validated()['firstname']),
                'lastname' => ucfirst($validator->validated()['lastname']),
                'email' => $validator->validated()['email'],
                'password' => Hash::make(config('app.default-password')),
                'account_id' => auth()->user()->account->id,
                'activation_token' => Str::random(60) . '_' . time(),
                'is_active' => false,
            ]);

            $user->assignRole(config('laravel-access.default_role'));

            if (config('laravel-me.send_invitation')) {
                $user->notify(new InvitationNotification($user->activation_token, $user, auth()->user()));
            }

            $user->preference()->updateOrCreate([
                'language_id' => $language->id
            ]);

            return redirect()
                ->route('brain.me.users.index', ['uuid' => $uuid])
                ->withSuccess(__('L’invitation a bien été envoyée à ' . $validator->validated()['email']));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $uuid
     * @param $userUuid
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function edit($uuid, $userUuid, FormBuilder $formBuilder)
    {
        $user = User::where('uuid', $userUuid)->first();

        if (empty($user)) {
            return back()->withError(__('Utilisateur introuvable'));
        }

        $form = $formBuilder->create(UpdateForm::class, [
            'method' => 'PUT',
            'url' => route('brain.me.users.update', ['uuid' => $uuid, 'userUuid' => $user->uuid]),
            'id' => 'userForm',
            'model' => $user
        ]);

        return view('me::back.users.edit', compact('form', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @param $userUuid
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($uuid, $userUuid, Request $request)
    {
        $user = User::where('uuid', $userUuid)->where('is_active', true)->first();

        if (empty($user)) {
            return back()->withError(__('Utilisateur inactif'));
        }

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('brain.me.users.edit', ['uuid' => $uuid, 'userUuid' => $user->uuid])
                ->withErrors($validator)
                ->withInput();
        }

        //Vérif sur le role déjà faite dans le formulaire
        $role = Role::where('id', $validator->validated()['role_id'])->first();
        $user->syncRoles($role);

        return redirect()
            ->route('brain.me.users.edit', ['uuid' => $uuid, 'userUuid' => $user->uuid])
            ->withSuccess(__('L’utilisateur a été mis à jour avec succès'));
    }

    /**
     * Revoke the given user from the app.
     *
     * @param $uuid
     * @param $userUuid
     * @param Request $request
     * @return mixed
     */
    public function softDelete($uuid, $userUuid, Request $request)
    {
        $user = User::where('uuid', $userUuid)->first();

        if (empty($user)) {
            return back()->withError(__('Utilisateur introuvable'));
        }

        $user->update([
            'deleted_at' => Carbon::now()->format('Y:m:d H:i:s')
        ]);

        return redirect()->route('brain.me.users.index', ['uuid' => $uuid])->withSuccess(__('Utilisateur révoqué'));
    }

    /**
     * @param $accountUuid
     * @param $userUuid
     * @return RedirectResponse
     */
    public function reinvit($accountUuid, $userUuid)
    {
        $user = User::where('uuid', $userUuid)->firstOrFail();

        $user->notify(new InvitationNotification($user->activation_token, $user, auth()->user()));

        return redirect()
            ->route('brain.me.users.index', ['uuid' => $accountUuid])
            ->withSuccess(__('L’invitation a bien été à nouveau envoyée à ' . $user->email));
    }

    /**
     * @param $accountUuid
     * @param $userUuid
     * @return RedirectResponse
     */
    public function toggle($accountUuid, $userUuid)
    {
        $user = User::where('uuid', $userUuid)->first();

        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back();
    }
}
