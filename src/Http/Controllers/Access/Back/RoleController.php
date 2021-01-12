<?php

namespace Akkurate\LaravelCore\Http\Controllers\Access\Back;

use Akkurate\LaravelCore\Forms\Access\Role\RoleAbstractForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index($uuid)
    {
        $roles = Role::orderBy('name')
            ->paginate(pagination());

        return view('access::roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(RoleAbstractForm::class, [
            'method' => 'POST',
            'url' => route('brain.access.roles.store', ['uuid' => $uuid]),
            'id' => 'roleForm',
        ]);

        return view('access::roles.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($uuid, Request $request)
    {
        $name = $request->validate([
            'name' => 'string|required',
        ]);

        Role::create($name);

        return redirect()->route('brain.access.roles.index', ['uuid' => $uuid])
            ->withSuccess(trans('Role') . ' ' . trans('créé(e) avec succès'));
    }

    /**
     * Display the specified resource.
     *
     * @param $roleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($uuid, $roleId)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }

        return redirect()->route('brain.access.roles.edit', ['role' => $role, 'uuid' => $uuid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormBuilder $formBuilder
     * @param $roleId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|View
     */
    public function edit($uuid, FormBuilder $formBuilder, $roleId)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }

        $form = $formBuilder->create(RoleAbstractForm::class, [
            'method' => 'PUT',
            'url' => route('brain.access.roles.update', ['role' => $role, 'uuid' => $uuid]),
            'model' => $role,
            'id' => 'roleForm',
        ]);
        $permissions = Permission::all();

        return view('access::roles.edit', compact('role', 'permissions', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $roleId
     * @return Response
     */
    public function update($uuid, Request $request, $roleId)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }

        $name = $request->validate([
            'name' => 'string|required',
        ]);

        $role->update($name);

        return redirect()->route('brain.access.roles.index', ['uuid' => $uuid])
            ->withSuccess(trans('Role') . ' ' . trans('mis(e) à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $roleId
     * @return Response
     * @throws Exception
     */
    public function destroy($uuid, $roleId)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }
        
        $role->delete();

        return back()->withSuccess(trans('Role') . ' ' . trans('supprimé(e) avec succès'));
    }

    /**
     * Associate permission to role
     *
     * @param $roleId
     * @param Request $request
     * @return Response
     */
    public function givePermission($uuid, $roleId, Request $request)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }
        $permission = $request->validate([
            'permission' => 'required',
        ]);

        $role->givePermissionTo($permission);

        return back()->withSuccess(trans('Permission accordée avec succès'));
    }

    /**
     * Revoke permission from role
     *
     * @param $uuid
     * @param $roleId
     * @param $permissionId
     * @return Response
     */
    public function revokePermission($uuid, $roleId, $permissionId)
    {
        $role = Role::where('id', $roleId)->first();

        if (empty($role)) {
            return back()->withError('Aucun rôle trouvé');
        }

        $permission = Permission::where('id', $permissionId)->first();

        if (empty($permission)) {
            return back()->withError('Aucune permission trouvée');
        }

        $role->revokePermissionTo($permission);

        return back()->withSuccess(trans('Permission révoquée avec succès'));
    }
}
