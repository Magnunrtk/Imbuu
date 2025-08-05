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
                                        <div class="InnerTableTab">
                                            <div id="ProductCategoryHelperDiv_1" class="ProductCategoryHelperDiv"></div>
                                            <a href="{{ route('account.manage.tell-a-friend.index') }}">
                                                <img src="{{ asset('/assets/tibiarl/images/content/tab_nonactive.png') }}">
                                                <div class="InnerTableTabLabel">Invite New Players</div>
                                            </a>
                                        </div>
                                    </span>
                                    <span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'Statistics', 'Here you can see all invitations you have sent.', 'ProductCategoryHelperDiv_3');" onmouseout="$('#HelperDivContainer').hide();">
                                        <div class="InnerTableTab ActiveInnerTableTab">
                                            <div id="ProductCategoryHelperDiv_3" class="ProductCategoryHelperDiv"></div>
                                            <a href="{{ route('account.manage.tell-a-friend.statistics') }}">
                                                <img src="{{ asset('/assets/tibiarl/images/content/tab_active.png') }}">
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
                                                <td class="TableTabInnerArea">
                                                    <p></p>
                                                    <h3>New {{ config('server.serverName') }} Friends Invited Via Link<span style="position: relative; top: 3px; margin-left: 5px;"><a href="#" target="_blank"><span class="HelperDivIndicator" onmouseover="ActivateHelperDiv($(this), 'New ServerName Friends Invited Via Link', '<p>See here which friends you have invited to ServerName and if they have already created an account with your invitation.</p>', '', '{{ config('server.serverName') }}');" onmouseout="$('#HelperDivContainer').hide();"><img style="border:0px;" src="{{ asset('/assets/tibiarl/images/mmorpg/info.gif') }}"></span></a></span></h3>
                                                    <p></p>
                                                    <table style="width: 100%; padding: 0px;" class="TAF_RewardContainer">
                                                        <tbody>
                                                        <tr class="LabelH">
                                                            <td style="width: 100px;">Date</td>
                                                            <td style="width: 45%;">Friend</td>
                                                            <td>Source</td>
                                                            <td>State</td>
                                                            <td style="width: 100px">Redeem</td>
                                                        </tr>
                                                        @forelse($invitedAccounts as $account)

                                                            @php
                                                                if($account->bonus_recive == 2){

                                                                    continue;
                                                                }
                                                            @endphp

                                                            <tr class="Even">
                                                                <td><nobr>{{ date('M d Y', strtotime($account->created_at)) }}</nobr></td>
                                                                <td><a href="{{ route('community.view.character.search', [Str::strToUrl($account->characters->first()->name)]) }}"> {{ $account->characters->first()->name }}</a></td>
                                                                <td>Link</td>
                                                                <td>joined</td>
                                                                <td>
                                                                    @if($account->bonus_recive == 1)
                                                                        <div style="float: right">
                                                                            <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_green.gif') }})">
                                                                                <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                                                                    <div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_green_over.gif') }}); visibility: hidden;"></div>
                                                                                    <input class="BigButtonText" type="button" id="GetBonusButton" value="Get Bonus">
                                                                                </div>
                                                                            </div>
                                                                        </div>         
                                                                        
                                                                        <script>
                                                                            $(document).ready(function() {
                                                                                $('#GetBonusButton').click(function() {
                                                                                    $.ajax({
                                                                                        url: '{{ url('/account/bonus-give') }}',
                                                                                        type: 'POST',
                                                                                        data: {
                                                                                            _token: '{{ csrf_token() }}',
                                                                                            name: '{{ $account->characters->first()->name }}'
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
                                                                    @else                                                                                                                                   
                                                                        Not ready to redeem yet.
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr class="Odd">
                                                                <td colspan="5">No invitations yet.</td>
                                                            </tr>
                                                        @endforelse
                                                        </tbody>
                                                    </table>
                                                    <small>
                                                        <div style="float: left;"><b>» Pages: <span class="PageLink "><span class="CurrentPageLink">1</span></span></b></div>
                                                        <div style="float: right;"><b>» Results: 1</b></div>
                                                    </small>
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
    </div>
    <br>
    <center>
        <div class="BigButton" onclick="RedirectToUrl('{{ route('account.manage.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>
@endsection