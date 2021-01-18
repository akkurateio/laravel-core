<?php

namespace Akkurate\LaravelCore\Http\Controllers\Access\Api;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Http\Resources\Access\Permission as PermissionResource;
use Akkurate\LaravelCore\Http\Resources\Access\PermissionCollection;
use Akkurate\LaravelAccountSubmodule\Models\Account;
use Akkurate\LaravelAccountSubmodule\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\QueryBuilder\QueryBuilder;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
     * Display a listing of the resource.
     *
     * @return PermissionCollection
     */
    public function index()
    {
        return new PermissionCollection(
            QueryBuilder::for(Permission::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->allowedIncludes([])
            ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return PermissionResource
     */
    public function store(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  $uuid
     * @param  Permission $permission
     * @return PermissionResource
     */
    public function show($uuid, Permission $permission)
    {
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $uuid
     * @param  Request  $request
     * @param  Permission  $permission
     * @return PermissionResource
     */
    public function update($uuid, Permission $permission, Request $request)
    {
        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $uuid
     * @param  Permission  $permission
     * @return JsonResponse
     */
    public function destroy($uuid, Permission  $permission)
    {
        $permission->delete();

        return response()->json(null, 204);
    }

    /**
     * Give permission to a model
     *
     * @param $uuid
     * @param Permission $permission
     * @param $modelUuid
     * @return JsonResponse
     */
    public function givePermission($uuid, Permission $permission, $modelUuid)
    {
        $model = User::where('uuid', $modelUuid)->first();
        if (! $model) {
            $model = Account::where('uuid', $modelUuid)->first();
        }
        if (! $model) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun model trouvé'
            ], 400);
        }

        $model->givePermissionTo($permission);

        return response()->json([
            'status' => 'success',
            'message' => 'Permission accordée avec succès'
        ], 200);
    }

    /**
     * Give permission to a model
     *
     * @param $uuid
     * @param Permission $permission
     * @param $modelUuid
     * @return JsonResponse
     */
    public function revokePermission($uuid, Permission $permission, $modelUuid)
    {
        $model = User::where('uuid', $modelUuid)->first();
        if (! $model) {
            $model = Account::where('uuid', $modelUuid)->first();
        }
        if (! $model) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun model trouvé'
            ], 400);
        }

        $model->revokePermissionTo($permission);

        return response()->json([
            'status' => 'success',
            'message' => 'Permission révoquée avec succès'
        ], 200);
    }
}
