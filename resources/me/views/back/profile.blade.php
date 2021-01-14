@extends('back::layouts.abstract', ['interface' => auth()->user()->hasRole('user') ? 'hub' : null])

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Mon profil',
        'package' => 'me',
        'label' => __(config('laravel-me.label') ?? 'Mon compte')
    ])
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.left-body', [
        'form' => $form,
    ])
        @slot('left')
            @include('me::back.partials.sidenav')
        @endslot

        @slot('body')
            <div class="inner">
                <div class="row">
                    <div class="col-12 col-md-10 col-xl-8">
                        <div class="text-xl font-bold my-4">Mes données personnelles</div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! form_row($form->gender) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! form_row($form->lastname) !!}
                            </div>
                            <div class="col-12 col-md-4">
                                {!! form_row($form->firstname) !!}
                            </div>
                        </div>
                        <p class="text-muted text-3xs">Vos nom et prénom pourront être affichés au sein de l’application ou dans les communications de partage d’informations.</p>

                        <div class="row">
                            <div class="col-12 col-md-8">
                                {!! form_row($form->email) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4">
                                {!! form_row($form->birth_date) !!}
                            </div>
                        </div>

                        {!! form_rest($form) !!}

                        <div class="d-flex mt-4">
                            <button type="submit" class="btn btn-primary text-sm font-bold">Sauvegarder</button>
                        </div>
                    </div>
                </div>
            </div>
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
