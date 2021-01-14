@extends('back::layouts.blank', ['interface' => 'blank'])

@section('content')
    <div class="position-fixed mt-2 d-flex align-items-center">
        <a href="{{ route('brain.me.users.index', ['uuid' => request('uuid')]) }}" class="icon-box icon primary">
            <Icon name="ArrowLeft"></Icon>
        </a>
        <div class="text-2xl font-bold">Inviter un nouvel utilisateur</div>
    </div>

    @component('back::atomicdesign.atoms.exit', ['exitRoute' => route('brain.me.users.index', ['uuid' => request('uuid')])])@endcomponent

    <div class="container-fluid h-100 d-flex align-items-center">
        <div class="w-100 vh-100 row align-items-center justify-content-center">
            <div class="col-12 col-md-6 col-xl-5">
                @if ($errors->any())
                    <div class="alert alert-danger text-xs">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! form_start($form) !!}
                <div class="row">
                    <div class="col-12 col-md-6">
                        {!! form_row($form->lastname) !!}
                    </div>
                    <div class="col-12 col-md-6">
                        {!! form_row($form->firstname) !!}
                    </div>
                </div>
                {!! form_rest($form) !!}
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('brain.me.users.index', ['uuid' => request('uuid')]) }}"
                       class="btn btn-lg btn-outline-secondary text-sm">{{ __('Annuler') }}</a>
                    <button class="btn btn-lg btn-primary text-sm font-bold" type="submit">Inviter l'utilisateur
                    </button>
                </div>
                {!! form_end($form) !!}

            </div>
        </div>
    </div>

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
