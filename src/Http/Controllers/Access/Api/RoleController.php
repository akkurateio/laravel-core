<?php

namespace Akkurate\LaravelCore\Http\Controllers\Access\Api;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Http\Resources\Access\Role as RoleResource;
use Akkurate\LaravelCore\Http\Resources\Access\RoleCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return RoleCollection
     */
    public function index()
    {
        return new RoleCollection(
            QueryBuilder::for(Role::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->allowedIncludes(['permissions'])
            ->jsonPaginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RoleResource
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  $uuid
     * @param  Role  $role
     * @return RoleResource
     */
    public function show($uuid, Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $uuid
     * @param  Request  $request
     * @param  Role  $role
     * @return RoleResource
     */
    public function update($uuid, Role $role, Request $request)
    {
        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $uuid
     * @param  Role  $role
     * @return JsonResponse
     */
    public function destroy($uuid, Role  $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }

    /**
     * Associate permission to role
     *
     * @param Role $role
     * @param Permission $permission
     * @return JsonResponse
     */
    public function givePermission($uuid, Role $role, Permission $permission)
    {
        $role->givePermissionTo($permission);

        return response()->json([
            'status' => 'success',
            'message' => 'Permission accordée avec succès'
        ], 200);
    }

    /**
     * Revoke permission from role
     *
     * @param Role $role
     * @param Permission $permission
     * @return JsonResponse
     */
    public function revokePermission($uuid, Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);

        return response()->json([
            'status' => 'success',
            'message' => 'Permission révoquée avec succès'
        ], 200);
    }
}
