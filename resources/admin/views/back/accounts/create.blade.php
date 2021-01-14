@extends('back::layouts.abstract', ['interface' => 'blank'])

@section('header')
    <div class="text-2xl font-bold my-3">Créer un compte</div>
    @component('back::atomicdesign.atoms.exit', [
        'exitRoute' => route("brain.admin.accounts.index", uuid())
    ])@endcomponent
@stop

@section('content')
    {!! form_start($form) !!}
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8">
                <div class="mb-5">
                    <div class="text-lg font-medium mb-2">Informations de base</div>
                    <div class="row justify-content-end">
                        <div class="col-12 col-sm-9">
                            {!! form_row($form->name) !!}
                            {!! form_row($form->website) !!}
                            @if (config('laravel-admin.account_internal_reference'))
                                {!! form_row($form->internal_reference) !!}
                            @endif
                            @if (config('laravel-contact'))
                                {!! form_row($form->email) !!}
                                {!! form_row($form->number) !!}
                            @endif
                        </div>
                    </div>
                </div>

                @if (config('laravel-admin.account_legal_info'))
                    <div class="mb-5">
                    <div class="text-lg font-medium mb-2">Informations légales</div>
                    <div class="row justify-content-end">
                        <div class="col-12 col-sm-9">
                            <div class="row">
                                <div class="col-6">
                                    {!! form_row($form->registry_rcs) !!}
                                </div>
                                <div class="col-6">
                                    {!! form_row($form->registry_siret) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    {!! form_row($form->registry_intra) !!}
                                </div>
                                @if(config('laravel-business'))
                                    <div class="col-6">
                                        {!! form_row($form->legal_form_id) !!}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    {!! form_row($form->capital) !!}
                                </div>
                                <div class="col-6">
                                    {!! form_row($form->ape) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mb-5">
                    @if(config('laravel-contact'))
                    <div class="text-lg font-medium mb-2">Coordonnées</div>
                    <div class="row justify-content-end">
                        <div class="col-12 col-sm-9">
                            {!! form_row($form->street1) !!}
                            {!! form_row($form->street2) !!}
                            {!! form_row($form->street3) !!}
                            <div class="row">
                                <div class="col-3">
                                    {!! form_row($form->zip) !!}
                                </div>
                                <div class="col-9">
                                    {!! form_row($form->city) !!}
                                </div>
                            </div>
                            @if(config('laravel-i18n'))
                                {!! form_row($form->country_id) !!}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row justify-content-end">
                    <div class="col-12 col-sm-9">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Créer le compte') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! form_end($form) !!}

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
