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

    @component('back::atomicdesign.moleculs.left-body', [
        'form' => $form,
    ])

        @slot('left')
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route("brain.admin.users.index", ['uuid' => request('uuid')]) }}"
                   class="icon-box icon primary">
                    <Icon name="ArrowLeft"/>
                </a>
                {{--                <div class="dropdown">--}}
                {{--                    <a class="btn icon-box icon primary" href="#" role="button" id="dropdownMenuLink"--}}
                {{--                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                {{--                        <Icon name="OverflowMenuHorizontal"/>--}}
                {{--                    </a>--}}
                {{--                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">--}}
                {{--                                                <a class="dropdown-item"--}}
                {{--                                                   href="{{ route("brain.crm.companies.download.vcard", ["company" => $company, 'uuid' => request('uuid')]) }}">{{ __('Download VCard') }}</a>--}}
                {{--                                    <a class="dropdown-item" href="{{ route("brain.admin.$route.destroy", ["$param" => $item]) }}">{{ __('Supprimer') }}</a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>

            @if(config('laravel-media'))
                @component('back::atomicdesign.atoms.has-media', ['object' => $user, 'form' => $form, 'resource' => $user->getLastResource()])@endcomponent
            @endif

            <div class="inner mb-3">
                {!! form_row($form->gender) !!}
                {!! form_row($form->firstname) !!}
                {!! form_row($form->lastname) !!}
                {!! form_row($form->birth_date) !!}
                {!! form_row($form->email) !!}
            </div>
        @endslot

        @slot('body')
            <div class="w-50">
                {{--            <akk-sidebar-group title="{{ __('Coordonnées') }}">--}}
                {{--                <template v-slot:icon>--}}
                {{--                    <Icon name="Identification"/>--}}
                {{--                </template>--}}
                {{--                <template v-slot:container>--}}
                {{--                    <crm-emails--}}
                {{--                            parent-props="{{ json_encode(['origin' => '', 'namespace' => 'App', 'type' => 'User', 'id' => $user->id]) }}"></crm-emails>--}}
                {{--                    <crm-phones--}}
                {{--                            parent-props="{{ json_encode(['origin' => '', 'namespace' => 'App', 'type' => 'User', 'id' => $user->id]) }}"></crm-phones>--}}
                {{--                </template>--}}
                {{--            </akk-sidebar-group>--}}
                <akk-sidebar-group title="{{ __('Compte associé') }}">
                    <template v-slot:icon>
                        <Icon name="Identification"/>
                    </template>
                    <template v-slot:container>
                        <div class="px-4 pb-5">
                            {!! form_row($form->account_id) !!}
                        </div>
                    </template>
                </akk-sidebar-group>

                <akk-sidebar-group title="{{ __('Préférences') }}">
                    <template v-slot:icon>
                        <Icon name="Settings"/>
                    </template>
                    <template v-slot:container>
                        <div class="px-4 pb-5">
                            <div class="row">
                                @if(config('laravel-contact'))
                                    <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="language"
                                               class="control-label mb-2">{{ __('Langue') }}</label>
                                        <select class="custom-select custom-select-sm" name="language"
                                                id="language">
                                            @foreach(\Akkurate\LaravelCore\Models\Language::where('is_active', 1)->get() as $language)
                                                <option value="{{ $language->id }}" {{ $user->preference->language->id === $language->id ? 'selected' : '' }}>{{ $language->locale }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="pagination" class="control-label mb-2">Pagination</label>
                                        <select class="custom-select custom-select-sm" name="pagination"
                                                id="pagination">
                                            <option value="10" {{ $user->preference->pagination === 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="20" {{ $user->preference->pagination === 20 ? 'selected' : ''  }}>
                                                20
                                            </option>
                                            <option value="30" {{ $user->preference->pagination === 30 ? 'selected' : ''  }}>
                                                30
                                            </option>
                                            <option value="50" {{ $user->preference->pagination === 50 ? 'selected' : ''  }}>
                                                50
                                            </option>
                                            <option value="100" {{ $user->preference->pagination === 100 ? 'selected' : ''  }}>
                                                100
                                            </option>
                                            <option value="250" {{ $user->preference->pagination === 100 ? 'selected' : ''  }}>
                                                250
                                            </option>
                                            <option value="500" {{ $user->preference->pagination === 100 ? 'selected' : ''  }}>
                                                500
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </akk-sidebar-group>

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
                @can('admin')
                    <akk-sidebar-group title="{{ __('Statut') }}">
                        <template v-slot:icon>
                            <Icon name="Awake"/>
                        </template>
                        <template v-slot:container>
                            {{--                        <div class="form-group custom-control custom-checkbox">--}}
                            {{--                            <input class="custom-control-input" id="active" pattern="0|1"--}}
                            {{--                                   title="The Active field must be true or false."--}}
                            {{--                                   {{ $user->is_active ? 'checked' : '' }} name="active" type="checkbox"--}}
                            {{--                                   value="{{ $user->is_active }}">--}}
                            {{--                            <label for="active" class="custom-control-label">{{ __('Actif') }}</label>--}}
                            {{--                        </div>--}}
                            <div class="px-4 pb-5">
                                {!! form_row($form->is_active) !!}
                            </div>
                        </template>
                    </akk-sidebar-group>
                @endcan
                @can('access')
                    <akk-sidebar-group title="{{ __('Rôle(s)') }}">
                        <template v-slot:icon>
                            <Icon name="Events"/>
                        </template>
                        <template v-slot:container>
                            <div class="px-4 pb-5">
                                <div class="form-group">
                                    @foreach ($roles as $role)
                                        <div class="custom-control custom-checkbox">
                                            <input name="roles[]" type="checkbox" class="custom-control-input"
                                                   id="check{{ $role->name }}"
                                                   {{ $user->hasAnyRole([$role->name]) ? 'checked' : '' }} value="{{ $role->name }}">
                                            <label class="custom-control-label"
                                                   for="check{{ $role->name }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                    </akk-sidebar-group>
                @endcan
            </div>
        @endslot

        @slot('footer')
            @component('back::atomicdesign.components.view-footer', ['backPath' => route('brain.admin.users.index', uuid()), 'saveLabel' => __('Sauvegarder'), 'form' => $form, 'item' => $user])@endcomponent
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
