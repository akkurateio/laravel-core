@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Rôles',
        'package' => 'access',
        'label' => __(config('laravel-access.label') ?? 'Accès')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.datagrid', [
        'package' => 'access',
        'labels' => [
            'singular' => 'rôle',
            'plural' => 'rôles',
            'gender' => 'masculin',
        ],
        'routes' => [
            'index' => 'brain.access.roles.index',
            'create' => 'brain.access.roles.create',
            'edit' => 'brain.access.roles.edit',
            'destroy' => 'brain.access.roles.destroy',
            'toggle' => 'brain.access.roles.toggle',
        ],
        'config' => [
            'columns' => config('laravel-access.cruds.Role.views.index.columns'),
            'main' => config('laravel-access.cruds.Role.views.index.main'),
]       ,
        'items' => $roles,
        'model' => 'role',
    ])@endcomponent
@endsection
