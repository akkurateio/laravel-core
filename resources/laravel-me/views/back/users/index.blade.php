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
    @component('back::atomicdesign.moleculs.left-body', [
        'form' => null,
    ])
        @slot('left')
            @include('me::back.partials.sidenav')
        @endslot

        @slot('body')
            <div class="inner">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="text-xl font-bold my-4">Mes utilisateurs</div>

                    <a href="{{ route('brain.me.users.create', ['uuid' => request('uuid')]) }}"
                       class="btn btn-primary text-xs font-bold">Inviter un nouvel utilisateur</a>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @foreach($all as $index => $entry)
                    <div class="list-group-item bg-transparent py-3">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-center">
                                    {{--                                                @component('wecapt::components.avatar', ['user' => auth()->user(), 'size' => 64])@endcomponent--}}
                                    <div class="">
                                        <a href="{{ route('brain.me.users.edit', ['uuid' => request('uuid'), 'userUuid' => $entry->uuid]) }}" class="text-xs font-bold">{{ $entry->lastname }} {{ $entry->firstname }}</a>
                                        <div class="text-3xs text-muted">{{ $entry->email }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                @if(!$entry->activated_at)
                                    <span class="text-4xs border border-warning rounded text-uppercase px-2 py-1">{{ __('En attente') }}</span>
                                @else
                                    @foreach($entry->getRoleNames() as $role)
                                        <span class="text-4xs border border-primary text-primary rounded text-uppercase px-2 py-1">{{ $role }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col">
                                @if($entry->activated_at)
                                    <a href="{{ route('brain.me.users.toggle', ['uuid' => request('uuid'), 'userUuid' => $entry->uuid]) }}"
                                       class="btn btn-outline-secondary font-bold border-1 text-3xs"
                                       style="padding: .375rem .185rem;">
                                        @if($entry->is_active)
                                            <span class="px-2 py-1">Inactif</span>
                                            <span class="bg-primary text-white px-2 py-1">Actif</span>
                                        @else
                                            <span class="bg-primary text-white px-2 py-1">Inactif</span>
                                            <span class="px-2 py-1">Actif</span>
                                        @endif
                                    </a>
                                @else
                                    <a href="{{ route('brain.me.users.reinvit', ['uuid' => request('uuid'), 'userUuid' => $entry->uuid]) }}"
                                       class="text-2xs text-secondary">Renvoyer une invitation</a>
                                @endif
                            </div>
                            <div class="col-12 col-md-1 d-flex justify-content-end">
                                <akk-delete-confirm
                                        modal-component="DeleteConfirmation"
                                        icon="Delete"
                                        sentence="{{ __('Souhaitez-vous vraiment supprimer <br />cet utilisateur ?') }}"
                                        wrapper-class="icon primary"
                                        route="{{ route('brain.me.users.soft-delete', ['uuid' => request('uuid'), 'userUuid' => $entry->uuid]) }}"
                                >
                                    <template v-slot:csrf>@csrf</template>
                                </akk-delete-confirm>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endslot

    @endcomponent

    @component('back::atomicdesign.atoms.toast')@endcomponent
@endsection
