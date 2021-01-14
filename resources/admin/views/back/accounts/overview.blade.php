<div class="py-5 @if(!empty($class)){{ $class }}@endif">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-3">
                <h2 class="text-lg font-medium">Compte</h2>
            </div>
            <div class="col-12 col-sm-9">
                <div class="d-flex align-items-center">
                    <strong class="mr-1">{{ $account->name }}</strong>
                    <a href="{{ route('brain.admin.accounts.show', ['account' => $account]) }}">
                        <i class="icon">
                            <Overflow-menu-horizontal />
                        </i>
                    </a>
                </div>

                <dl class="row text-2xs">
                    @if ($account->email)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('email') }}</span>
                        </dt>
                        <dd class="col-8 d-flex align-items-center">
                            <span class="mr-2">{{ $account->email }}</span>
                            <a href="mailto:{{ $account->email }}">
                                <i class="icon">
                                    <Email />
                                </i>
                            </a>
                        </dd>
                    @endif

                    @if ($account->mobile)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('mobile') }}</span>
                        </dt>
                        <dd class="col-8">{{ $account->mobile }}</dd>
                    @endif

                    @if ($account->phone)
                        <dt class="col-4">
                            <span class="font-normal">{{ __('phone') }}</span>
                        </dt>
                        <dd class="col-8">{{ $account->phone }}</dd>
                    @endif
                </dl>

                @if ($account->billing || $account->billing)
                    <div class="row text-2xs">
                        <div class="col-12 col-sm-6">
                            @if ($account->billing)
                                <div class="font-normal">{{ __('address') }} de facturation</div>
                                <div class="">{{ $account->billing }}</div>
                            @endif
                        </div>
                        <div class="col-12 col-sm-6">
                            @if ($account->delivery)
                                <div class="font-normal">{{ __('address') }} de livraison</div>
                                <div class="">{{ $account->delivery }}</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
