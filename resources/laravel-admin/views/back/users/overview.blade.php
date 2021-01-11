<div class="py-5 @if(!empty($class)){{ $class }}@endif">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-3">
                <h2 class="text-lg font-medium">Utilisateur</h2>
            </div>
            <div class="col-12 col-sm-9">
                <div class="d-flex align-items-center">
                    <strong class="mr-1">{{ $user->lastname }} {{ $user->firstname }}</strong>
                    <a href="{{ route('brain.admin.users.show', ['user' => $user]) }}">
                        <i class="icon">
                            <Overflow-menu-horizontal />
                        </i>
                    </a>
                </div>

                <dl class="row text-2xs">
                    <dt class="col-4">
                        <span class="font-normal">{{ __('email') }}</span>
                    </dt>
                    <dd class="col-8 d-flex align-items-center">
                        <span class="mr-2">{{ $user->email }}</span>
                        <a href="mailto:{{ $user->email }}">
                            <i class="icon">
                                <Email />
                            </i>
                        </a>
                    </dd>

                    @if ($user->birth_date)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('birth_date') }}</span>
                        </dt>
                        <dd class="col-8">{{ $user->birth_date->format('d/m/Y') }}</dd>
                    @endif

                    @if ($user->mobile)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('mobile') }}</span>
                        </dt>
                        <dd class="col-8">{{ $user->mobile }}</dd>
                    @endif

                    @if ($user->phone)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('phone') }}</span>
                        </dt>
                        <dd class="col-8">{{ $user->phone }}</dd>
                    @endif
                </dl>

                @if ($user->billing || $user->billing)
                    <div class="row text-2xs">
                        <div class="col-12 col-sm-6">
                            @if ($user->billing)
                                <div class="font-normal">{{ __('address') }} de facturation</div>
                                <div class="">{{ $user->billing }}</div>
                            @endif
                        </div>
                        <div class="col-12 col-sm-6">
                            @if ($user->delivery)
                                <div class="font-normal">{{ __('address') }} de livraison</div>
                                <div class="">{{ $user->delivery }}</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
