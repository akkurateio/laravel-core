<div class="entry entry-account">
    <div class="row align-items-center">
        <div class="col-12 col-sm-4">
            <div class="d-flex align-items-center">
{{--                @if($entry->getFirstMediaUrl('logo'))--}}
{{--                    <img src="{{ $entry->getFirstMediaUrl('logo') }}" width="32" height="32" class="rounded-full">--}}
{{--                @else--}}
{{--                    <img src="{{ asset('images/default-avatar.png') }}" width="32" height="32" class="rounded-full"/>--}}
{{--                @endif--}}
                <a href="{{ route($routes['edit'], ['uuid' => request('uuid'), 'account' => $entry]) }}"
                   class="font-bold text-truncate">
                    {{ $entry->name }}
                </a>
            </div>
        </div>
        <div class="col-12 col-sm-2 text-2xs text-neutral">
            @if(count($entry->users) > 0)
                {{ count($entry->users) }} {{ \Illuminate\Support\Str::lower(__('Utilisateur')) . (count($entry->users) > 1 ? 's' : '') }}
            @else
                {{ __('Aucun(e) utilisateur') }}
            @endif
        </div>
        <div class="col-12 col-sm-2 text-center">
            @if($entry->is_active)
                <span class="text-2xs font-normal badge badge-primary px-2">{{ __('Actif') }}</span>
            @else
                <span class="text-2xs font-normal badge badge-secondary text-white px-2">{{ __('Désactivé') }}</span>
            @endif
        </div>
        <div class="col-12 col-sm-2 text-right text-2xs">
            @if(Carbon\Carbon::parse($entry->updated_at)->diffInDays() < 2)
                {{ Carbon\Carbon::parse($entry->updated_at)->diffForHumans() }}
            @else
                {{ Carbon\Carbon::parse($entry->updated_at)->format('d/m/Y') }}
            @endif
        </div>
    </div>
</div>
