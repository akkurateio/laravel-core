<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Back;

use Akkurate\LaravelCore\Forms\Admin\User\UserSearchForm;
use Akkurate\LaravelCore\Forms\Admin\User\UserUpdateForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Models\Language;
use Akkurate\LaravelCore\Repositories\Admin\UsersRepository;
use Akkurate\LaravelCore\Rules\Firstname;
use Akkurate\LaravelCore\Rules\Lastname;
use Akkurate\LaravelAccountSubmodule\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @param UsersRepository $repository
     * @return View
     */
    public function index(Request $request, FormBuilder $formBuilder, UsersRepository $repository)
    {
        $form = $formBuilder->create(UserSearchForm::class, [
            'method' => 'GET',
            'url' => route('brain.admin.users.index', ['uuid' => $request->uuid]),
            'id' => 'userSearchForm'
        ]);
        $q = (string)request('q');
        $statusFilter = request('status') && request('status') != 'all';
        $accountFilter = request('account') && request('account') != 0;
        $roleFilter = request('role') && request('role') != 'all';
        $search = $q || $statusFilter || $accountFilter || $roleFilter;
        $searchResults = $repository->search($q);
        $all = User::FromAdministrableAccount()->get()->mapToGroups(function ($item, $key) {
            return [substr($item['lastname'], 0, 1) => $item];
        })->sortKeys();

        $lastUpdated = User::fromAdministrableAccount()->orderBy('updated_at', 'desc')->take(pagination())->get();
        $lastCreated = User::fromAdministrableAccount()->orderBy('created_at', 'desc')->take(pagination())->get();

        return view('admin::back.users.search', compact('form', 'q', 'search', 'searchResults', 'all', 'lastUpdated', 'lastCreated'));
    }

    public function show($uuid, $userId)
    {
        if (config('laravel-i18n')) {
            $user = User::where('id', $userId)->with(['preference.language'])->first();
        } else {
            $user = User::where('id', $userId)->first();
        }

        if (empty($user)) {
            return back()->withError('Utilisateur introuvable');
        }

        return view('admin::back.users.show', compact('user'));
    }

    public function edit($uuid, FormBuilder $formBuilder, $userId)
    {
        if (config('laravel-i18n')) {
            $user = User::where('id', $userId)->with(['preference.language'])->first();
        } else {
            $user = User::where('id', $userId)->first();
        }
        if (empty($user)) {
            return back()->withError('Utilisateur introuvable');
        }

        $form = $formBuilder->create(UserUpdateForm::class, [
            'method' => 'PUT',
            'url' => route('brain.admin.users.update', ['uuid' => $uuid, 'user' => $user]),
            'id' => 'userForm',
            'model' => $user
        ]);

        $roles = Role::all();

        return view('admin::back.users.edit', compact('user', 'form', 'roles'));
    }

    public function update($uuid, Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();

        if (empty($user)) {
            return back()->withError('Utilisateur introuvable');
        }

        $validated = $request->validate([
            'firstname' => ['required', 'string', 'min:2', 'max:255', new Firstname],
            'lastname' => ['required', 'string', 'min:2', 'max:255', new Lastname],
            'email' => 'required|email:dns|max:255|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date',
            'account_id' => 'required|integer',
        ]);

        $user->update(array_merge($validated, ['is_active' => $request->filled('is_active')]));

        if (config('laravel-media')) {
            $user->syncResources($request);
        }

        if ($request['roles']) {
            $this->assignRole($uuid, $request, $user->id);
        }

        if (config('laravel-i18n')) {
            $language = Language::where('id', $request->language)->first();
            if (! empty($language)) {
                $user->preference()->update([
                    'language_id' => $language->id
                ]);
            }
        } else {
            $user->preference()->update([
                'pagination' => $request->pagination,
            ]);
        }

        return redirect()->route('brain.admin.users.show', ['user' => $user, 'uuid' => $uuid])
            ->withSuccess(trans('Utilisateur') . ' ' . trans('mis à jour avec succès'));
    }

    public function assignRole($uuid, Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();

        if (empty($user)) {
            return back()->withError('Utilisateur introuvable');
        }

        $roles = $request->roles;
        $user->syncRoles($roles);
    }

    public function toggle(User $user)
    {
        $user->update([
            'is_active' => ! $user->is_active
        ]);

        return back();
    }

    /**
     * Revoke the given user from the app.
     *
     * @param $uuid
     * @param $userId
     * @param Request $request
     * @return mixed
     */
    public function destroy($uuid, Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();

        if (empty($user)) {
            return back()->withError(__('Utilisateur introuvable'));
        }

        $user->update([
            'deleted_at' => Carbon::now()->format('Y:m:d H:i:s')
        ]);

        return redirect()->route('brain.admin.users.index', ['uuid' => $uuid])->withSuccess(__('Utilisateur révoqué'));
    }
}
