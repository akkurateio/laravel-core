@extends('back::layouts.mail')

@section('content')
    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
           width="100%">
        <tbody>
        <tr>
            <td class="akk-products-box-s1"
                style="vertical-align: top; padding: 30px 40px 40px; background-color: {{ config('akk-style.colors.white') }}"
                valign="top" bgcolor="{{ config('akk-style.colors.white') }}">
                <table border="0" cellpadding="0" cellspacing="0"
                       style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                    <tbody>
                    <tr>
                        <td class="akk-heading-s1" style="vertical-align: top;" valign="top">
                            <!--[if (gte mso 9)|(IE)]>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="100" valign="top">
                            <![endif]-->

                            <table class="akk-heading-col" border="0" cellpadding="0" cellspacing="0"
                                   align="left"
                                   style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                                   width="100%">
                                <tbody>
                                <tr>
                                    <td class="akk-fb-font"
                                        style="vertical-align: top; padding: 10px 0; font-family: {{ mail_styles('font') }}; font-size: 14px; font-weight: 400; line-height: 1.42; letter-spacing: -0.4px; color: {{ mail_styles('colors.black') }};"
                                        valign="top">
                                        <p style="color: {{ mail_styles('colors.black') }};">
                                            Bonjour {{ $user->firstname . ' ' . $user->lastname }},</p>
                                        <p style="color: {{ mail_styles('colors.black') }};">Vous recevez ce message
                                            suite à l’invitation de {{ $from->firstname . ' ' . $from->lastname }}.</p>
                                        <div class="text-center">
                                            <a class="button button-primary"
                                               style="color: {{ !empty(config('wecapt-mail')) ? config('wecapt-mail.transactional.colors.white') : mail_styles('colors.white') }}; background-color: {{ !empty(config('wecapt-mail')) ? config('wecapt-mail.transactional.colors.primary') : mail_styles('colors.primary') }};"
                                               href="{{ route('verify.user', ['token' => $token]) }}">
                                                Valider votre compte
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
