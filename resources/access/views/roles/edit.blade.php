@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Permissions',
        'package' => 'access',
        'label' => __(config('laravel-access.label') ?? 'Accès')
    ])
        {{--                <div>Put what you want!</div>--}}
    @endcomponent

@stop

@section('content')

    @component('back::atomicdesign.moleculs.left-body', [
        'form' => $form,
    ])
        @slot('body')
            <akk-sidebar-group title="{{ __('Permissions') }}">
                <template v-slot:icon>
                    <Icon name="Locked"/>
                </template>
                <template v-slot:container>
                    <form action="{{ route('brain.access.roles.permission.give', ['role' => $role, 'uuid' => request('uuid')]) }}"
                          method="post" class="mb-4">
                        @csrf
                        <div class="form-group">
                            <label for="permission" class="control-label">{{ __('Ajouter une permission') }}</label>
                            <div class="input-group">
                                <select class="custom-select" id="permission" name="permission">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">{{ __("Ajouter") }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="font-medium mb-2">{{ __('Liste des permissions associées') }}</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($role->permissions as $permission)
                            <li class="list-group-item pr-0 bg-transparent d-flex justify-between {{ $loop->last ? 'border-0' : '' }}">
                                <span class="d-inline-flex align-items-center mr-auto">
                                    {{ $permission->name }}
                                </span>
                                <form action="{{ route('brain.access.roles.permission.revoke', ['role' => $role, 'permission' => $permission, 'uuid' => request('uuid')]) }}"
                                      method="post">
                                    @csrf
                                    <button class="btn btn-sm d-flex justify-content-center align-items-center"
                                            type="submit">
                                        <i class="icon primary">
                                            <Icon name="Close"/>
                                        </i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </template>
            </akk-sidebar-group>

{{--            <div class="inner">--}}
{{--                <pre>@json($role, JSON_PRETTY_PRINT)</pre>--}}
{{--            </div>--}}
        @endslot

        @slot('left')
            <a href="{{ route("brain.access.permissions.index", uuid()) }}"
               class="icon-box icon primary">
                <Icon name="ArrowLeft"/>
            </a>

            <div class="inner">
                {!! form_rest($form) !!}
            </div>
        @endslot

        @slot('footer')
            @component('back::atomicdesign.components.view-footer', ['backPath' => route('brain.access.permissions.index', uuid()), 'saveLabel' => __('Sauvegarder'), 'form' => $form, 'item' => $role])@endcomponent
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
