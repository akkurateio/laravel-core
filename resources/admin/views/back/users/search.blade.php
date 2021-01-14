@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Utilisateurs',
        'package' => 'admin',
        'label' => __(config('laravel-admin.label') ?? 'Admin')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.search', [
        'form' => $form,
        'isSearch' => $search,
        'q' => $q ?? null,
        'labels' => [
            'singular' => 'utilisateur',
            'plural' => 'utilisateurs',
            'gender' => 'male',
        ],
        'routes' => [
            'index' => 'brain.admin.users.index',
            'show' => 'brain.admin.users.show',
            'create' => 'register',
            'edit' => 'brain.admin.users.edit',
            'destroy' => 'brain.admin.users.destroy',
        ],
        'items' => [
            'search' => $searchResults,
            'all' => $all,
            'lastupdated' => $lastUpdated,
            'lastcreated' => $lastCreated,
        ],
        'alphabetical' => true,
        'componentEntry' => 'admin::back.users.includes.item'
    ])@endcomponent
@endsection
