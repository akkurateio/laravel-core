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
            <div class="inner">
                <pre>@json($permission, JSON_PRETTY_PRINT)</pre>
            </div>
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
            @component('back::atomicdesign.components.view-footer', ['backPath' => route('brain.access.permissions.index', uuid()), 'saveLabel' => __('Sauvegarder'), 'form' => $form, 'item' => $permission])@endcomponent
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
