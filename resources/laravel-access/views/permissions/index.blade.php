@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Permissions',
        'package' => 'access',
        'label' => __(config('laravel-access.label') ?? 'Accès')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.datagrid', [
        'package' => 'access',
        'routes' => [
            'index' => 'brain.access.permissions.index',
            'create' => 'brain.access.permissions.create',
            'edit' => 'brain.access.permissions.edit',
            'destroy' => 'brain.access.permissions.destroy',
            'toggle' => 'brain.access.permissions.toggle',
        ],
        'config' => [
            'columns' => config('laravel-access.cruds.Permission.views.index.columns'),
            'main' => config('laravel-access.cruds.Permission.views.index.main'),
]       ,
        'items' => $permissions,
        'model' => 'permission',
    ])@endcomponent
@endsection
