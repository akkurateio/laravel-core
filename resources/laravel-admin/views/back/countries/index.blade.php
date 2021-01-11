@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Pays',
        'package' => 'admin',
        'label' => __(config('laravel-admin.label') ?? 'Admin')
    ])
        {{--        <div>Put what you want!</div>--}}
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.datagrid', [
        'package' => 'admin',
        'routes' => [
            'index' => 'brain.admin.countries.index',
            'create' => 'brain.admin.countries.create',
            'edit' => 'brain.admin.countries.edit',
            'destroy' => 'brain.admin.countries.destroy',
            'toggle' => 'brain.admin.countries.toggle',
        ],
        'config' => [
            'columns' => config('laravel-admin.cruds.Country.views.index.columns'),
            'main' => config('laravel-admin.cruds.Country.views.index.main'),
        ],
        'items' => $countries,
        'model' => 'country',
    ])@endcomponent
@endsection
