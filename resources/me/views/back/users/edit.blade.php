@extends('back::layouts.abstract', ['interface' => auth()->user()->hasRole('user') ? 'hub' : null])

@section('header')
    @component('back::atomicdesign.components.header.abstract', [
        'util' => 'Mes utilisateurs',
        'package' => 'me',
        'label' => __(config('laravel-me.label') ?? 'Mon compte')
    ])
    @endcomponent
@stop

@section('content')
    @component('back::atomicdesign.moleculs.left-body-right', [
            'form' => $form,
        ])
        @slot('left')
            @include('me::back.partials.sidenav')
        @endslot

        @slot('right')
            <div class="inner">
                @include('me::back.users.partials.delete')
            </div>
        @endslot

        @slot('body')
            <div class="inner">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="text-xl font-bold my-4">Utilisateur</div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-xl">{{ $user->lastname }} {{ $user->firstname }}</div>
                                <div class="mb-4">{{ $user->email }}</div>
                            </div>
                            @if (!empty($user->activated_at))
                                <div>
                                    <a href="{{ route('brain.me.users.toggle', ['uuid' => request('uuid'), 'userUuid' => $user->uuid]) }}"
                                       class="btn btn-outline-secondary font-bold border-1 text-3xs mb-3"
                                       style="padding: .375rem .185rem;">
                                        @if($user->is_active)
                                            <span class="px-2 py-1">Inactif</span>
                                            <span class="bg-primary text-white px-2 py-1">Actif</span>
                                        @else
                                            <span class="bg-primary text-white px-2 py-1">Inactif</span>
                                            <span class="px-2 py-1">Actif</span>
                                        @endif
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($user->is_active)
                        <div class="col-12 col-md-6 col-xl-5">
                            @if ($errors->any())
                                <div class="alert alert-danger text-xs">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {!! form_rest($form) !!}
                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-primary text-sm font-bold"
                                        type="submit">{{ __('Sauvegarder') }}</button>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        @endslot
    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
