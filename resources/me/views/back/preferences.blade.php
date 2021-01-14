@extends('back::layouts.abstract', ['interface' => auth()->user()->hasRole('user') ? 'hub' : null])

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Mes préférences',
        'package' => 'core',
        'label' => __(config('laravel-me.label') ?? 'Mon compte')
    ])
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.left-body', [
        'form' => null,
    ])
        @slot('left')
            @include('me::back.partials.sidenav')
        @endslot

        @slot('body')
            <div class="inner">
                @foreach($forms as $form)
                    <div class="mb-5">
                        {!! form_start($form->fields) !!}
                        <div class="text-xl font-bold my-4">{{ $form->title }}</div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-6">
                                {!! form_rest($form->fields) !!}
                            </div>
                        </div>

                        <div class="d-flex mt-4">
                            <button type="submit" class="btn btn-primary text-sm font-bold">Sauvegarder</button>
                        </div>
                        {!! form_end($form->fields) !!}
                    </div>
                @endforeach
            </div>
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
