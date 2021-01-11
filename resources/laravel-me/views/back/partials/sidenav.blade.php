<div class="list-group list-group-flush">
    <a href="{{ route('brain.me.profile.edit', uuid()) }}"
       class="list-group-item list-group-item-action text-xs px-3 {{ Route::current()->getName() == 'brain.me.profile.edit' ? 'active' : '' }}">
        Mon profil
    </a>
    <a href="{{ route('brain.me.password.edit', uuid()) }}"
       class="list-group-item list-group-item-action text-xs px-3 {{ Route::current()->getName() == 'brain.me.password.edit' ? 'active' : '' }}">
        Mon mot de passe
    </a>
    @if(auth()->user()->account && auth()->user()->can('update account'))
        <a href="{{ route('brain.me.account.edit', uuid()) }}"
           class="list-group-item list-group-item-action text-xs px-3 {{ Route::current()->getName() == 'brain.me.account.edit' ? 'active' : '' }}">
            Mon organisation
        </a>
        <a href="{{ route('brain.me.users.index', uuid()) }}"
           class="list-group-item list-group-item-action text-xs px-3 {{ Route::current()->getName() == 'brain.me.users.index' ? 'active' : '' }}">
            Mes utilisateurs
        </a>
    @endif
    <a href="{{ route('brain.me.preferences.edit', uuid()) }}"
       class="list-group-item list-group-item-action text-xs px-3 {{ Route::current()->getName() == 'brain.me.preferences.edit' ? 'active' : '' }}">
        Mes préférences
    </a>
</div>
