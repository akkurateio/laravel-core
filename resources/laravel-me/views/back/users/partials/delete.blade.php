<div class="text-lg font-bold mb-4">Suppression</div>
<p>Vous souhaitez supprimer cet utilisateur ?</p>
<akk-delete-confirm
        modal-component="DeleteConfirmation"
        label="{{ __('Supprimer') }}"
        sentence="{{ __('Souhaitez-vous vraiment supprimer cet utilisateur ?') }}"
        wrapper-class="btn btn-sm btn-outline-primary text-xs font-bold"
        route="{{ route('brain.me.users.soft-delete', ['uuid' => request('uuid'), 'userUuid' => $user->uuid]) }}"
>
    <template v-slot:csrf>@csrf</template>
</akk-delete-confirm>
{{--<form method="POST"--}}
{{--      action="{{ route('brain.me.users.soft-delete', ['uuid' => request('uuid'), 'userUuid' => $user->uuid]) }}">--}}
{{--    @csrf--}}

{{--</form>--}}

