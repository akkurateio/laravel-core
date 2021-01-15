<?php

namespace Akkurate\LaravelCore\Http\Controllers\Admin\Api;

use Akkurate\LaravelCore\Http\Controllers\Controller;
use Akkurate\LaravelCore\Http\Requests\Admin\User\UpdateUserRequest;
use Akkurate\LaravelCore\Http\Resources\Admin\User as UserResource;
use Akkurate\LaravelCore\Http\Resources\Admin\UserCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     * @return UserCollection
     *
     */
    public function index()
    {
        return new UserCollection(
            QueryBuilder::for(User::class)
            ->fromAdministrableAccount()
            ->allowedFilters([
                'account_id',
                'firstname',
                'lastname',
                'email',
                'created_at',
                'is_active',
                AllowedFilter::scope('search'),
                AllowedFilter::trashed()
            ])
            ->allowedSorts(['account_id', 'firstname', 'lastname', 'email', 'is_active', 'created_at'])
            ->allowedIncludes(['permissions','roles','account','phones','addresses','emails'])
            ->jsonPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     * @param  User $user
     * @return UserResource
     */
    public function show($uuid, User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  User $user
     * @return UserResource
     */
    public function update($uuid, UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     * @param $userId
     * @return JsonResponse
     */
    public function destroy($uuid, $userId)
    {
        $user = User::where('id', $userId)->firstOrFail();

        if (auth()->user()->account->id != $user->account->id) {
            return response()->json(['message' => 'You are not authorized to delete this user'], 403);
        }

        $user->delete();

        return response()->json(['message' => "$user->fullname has been deleted"], 204);
    }
}
