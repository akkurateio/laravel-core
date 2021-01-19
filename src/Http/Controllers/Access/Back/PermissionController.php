<?php

namespace Akkurate\LaravelCore\Http\Controllers\Access\Back;

use Akkurate\LaravelCore\Forms\Access\Permission\PermissionAbstractForm;
use Akkurate\LaravelCore\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\FormBuilder;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index($uuid)
    {
        $permissions = Permission::orderBy('name')
            ->paginate(pagination());

        return view('access::permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FormBuilder $formBuilder
     * @return View
     */
    public function create($uuid, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PermissionAbstractForm::class, [
            'method' => 'POST',
            'url' => route('brain.access.permissions.store', ['uuid' => $uuid]),
            'id' => 'permissionForm'
        ]);

        return view('access::permissions.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store($uuid, Request $request)
    {
        Permission::create([
            'name' => $request['name'],
        ]);

        return redirect()->route('brain.access.permissions.index', ['uuid' => $uuid])
            ->withSuccess(trans('Permission') . ' ' . trans('créée avec succès'));
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     * @param $permissionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($uuid, $permissionId)
    {
        $permission = Permission::where('id', $permissionId)->first();

        if (empty($permission)) {
            return back()->withError('Aucune permission trouvée');
        }
        
        return redirect()->route('brain.access.permissions.edit', ['permission' => $permission, 'uuid' => $uuid]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FormBuilder $formBuilder
     * @param $permissionId
     * @return View
     */
    public function edit($uuid, FormBuilder $formBuilder, $permissionId)
    {
        $permission = Permission::where('id', $permissionId)->first();

        if (empty($permission)) {
            return back()->withError('Aucune permission trouvée');
        }
        
        $form = $formBuilder->create(PermissionAbstractForm::class, [
            'method' => 'PUT',
            'url' => route('brain.access.permissions.update', ['permission' => $permission, 'uuid' => $uuid]),
            'model' => $permission,
            'id' => 'permissionForm'
        ]);

        return view('access::permissions.edit', compact('permission', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $permissionId
     * @return Response
     */
    public function update($uuid, Request $request, $permissionId)
    {
        $permission = Permission::where('id', $permissionId)->first();

        if (empty($permission)) {
            return back()->withError('Aucune permission trouvée');
        }

        $name = $request->validate([
            'name' => 'string|required',
        ]);

        $permission->update($name);

        return redirect()->route('brain.access.permissions.index', ['uuid' => $uuid])
            ->withSuccess(trans('Permission') . ' ' . trans('mise à jour avec succès'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $permissionId
     * @return Response
     * @throws Exception
     */
    public function destroy($uuid, $permissionId)
    {
        $permission = Permission::where('id', $permissionId)->first();

        if (empty($permission)) {
            return back()->withError('Aucune permission trouvée');
        }

        $permission->delete();

        return back()->withSuccess(trans('Permission') . ' ' . trans('supprimée avec succès'));
    }

    /**
     * Give permission to a model
     *
     * @param $uuid
     * @param $modelUuid
     * @param Request $request
     * @return Response
     */
    public function givePermission($uuid, $modelUuid, Request $request)
    {
        $model = user()->where('uuid', $modelUuid)->first();
        if (empty($model)) {
            $model = account()->where('uuid', $modelUuid)->first();
        }
        if (empty($model)) {
            return back()->withError(trans('Aucun model trouvé'));
        }

        $permission = $request->validate([
            'permission' => 'required'
        ]);

        $model->permissions()->sync($permission);

        return back()->withSuccess(trans('Permission accordée avec succès'));
    }

    /**
     * Give permission to a model
     *
     * @param $uuid
     * @param $modelUuid
     * @param Request $request
     * @return Response
     */
    public function revokePermission($uuid, $modelUuid, Request $request)
    {
        $model = user()->where('uuid', $modelUuid)->first();
        if (! $model) {
            $model = account()->where('uuid', $modelUuid)->first();
        }
        if (! $model) {
            return back()->withError(trans('Aucun model trouvé'));
        }

        $permission = $request->validate([
            'permission' => 'required'
        ]);

        $model->revokePermissionTo($permission);

        return back()->withSuccess(trans('Permission révoquée avec succès'));
    }
}
