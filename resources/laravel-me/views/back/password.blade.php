@extends('back::layouts.abstract', ['interface' => auth()->user()->hasRole('user') ? 'hub' : null])

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Mot de passe',
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
                        <div class="text-xl font-bold my-4">Mon mot de passe</div>

{{--                        @if ($errors->any())--}}
{{--                            <div class="alert alert-danger">--}}
{{--                                <ul class="list-unstyled mb-0">--}}
{{--                                    @foreach ($errors->all() as $error)--}}
{{--                                        <li>{{ $error }}</li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

                        <div class="row">
                            <div class="col-12 col-md-8">
                                {!! form_rest($form) !!}
                            </div>
                        </div>

                        <div class="d-flex mt-4">
                            <button type="submit" class="btn btn-primary text-sm font-bold">Changer mon mot de passe</button>
                        </div>
                    </div>
                </div>
            </div>
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
