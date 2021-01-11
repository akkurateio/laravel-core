@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => __('Comptes'),
        'package' => 'admin',
        'label' => __(config('laravel-admin.label') ?? 'Admin')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent

@stop

@section('content')

    @component('back::atomicdesign.moleculs.left-body-right', [
        'form' => $form,
    ])

        @slot('body')
            <akk-sidebar-group title="{{ __('Coordonnées') }}">
                <template v-slot:icon>
                    <Icon name="Identification"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <crm-emails
                                parent-props="{{ json_encode(['origin' => 'Akkurate', 'namespace' => 'LaravelAdmin', 'type' => 'Account', 'id' => $account->id]) }}"></crm-emails>
                        <crm-phones
                                parent-props="{{ json_encode(['origin' => 'Akkurate', 'namespace' => 'LaravelAdmin', 'type' => 'Account', 'id' => $account->id]) }}"></crm-phones>
                    </div>
                </template>
            </akk-sidebar-group>

            <akk-sidebar-group title="{{ __('Statut') }}">
                <template v-slot:icon>
                    <Icon name="Awake"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <div class="form-group custom-control custom-checkbox">
                            <input class="custom-control-input" id="is_active" pattern="0|1"
                                   title="The Active field must be true or false."
                                   {{ $account->is_active ? 'checked' : '' }} name="is_active" type="checkbox"
                                   value="{{ $account->is_active }}">
                            <label for="is_active" class="custom-control-label">{{ __('Actif') }}</label>
                        </div>
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
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="language" class="control-label mb-2">{{ __('Langue') }}</label>
                                    <select class="custom-select custom-select-sm" name="language" id="language">
                                        @foreach(\Akkurate\LaravelCore\Models\Language::where('is_active', 1)->get() as $language)
                                            <option value="{{ $language->id }}" {{ $account->preference->language->id === $language->id ? 'selected' : '' }}>{{ $language->locale }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="pagination" class="control-label mb-2">Pagination</label>
                                    <select class="custom-select custom-select-sm" name="pagination" id="pagination">
                                        <option value="10" {{ $account->preference->pagination === 10 ? 'selected' : '' }}>
                                            10
                                        </option>
                                        <option value="20" {{ $account->preference->pagination === 20 ? 'selected' : ''  }}>
                                            20
                                        </option>
                                        <option value="30" {{ $account->preference->pagination === 30 ? 'selected' : ''  }}>
                                            30
                                        </option>
                                        <option value="50" {{ $account->preference->pagination === 50 ? 'selected' : ''  }}>
                                            50
                                        </option>
                                        <option value="100" {{ $account->preference->pagination === 100 ? 'selected' : ''  }}>
                                            100
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </akk-sidebar-group>

            <akk-sidebar-group title="{{ __('Utilisateurs') }}">
                <template v-slot:icon>
                    <Icon name="Events"/>
                </template>
                <template v-slot:container>
                    <div class="px-4 pb-5">
                        <users
                                parent-props="{{ json_encode(['origin' => 'Akkurate', 'namespace' => 'LaravelCore', 'type' => 'Account', 'id' => $account->id, 'plural' => 'accounts']) }}"></users>
                    </div>
                </template>
            </akk-sidebar-group>
            {{--            <akk-sidebar-group title="{{ __('Commentaires') }}" body-wrapper-class="px-0">--}}
            {{--                <template v-slot:icon>--}}
            {{--                    <Icon name="Notebook"/>--}}
            {{--                </template>--}}
            {{--                <template v-slot:container>--}}
            {{--                    <exchange-notes--}}
            {{--                            parent-props="{{ json_encode(['origin' => 'Akkurate', 'namespace' => 'LaravelAdmin', 'type' => 'Account', 'id' => $account->id]) }}"></crm-notes>--}}
            {{--                </template>--}}
            {{--            </akk-sidebar-group>--}}
        @endslot

        @slot('left')
            <a href="{{ route("brain.admin.accounts.index", uuid()) }}"
               class="icon-box icon primary">
                <Icon name="ArrowLeft"/>
            </a>

            @component('back::atomicdesign.atoms.has-media', ['object' => $account, 'form' => $form, 'resource' => $account->getLastResource()])@endcomponent

            <div class="inner">
{{--                <crm-timeline-shortcuts--}}
{{--                        parent-props="{{ json_encode(['namespace' => 'Akkurate', 'package' => 'LaravelAdmin', 'model' => 'Account', 'id' => $account->id, 'account' => $account, 'hiddenType' => config('laravel-admin.hiddenType')]) }}"></crm-timeline-shortcuts>--}}

                {!! form_rest($form) !!}
            </div>
        @endslot

        @slot('footer')
            @component('back::atomicdesign.components.view-footer', ['backPath' => route('brain.admin.accounts.index', uuid()), 'saveLabel' => __('Sauvegarder'), 'form' => $form, 'item' => $account])@endcomponent
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
