@extends('back::layouts.abstract')

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Langues',
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
            'index' => 'brain.admin.languages.index',
            'create' => 'brain.admin.languages.create',
            'edit' => 'brain.admin.languages.edit',
            'destroy' => 'brain.admin.languages.destroy',
            'toggle' => 'brain.admin.languages.toggle',
        ],
        'config' => [
            'columns' => config('laravel-admin.cruds.Language.views.index.columns'),
            'main' => config('laravel-admin.cruds.Language.views.index.main'),
    ],
        'items' => $languages,
        'model' => 'language',
    ])@endcomponent
@endsection
