<div class="entry entry-user py-2 d-flex align-items-center">

    @if(config('laravel-media') && $entry->getThumb())
        <img src="{{ $entry->getThumb('avatar') }}" width="32" height="32" class="rounded-full">
    @else
        @if (config('app.gravatar'))
            <img class="rounded-full" src="{{ \Thomaswelton\LaravelGravatar\Facades\Gravatar::src($entry->email, 64) }}"
                 width="32" height="32">
        @else
            <i class="icon primary">
                <Icon name="UserAvatar"/>
            </i>
        @endif
    @endif

    <div class="ml-2 w-20">
        <a href="{{ route($routes['edit'], ['user' => $entry, 'uuid' => request('uuid')]) }}"
           class="font-bold text-truncate">
            @if($entry->firstname || $entry->lastname)
                {{ $entry->firstname ? $entry->firstname : '' }}
                {{ $entry->lastname ? $entry->lastname :'' }}
            @else
                {{ __('Non renseigné') }}
            @endif
        </a>
        <div class="text-2xs text-muted">{{ $entry->email }}</div>
    </div>
    <div class="ml-2 w-20">
        @if ($entry->account)
            <div class="text-truncate">{{ $entry->account->name }}</div>
        @endif
    </div>
    <div class="w-20 text-center">
        @if(!$entry->activated_at)
            <span class="text-4xs border border-warning rounded text-uppercase px-2 py-1">{{ __('Pending') }}</span>
        @else
            @foreach($entry->getRoleNames() as $role)
                <span class="text-4xs border border-primary rounded text-uppercase px-2 py-1">{{ $role }}</span>
            @endforeach
        @endif
    </div>
    <div class="w-20 text-center mr-auto">
        @if($entry->is_active)
            <span class="text-2xs font-normal badge badge-primary px-2">{{ __('Actif') }}</span>
        @else
            <span class="text-2xs font-normal badge badge-secondary text-white px-2">{{ __('Désactivé') }}</span>
        @endif
    </div>
    <div class="text-2xs">{{ Carbon\Carbon::parse($entry->updated_at)->diffForHumans() }}</div>
    <div class="ml-3">
        <akk-delete-confirm
                modal-component="DeleteConfirmation"
                icon="Delete"
                sentence="{{ __('Souhaitez-vous vraiment supprimer <br />cet utilisateur ?') }}"
                wrapper-class="icon primary"
                route="{{ route($routes['destroy'], ['uuid' => request('uuid'), 'user' => $entry]) }}"
        >
            <template v-slot:csrf>@csrf</template>
        </akk-delete-confirm>
    </div>
</div>
