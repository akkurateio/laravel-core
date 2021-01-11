@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Dashboard',
        'route' => 'admin',
        'package' => ' ',
        'label' => __(' '),
    ])
    @endcomponent
@stop

@section('content')

    @component('back::atomicdesign.moleculs.left-body', [
    ])

        @slot('left')
            <div class="inner">
                <div class="">
                    <div>
                        <div class="text-lg font-medium mb-2">Bonjour {{ auth()->user()->firstname ?? auth()->user()->name }}</div>
                    </div>
                </div>
                @if(auth()->user()->account)
                    <div class="text-2xs text-muted">Mon organisation</div>
                    <div class="font-medium">{{ auth()->user()->account->name }}</div>
                    <div class="text-2xs">{{ !empty(auth()->user()->account->getAddressFormattedAttribute()) ? auth()->user()->account->getAddressFormattedAttribute() : '' }}</div>
                @else
                    <div>Vous appartenez à une organisation ?</div>
                    <div><a href="{{ route('brain.me.account.create', uuid()) }}">Créez un compte</a> et invitez d’autres utilisateurs</div>
                @endif
            </div>
            @if (config()->has('laravel-me'))
                @include('me::back.partials.sidenav')
            @endif
        @endslot

        @slot('body')
            <div class="inner">

            </div>
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
