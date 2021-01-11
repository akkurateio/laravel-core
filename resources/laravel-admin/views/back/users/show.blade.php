@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => __('Utilisateurs'),
        'package' => 'admin',
        'label' => __(config('laravel-admin.label') ?? 'Admin')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent

@stop

@section('content')

    @component('back::atomicdesign.moleculs.left-body-right', [
    ])

        @slot('body')
            @if(View::exists('admin::users.viewer'))
                <div class="inner">
                    @include('admin::users.viewer')
                </div>
            @else
                @if(config('laravel-admin.options.sign') == true)
                    <akk-sidebar-group title="{{ __('Signature électronique') }}">
                        <template v-slot:icon>
                            <Icon name="Identification"/>
                        </template>
                        <template v-slot:container>
                            @include('admin::back.users.includes.signature')
                        </template>
                    </akk-sidebar-group>
                @endif
            @endif

            {{--            <akk-sidebar-group title="{{ __('Account') }}">--}}
            {{--                <template v-slot:icon>--}}
            {{--                    <Icon name="Enterprise"/>--}}
            {{--                </template>--}}
            {{--                <template v-slot:container>--}}
            {{--                    <div class="px-4">--}}
            {{--                        @if($user->account)--}}
            {{--                            <a href="{{ route('brain.admin.accounts.edit', ['account' => $user->account, 'uuid' => request('uuid')]) }}">{{ $user->account->name }}</a>--}}
            {{--                        @else--}}
            {{--                            {{ __('Aucun compte associé') }}--}}
            {{--                        @endif--}}
            {{--                    </div>--}}
            {{--                </template>--}}
            {{--            </akk-sidebar-group>--}}

            <akk-sidebar-group title="{{ __('Préférences') }}">
                <template v-slot:icon>
                    <Icon name="Settings"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="text-2xs text-neutral">{{ __('Langue') }}</div>
                                <div class="">{{ __($user->preference->language->locale_php) }}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-2xs text-neutral">{{ __('Nombre d’entrées par page') }}</div>
                                <div class="">{{ $user->preference->pagination }}</div>
                            </div>
                        </div>
                    </div>
                </template>
            </akk-sidebar-group>

            <akk-sidebar-group title="{{ __('Rôle(s)') }}" wrapper-class="mb-5">
                <template v-slot:icon>
                    <Icon name="Events"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <ul class="list-group list-group-flush">
                            @foreach ($user->getRoleNames() as $key => $role)
                                <li class="list-group-item bg-transparent {{ $key > 0 ? 'border-top border-gray-100' : '' }} border-bottom-0 d-flex align-items-center px-2 py-1">
                                    <i class="icon success mr-2">
                                        <Icon name="CheckmarkOutline"/>
                                    </i>
                                    <span class="text-xs">{{ $role }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </template>
            </akk-sidebar-group>

            <akk-sidebar-group title="{{ __('Permissions via les rôles') }}" wrapper-class="mb-5">
                <template v-slot:icon>
                    <Icon name="Events"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <ul class="list-group list-group-flush">
                            @foreach ($user->getPermissionsViaRoles() as $key => $permission)
                                <li class="list-group-item bg-transparent {{ $key > 0 ? 'border-top border-gray-100' : '' }} border-bottom-0 d-flex align-items-center px-2 py-1">
                                    <i class="icon success mr-2">
                                        <Icon name="CheckmarkOutline"/>
                                    </i>
                                    <span class="text-xs">{{ $permission->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </template>
            </akk-sidebar-group>
            <akk-sidebar-group title="{{ __('Permissions directes') }}">
                <template v-slot:icon>
                    <Icon name="Events"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <ul class="list-group list-group-flush">
                            @foreach ($user->getDirectPermissions() as $key => $permission)
                                <li class="list-group-item bg-transparent {{ $key > 0 ? 'border-top border-gray-100' : '' }} border-bottom-0 d-flex align-items-center px-2 py-1">
                                    <i class="icon success mr-2">
                                        <Icon name="CheckmarkOutline"/>
                                    </i>
                                    <span class="text-xs">{{ $permission->name }}</span>
                                    <form class="ml-auto"
                                          action="{{ route('brain.access.permission.revoke', ['modelUuid' => $user->uuid, 'permission' => $permission, 'uuid' => request('uuid')]) }}"
                                          method="post">
                                        @csrf
                                        <button class="btn btn-sm d-flex justify-content-center align-items-center"
                                                type="submit">
                                            <i class="icon primary">
                                                <Icon name="Delete"/>
                                            </i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        <form action="{{ route('brain.access.permission.give', ['modelUuid' => $user->uuid, 'uuid' => request('uuid')]) }}"
                              method="post">
                            @csrf
                            <div class="input-group input-group-sm">
                                <select class="custom-select custom-select-sm" id="permission" name="permission">
                                    @foreach (\Spatie\Permission\Models\Permission::orderBy('name')->get() as $permission)
                                        <option value="{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">{{ __("Ajouter") }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </akk-sidebar-group>
        @endslot

        @slot('left')
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route("brain.admin.users.index", uuid()) }}"
                   class="icon-box icon primary">
                    <Icon name="ArrowLeft"/>
                </a>
                @if ($user->is_active)
                    <div class="h-unit pr-3 icon success d-flex align-items-center text-success">
                        <Icon name="Awake"></Icon>
                        <span class="ml-2">Actif</span>
                    </div>
                @else
                    <div class="h-unit pr-3 icon gray d-flex align-items-center text-muted">
                        <Icon name="Asleep"></Icon>
                        <span class="ml-2">Inactif</span>
                    </div>
                @endif
            </div>
            <div class="inner">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    @if ($user->getThumb())
                        <img src="{{ $user->getThumb() }}" width="64" class="rounded-full"/>
                    @else
                        @if (config('app.gravatar'))
                            <img class="rounded-full"
                                 src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src(auth()->user()->email, 128) }}"
                                 width="64"/>
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" width="128" class="rounded-full"/>
                        @endif
                    @endif
                </div>
                <div class="text-center mb-5">
                    <div class="text-xl font-medium">
                        {{ $user->firstname && $user->lastname ? $user->fullname : __('Guest') }}
                    </div>
                    <div class="mb-4">
                        @if($user->account)
                            <a href="{{ route('brain.admin.accounts.edit', ['account' => $user->account, 'uuid' => request('uuid')]) }}">{{ $user->account->name }}</a>
                        @else
                            {{ __('Aucun compte associé') }}
                        @endif
                    </div>
                    <div class="text-xs mb-3">
                        {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        @if ($user->birth_date)
                            <div class="text-3xs text-muted">{{ __('Date de naissance') }}</div>
                            <div class="font-medium">{{ \Illuminate\Support\Carbon::create($user->birth_date)->format('d/m/Y') }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-3xs text-muted">{{ __('Créé le') }}</div>
                        <div class="font-medium">{{ $user->created_at->format('d/m/Y') }}</div>
                    </div>

                    {{--                <a href="{{  }}" class="btn btn-link">--}}
                    {{--                    <i class="icon">--}}
                    {{--                        <Edit />--}}
                    {{--                    </i>--}}
                    {{--                </a>--}}
                </div>
            </div>
        @endslot

        @slot('footer')
            @component('back::atomicdesign.components.view-footer', [
                'backPath' => route('brain.admin.accounts.index', [
                    'uuid' => request('uuid') ?? auth()->user()->account->uuid
                ]),
                'editLabel' => __('Mettre à jour'),
                'editPath' => route('brain.admin.users.edit', [
                    'user' => $user,
                    'uuid' => request('uuid')
                ]),
            ])@endcomponent
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
