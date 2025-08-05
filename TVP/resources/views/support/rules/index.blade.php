@extends('template.layout')
@section('title', config('server.serverName') .' Rules')
@section('submenuItem', 'rules')
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">{{ config('server.serverName') }} Rules</div>
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
                    <div class="InnerTableContainer">
                        <p><b>These rules may be changed at any time.</b></p>

                        <p style="text-align: justify;">
                            Violation may lead to temporary expulsion of characters and accounts. In severe cases, removal or modification of characters' abilities, attributes, and belongings, as well as permanent account removal without any compensation may be considered. The sanction is based on the severity of the rules violation and the player's previous record. It is determined by the game master who imposes the expulsion.
                        </p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table>
        <tbody>
            <tr>     
                <td>

                    <br>

                    <div class="TableContainer">
                        <div class="CaptionContainer">
                            <div class="CaptionInnerContainer">
                                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <div class="Text">1. Names</div>
                                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            </div>
                        </div>

                        <table class="Table3" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="InnerTableContainer">
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="TableContentAndRightShadow">
                                                        <div class="TableContentContainer">
                                                            <table border="0" cellpadding="4" cellspacing="1" width="100%">
                                                                <tbody>
                                                                <tr>
                                                                    <th>Rules</th>
                                                                    <th>Rule Info</th>
                                                                    <th>Punishment</th>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px"><l1 class="rules">1.1 Offensive Name</l1></td>

                                                                    <td>
                                                                        Names that are insulting, racist, sexually related, drug-related, harassing or generally objectionable.
                                                                    </td>

                                                                    <td>Banishment until player changes name.</td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px"><l1 class="rules">1.2 Invalid Name Format</l1></td>
                                                                    <td>
                                                                        Names that contain parts of sentences (except for guild names), badly formatted words or nonsensical combinations of letters.
                                                                    </td>
                                                                    <td>
                                                                        Banishment until player changes name.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">1.3 Name Containing Forbidden Advertising</l1>
                                                                    </td>

                                                                    <td>
                                                                        Names that advertise brands, products or services of third parties, content which is not related to the game or trades for real money.
                                                                    </td>

                                                                    <td>
                                                                        Banishment until player changes name.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">1.4 Unsuitable Name</l1>
                                                                    </td>

                                                                    <td>
                                                                        Names that generally do not fit into Ravenor's medieval fantasy setting.
                                                                    </td>

                                                                    <td>
                                                                        Banishment until player changes name.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">1.5 Name Supporting Rule Violation</l1>
                                                                    </td>

                                                                    <td>
                                                                        Names that support, incite, announce or imply a violation of the Ravenor rules.
                                                                    </td>

                                                                    <td>
                                                                        Banishment until player changes name.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">1.6 Name Impersonation</l1>
                                                                    </td>

                                                                    <td>
                                                                        Names similar to the names of other players, used to impersonate as another player in order to take advantage or harm their reputation.
                                                                    </td>

                                                                    <td>
                                                                        Banishment until player changes name.
                                                                    </td>
                                                                </tr>

                                                                <tr class="Odd"></tr></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div style="padding: 0.5%"></div>
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

                    <br>

                    <div class="TableContainer">
                        <div class="CaptionContainer">
                            <div class="CaptionInnerContainer">
                                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <div class="Text">2. Statements</div>
                                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            </div>
                        </div>

                        <table class="Table3" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="InnerTableContainer">
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="TableContentAndRightShadow">
                                                        <div class="TableContentContainer">
                                                            <table border="0" cellpadding="4" cellspacing="1" width="100%">
                                                                <tbody>

                                                                <tr>
                                                                    <th>Rules</th>
                                                                    <th>Rule Info</th>
                                                                    <th>Punishment</th>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.1 Offensive Statement</l1>
                                                                    </td>

                                                                    <td>
                                                                        Insulting, racist, sexually related, drug-related, harassing or generally objectionable statements.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.2 Spamming</l1>
                                                                    </td>

                                                                    <td>
                                                                        Excessively repeating identical or similar statements or using badly formatted or nonsensical text.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.3 Advertising</l1>
                                                                    </td>

                                                                    <td>
                                                                        Advertise within the game: third-party brands, products or services, non-game content or deal with real money.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.4 Disclosing Personal Data of Others</l1>
                                                                    </td>

                                                                    <td>
                                                                        Disclosing personal data of other people.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.5 Supporting Rule Violation</l1>
                                                                    </td>

                                                                    <td>
                                                                        Statements that support, incite, announce or imply a violation of the Ravenor Online Rules.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.6 Griefing</l1>
                                                                    </td>

                                                                    <td>
                                                                        Abusing or taking advantage of game mechanics and freedoms to deliberately and without justification excessively harass other players within the game, especially in ways that prevent them from progressing or playing the game.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.7 Hostile towards us</l1>
                                                                    </td>

                                                                    <td>
                                                                        Spreading false information or starting propaganda about the server which may cause a reduction of the server's population or harm the server's reputation. Attempting to take advantage of any part of our services by providing incorrect information to staff members.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">2.8 Sale of Accounts</l1>
                                                                    </td>

                                                                    <td>
                                                                        Make trades, announce the sale or purchase of accounts that are not on the official Char Bazaar platform for money in Real Life.
                                                                    </td>

                                                                    <td>
                                                                        Punishment: Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr class="Odd"></tr></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div style="padding: 0.5%"></div>
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

                    <br>

                    <div class="TableContainer">
                        <div class="CaptionContainer">
                            <div class="CaptionInnerContainer">
                                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <div class="Text">3. Cheating</div>
                                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            </div>
                        </div>

                        <table class="Table3" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="InnerTableContainer">
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="TableContentAndRightShadow">
                                                        <div class="TableContentContainer">
                                                            <table border="0" cellpadding="4" cellspacing="1" width="100%">
                                                                <tbody>

                                                                <tr>
                                                                    <th>Rules</th>
                                                                    <th>Rule Info</th>
                                                                    <th>Punishment</th>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">3.1 Bug Abuse</l1>
                                                                    </td>

                                                                    <td>
                                                                        Exploiting obvious errors of the game or any other part of our services.
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">3.2 Using Unofficial Software to Play</l1>
                                                                    </td>

                                                                    <td>
                                                                        Using unofficial software to play games, modify official software or manipulate any hardware
                                                                        Manipulate or modify the official game client program and also accessories such as keyboard, mouse, etc., in order to gain an advantage over other players, abuse the official game client, use additional software to play the game or pretend to cheat to purposely deceive other players.<br><br>

                                                                        This clause will also apply to any malicious detection, EVEN WHEN IT IS BEING USED ON OTHER SERVERS AT THE SAME TIME YOU PLAY RAVENOR. 
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">3.3  Using More Than One Game Client to Play</l1>
                                                                    </td>

                                                                    <td>
                                                                        It is perfectly legal to use more than one game client to play simultaneously with up to two characters (different accounts), but only in circumstances of using the second character to make runes, train skills or hunt monsters.
                                                                        1 player = 2 characters.<br><br>
                                                                        
                                                                        When using two characters, it is prohibited to move or stand in a way that impedes the passage of other players or that interrupts other players in any other way (blocking path, blocking access to or from the hunting zone, blocking access to or from to the depot, blocking spawns, blocking access to NPCs, killing players, etc.)<br><br>
                                                                        
                                                                        It is strictly prohibited to participate in any PvP activities when using two or more game clients.
                                                                        Abusing multi-client by hunting monsters in the same location using both characters (sharing experience points, blocking monsters, healing using a multi-client, etc.) or doing a quest on both characters at the same time is also prohibited.<br><br>
                                                                    </td>

                                                                    <td>
                                                                        Banishment or deletion depending on the severity of the violation.
                                                                    </td>
                                                                </tr>


                                                                <tr class="Odd"></tr></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div style="padding: 0.5%"></div>
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

                    <br>

                    <div class="TableContainer">
                        <div class="CaptionContainer">
                            <div class="CaptionInnerContainer">
                                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <div class="Text">4. Legal Issues</div>
                                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                            </div>
                        </div>

                        <table class="Table3" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="InnerTableContainer">
                                        <table style="width:100%;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <div class="TableContentAndRightShadow">
                                                        <div class="TableContentContainer">
                                                            <table border="0" cellpadding="4" cellspacing="1" width="100%">
                                                                <tbody>

                                                                <tr>
                                                                    <th>Rules</th>
                                                                    <th>Rule Info</th>
                                                                    <th>Note</th>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">4.1 Account Sharing</l1>
                                                                    </td>

                                                                    <td>
                                                                        Offering account details to other players, accepting account details from other players or allowing other players to use your account.
                                                                    </td>

                                                                    <td>
                                                                        Ravenor does not take any responsibility towards the action of sharing accounts.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">4.2 Game Items Trading</l1>
                                                                    </td>

                                                                    <td>
                                                                        Offering virtual items in Ravenor world for real money or products of third parties.
                                                                    </td>

                                                                    <td>
                                                                        Ravenor does not take any responsibility towards the action of selling, buying, sharing or trading in-game items.
                                                                    </td>
                                                                </tr>

                                                                <tr bgcolor="#D4C0A1">
                                                                    <td style="width:100px">
                                                                        <l1 class="rules">4.3 Hacking</l1>
                                                                    </td>

                                                                    <td>
                                                                        Stealing other players' account or personal data.
                                                                    </td>

                                                                    <td>
                                                                        Ravenor does not take any responsibility towards the action of hacking. However, we do consider advertisement of such actions to be penalized which may lead to a deletion of your account.
                                                                    </td>
                                                                </tr>

                                                                <tr class="Odd"></tr></tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div style="padding: 0.5%"></div>
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
                </td>
            </tr>
            </tbody>
        </table>

    <style>
        
        table {
            border-collapse: collapse;
        }

    </style>

@endsection
