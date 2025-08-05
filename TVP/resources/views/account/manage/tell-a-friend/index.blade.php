@extends('template.layout')
@section('title', 'Tell A Friend')
@section('submenuItem', 'accountmanagement')
@section('content')

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Tell-A-Friend</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table5" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Invite New Players', 'Invite friends to join you in {{ config('server.serverName') }}! If they follow your invitation and create an account, you will both earn <b>rewards</b>!<br /><br />You can invite your friends via a link that you can give to them.', 'ProductCategoryHelperDiv_1');" onmouseout="$('#HelperDivContainer').hide();">
                                        <div class="InnerTableTab ActiveInnerTableTab">
                                            <div id="ProductCategoryHelperDiv_1" class="ProductCategoryHelperDiv"></div>
                                            <a href="{{ route('account.manage.tell-a-friend.index') }}">
                                                <img src="{{ asset('/assets/tibiarl/images/content/tab_active.png') }}">
                                                <div class="InnerTableTabLabel">Invite New Players</div>
                                            </a>
                                        </div>
                                    </span>
                                    <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Statistics', 'Here you can see all invitations you have sent.', 'ProductCategoryHelperDiv_3');" onmouseout="$('#HelperDivContainer').hide();">
                                        <div class="InnerTableTab">
                                            <div id="ProductCategoryHelperDiv_3" class="ProductCategoryHelperDiv"></div>
                                            <a href="{{ route('account.manage.tell-a-friend.statistics') }}">
                                                <img src="{{ asset('/assets/tibiarl/images/content/tab_nonactive.png') }}">
                                                <div class="InnerTableTabLabel">Statistics</div>
                                            </a>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr>
                                                @if(is_null(Auth::user()->webAccount->referral))
                                                <form action="{{ route('account.manage.tell-a-friend.create') }}" method="post" class="form">
                                                    @csrf
                                                    <td class="TableTabInnerArea">
                                                        <p><img style="float: right;" src="{{ asset('/assets/tibiarl/images/content/invite-new-players_by-link.png') }}"></p>
                                                        <h3>Create Your Invitation Link</h3>
                                                        <p></p>
                                                        <p>Create a username and get your unique invitation link!<br><br>Are you missing a retired {{ config('server.serverName') }} buddy from the good old days? Do you have a friend that you would like to come back to join you on your {{ config('server.serverName') }} adventure once more?</p>
                                                        <br>
                                                        <table>
                                                            <tbody>
                                                            <tr>
                                                                <td class="LabelV150"><span>{{ route('tell-a-friend') }}/</span></td>
                                                                <td>
                                                                    <input name="name" size="50" maxlength="49" value="" style="width: 320px;">
                                                                </td>
                                                                <td>
                                                                    <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                        <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                                            <input class="BigButtonText" type="submit" value="Submit">
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </form>
                                                @else
                                                <td class="TableTabInnerArea">
                                                    <div id="TAF_Link" style="">
                                                        <h3>Invite by Link</h3>
                                                        <div>
                                                            <p>Share this link with your friends to invite them to {{ config('server.serverName') }}! If a friend follows this link and creates an account, you can see it in the statistics!</p>
                                                            <div>
                                                                <div><input id="ShareLinkInput" readonly="readonly" style="width: 100%; top: 0px;" type="text" value="{{ URL::route('tell-a-friend', [Auth::user()->webAccount->referral]) }}"></div>
                                                                <div>
                                                                    <div style="float: right; margin-bottom: 6px; margin-top: 12px;">
                                                                        <div class="BigButton" onclick="CopyContentOfFormInput('ShareLinkInput');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                                                <input class="BigButtonText" type="button" id="CopyButton" value="Copy Link">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
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
    </div>

    <br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Partnership with Ravenor</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table5" cellpadding="0" cellspacing="0" style="background-color: #d4c0a1">
            <tbody>
            <tr>
                <td style="position: relative">
                    <div style="padding: 3px; width: 98%; margin: 0 auto; text-align:center">
                        <p>Be our partner and receive <b>7 VIP days</b> for each referral that completes our operation. <br>Get our content for dissemination in the media click here <a href="{{ asset('midia.zip') }}" download>download.</a>
                        </p>
                    </div>

                    <div style="text-align:center; padding: 20px">
                        <img src="http://localhost/ravenor-vip.png" style="width: 300px; height: 300px; border-radius: 100%; border: 2px solid rgb(0, 0, 0);
                            box-shadow: 
                                0 0 15px rgba(0, 0, 0, 0.2),
                                0 0 30px rgba(0, 0, 0, 0.4),
                                0 0 45px rgba(0, 0, 0, 0.6),
                                0 0 60px rgba(0, 0, 0, 0.8);">
                    </div>
                    
                    <div style="position: absolute; top: 80px; left: 220px;">
                        <img src="http://localhost/smoke.gif" style="width: 300px; height: 300px;border-radius: 100%;">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <style>
        .requirements tr, .requirements td {
            border: 1px solid #faf0d7;
        }
    </style>

    <br>

    @if($invitedAccounts && $bonusRecive == null) 

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Bonus redemption</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table5" cellpadding="0" cellspacing="0" style="background-color: #d4c0a1">
            <tbody>
            <tr>
                <td>
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>

                                            <p>You will get an additional <b>3 VIP days</b> after activation.</p>
                                            <p>Reference link used: <a href="{{ route('tell-a-friend') . '/' . $invitedAccounts[0] }}">{{ route('tell-a-friend') . '/' . $invitedAccounts[0] }}</a></p>

                                            <div class="TableContentContainer">
                                                <table class="TableContent" style="border:1px solid #faf0d7;" width="100%">
                                                    <tbody class="requirements">
                                                        <tr>
                                                            <td style="vertical-align: middle; width: 10px">
                                                                <img src="{{ $existsPaidOrder ? asset('/assets/tibiarl/images/premiumfeatures/icon_yes.png') : asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}">
                                                            </td>
                                                            <td>
                                                                You must make at least one deposit.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;">
                                                                <img src="{{ $existingRecord ? asset('/assets/tibiarl/images/premiumfeatures/icon_yes.png') : asset('/assets/tibiarl/images/premiumfeatures/icon_no.png') }}">
                                                            </td>
                                                            <td>                                                           
                                                                Make a purchase for at least 30 VIP days.
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        @if($existsPaidOrder && $existingRecord)
                                            <table>
                                                <tr>
                                                    <td>
                                                        <p><b>Note:</b> to receive the VIP you must log in to the account again. It's not just on the character selection page, it's on the initial input field where you enter your password and account number.</p>
                                                    </td>
                                                </tr>
                                        
                                                <tr>
                                                    <td>
                                                        <div style="float: right">
                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                    <div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }}); visibility: hidden;"></div>
                                                                    <input class="BigButtonText" type="button" id="GetBonusButton" value="Get Bonus">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        
                                            <script>
                                                $(document).ready(function() {
                                                    $('#GetBonusButton').click(function() {
                                                        $.ajax({
                                                            url: '{{ url('/account/store-vip-accumulated') }}',
                                                            type: 'POST',
                                                            data: {
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            success: function(response) {
                                                                alert(`${response['message']}`);
                                                            },
                                                            error: function(xhr) {
                                                                alert('An error occurred: ' + xhr.status + ' ' + xhr.statusText);
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        @endif
                                        
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

    @endif

    <br>
    <center>
        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>
@endsection