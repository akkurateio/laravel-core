@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Comptes',
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
            'singular' => 'compte',
            'plural' => 'comptes',
            'gender' => 'male',
        ],
        'routes' => [
            'index' => 'brain.admin.accounts.index',
            'create' => 'brain.admin.accounts.create',
            'edit' => 'brain.admin.accounts.edit',
        ],
        'items' => [
            'search' => $searchResults,
            'all' => $all,
            'lastupdated' => $lastUpdated,
            'lastcreated' => $lastCreated,
        ],
        'alphabetical' => true,
        'componentEntry' => 'admin::back.accounts.includes.item'
    ])@endcomponent
@endsection
