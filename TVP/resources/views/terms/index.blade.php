@extends('template.layout')
@section('title', config('server.serverName') . ' Terms')
@section('submenuItem', 'legaldocuments')
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">{{ config('server.serverName') }} Privacy Policy</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>{{ config('server.serverName') }} respects the privacy rights of all users and is aware of the importance of protecting stored personal data. Substantial organisational and technical measures have been taken to ensure the security of all personal data that is collected. This privacy policy explains in detail which information is collected and for which purposes it can be processed and used. <ol>
                                        <li>{{ config('server.serverName') }} collects, processes and uses personal data for the conclusion and execution of a user's service agreement with {{ config('server.serverName') }}. Personal data comprises stock data such as name, address and date of birth of a user as well as usage data such as account number, password and IP address.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} collects the usage data that is automatically determined and transmitted by web browsers or any other client software whenever {{ config('server.serverName') }}'s websites ({{ config('server.serverDomain') }}, {{ config('server.serverName') }}.com or any other of {{ config('server.serverName') }}'s websites) or one of {{ config('server.serverName') }}'s other online services is used. Such usage data includes, but is not limited to, IP address, browser version, access time, information on the type and the aim of requests and data about hardware and software of the user's computer system. It is saved in protocol files, with some of the information being stored in anonymous form. Among other purposes, this data is used by {{ config('server.serverName') }} for the compilation of anonymous statistical surveys on the use of their online services and for the error analysis and the optimisation of their service.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} uses, among other things, cookies to collect, process and use usage data in order to allow, for instance, the management of accounts and of personal settings, the participation in the discussion forum, and the use of further personalised services.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} collects, processes and uses stock and usage data, to the extent that is necessary in individual cases, if it is required to reveal and to stop fraudulent behaviour or any other form of using {{ config('server.serverName') }}'s services which violates legal regulations or the service agreement. In particular, {{ config('server.serverName') }} reserves the right to log, process and use information such as the time and the content of conversations and expressions of opinion that take place in their online services if there are complaints, reports or other credible indications of behaviour that violates legal regulations or the service agreement, for example the serious insulting of other users. This regulation extends to all parts of {{ config('server.serverName') }}'s online service, including, but not limited to, guild channels, private channels and private messages.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} collects, processes and uses personal data in connection with complaints and requests to their user support in order to comply with requests in as efficient and satisfactory a manner as possible. Data that is collected for such purposes includes, but is not limited to, the email address, the date of the contact and its content. Also, {{ config('server.serverName') }} processes and uses this data to compile anonymous statistical surveys for the optimisation of their customer support.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} collects, processes and uses personal data for the purpose of conducting marketing actions such as the sending of emails that contain general information or promotional content, provided that the user agreed to receiving such emails separately during the account creation process or at any later time by selecting the option "Newsletter" on the account page. Every user can unsubscribe from receiving this kind of information at any time. This can either be done by deselecting the aforementioned account option "Newsletter" or by directly clicking on the unsubscribe link in any received newsletter. Also, {{ config('server.serverName') }} processes and uses personal data to compile anonymous statistical surveys for the purpose of improving their range of services.</li>
                                        <br>
                                        <li>{{ config('server.serverName') }} displays character names to all visitors on all of {{ config('server.serverName') }}'s websites as well as to all users in their online services in connection with certain game activities of a user in order to allow other users to selectively contact this user. This occurs, for example, when the user uses characters online, when they act as parts of character associations, or possibly when they are registered in high score lists. Furthermore, {{ config('server.serverName') }} generally makes usage data of characters, for example the time of its most recent use or information on its death, available to all visitors on all of {{ config('server.serverName') }}'s websites as well as to all users in {{ config('server.serverName') }}'s online services. {{ config('server.serverName') }} makes information, such as the record of rule violations or the list of defeated characters, available to certain other users, who have a supervisory role among the community of users.</li>
                                        <br>
                                        <li>In so far as the transfer of data to third parties is not explicitly allowed by law, {{ config('server.serverName') }} <ul>
                                                <li>passes on personal data, to the extent that is necessary, to law enforcement and supervisory authorities for the purpose of preventing dangers to the national or public security as well as for the prosecution of criminal offences.</li>
                                                <li>passes on the name, address and, to the extent that is necessary in individual cases, further personal data of users to its partner companies, for example for the purpose of handling payment transactions or to provide other services in the framework of the users' service agreement with {{ config('server.serverName') }}.</li>
                                            </ul> Third parties may possibly be based in countries outside of the European Union, but they are bound to protect personal data to the same extent as {{ config('server.serverName') }}. {{ config('server.serverName') }} will not, aside from the aforementioned cases, pass on personal data to third parties, and solely employees of {{ config('server.serverName') }} have access to personal data in order to fulfil the tasks specified above. </li>
                                    </ol> {{ config('server.serverName') }} may change this privacy policy at any time. {{ config('server.serverName') }} will notify all users about the changes by placing a prominent notice on the website of {{ config('server.serverName') }}. The changed privacy policy will take effect 30 days after it has been officially announced. It will fully apply to any user who has not revoked his or her declaration of consent within this period of time. All users are required to review this policy at regular intervals to keep themselves informed about any changes. <br>
                                    <br> Users have the right of access to their personal data being processed by {{ config('server.serverName') }} (Art. 15 GDPR) as well as the right to rectify (Art. 16 GDPR) or erase (Art. 17 GDPR) these personal data. Furthermore they have the right to restriction of processing (Art. 18 GDPR), the right to object to processing of personal data (Art. 21 GDPR) and the right to data portability (Art. 20 DSGVO). Users can exercise these rights by sending an email to {{ config('server.supportEmail') }}. If users revoke their declaration of consent to the processing of their personal data, their accounts at {{ config('server.serverName') }} will be blocked, and {{ config('server.serverName') }}'s personalised services will no longer be available via these accounts. <br>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection