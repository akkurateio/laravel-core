<div class="mb-5">
    <div class="d-flex flex-wrap">
        <div class="max-w-lg mr-4 mb-4">
            <div class="bg-white border-gray-300 p-4">
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: {{ config('general.signature.logotype.size.width') + 20 }}px;">
                            <img src="{{ asset(config('general.signature.logotype.src')) }}" alt="{{ $user->account->name }}"
                                 style="width: {{ config('general.signature.logotype.size.width') }}px; height: {{ config('general.signature.logotype.size.height') }}px;"/>
                        </td>
                        <td style="">
                            <p style="font-size: 14px; color: #000; margin-bottom: 0px;">{{ $user->firstname }} {{ $user->lastname }}</p>
                            <p style="font-size: 11px; color: #000; margin-bottom: 16px;">Email : <a
                                        style="color: #000;"
                                        href="mailto:{{ $user->email }}" style="font-size: 11px;">{{ $user->email }}</a></p>
                            <p style="font-size: 11px; color: #000; margin-bottom: 24px;">Tél.
                                : {{ config('general.contact.phone') }}</p>
                            {{--            <p style="font-size: 11px; color: #000; margin-bottom: 24px;">Mob. : {{ $user->phones[1]->number }}</p>--}}
                            <p style="font-size: 11px; color: #000; margin-bottom: 4px;">Suivez-nous sur les réseaux sociaux</p>
                            <p>
                                @foreach(config('general.socials') as $name => $url)
                                    <a href="{{ $url }}" style="display: inline-block; margin-right: 6px;" target="_blank"
                                       rel="noopener">
                                        <img src="{{ asset('/images/mail/' . $name . '.png') }}" alt="{{ $name }}"
                                             target="_blank" rel="noopener"
                                             style="width: 24px; height: 24px;" alt="{{ Str::upper($name) }}"/>
                                    </a>
                                @endforeach
                            </p>
                            <p style="font-size: 16px; color: #000; margin-bottom: 24px;">
                                <strong>
                                    <a
                                            href="{{ config('general.sitename') }}" target="_blank"
                                            style="color: #000;"
                                            rel="noopener">{{ config('general.signature.sitename') }}</a>
                                </strong>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="max-w-sm">
            <div class="text-sm font-bold mb-2">Information</div>
            <div class="text-2xs">
                <p>Cette signature est générée automatiquement à partir des informations enregistrées dans
                    l’application.</p>
                <p>Vous pouvez à tout moment modifier celles-ci.</p>
                <p>Pour utiliser cette signature, il vous suffit de sélectionner le contenu et de le coller dans le
                    champ de Signature de Gmail, dans les paramètres de votre compte.</p>
            </div>
        </div>
    </div>
</div>
