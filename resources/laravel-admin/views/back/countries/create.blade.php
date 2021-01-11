@extends('back::layouts.abstract', ['interface' => 'blank'])

@section('header')
    <div class="text-2xl font-bold my-3">{{ __('Ajouter un pays') }}</div>
    @component('back::atomicdesign.atoms.exit', [
        'exitRoute' => route("brain.admin.countries.index", uuid())
    ])@endcomponent
@stop

@section('content')
    {!! form_start($form) !!}
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6">
                <div class="mb-5">
                    {!! form_rest($form) !!}
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-lg btn-primary">{{ __('Créer la pays') }}</button>
                </div>
            </div>
        </div>
    </div>
    {!! form_end($form) !!}
    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
