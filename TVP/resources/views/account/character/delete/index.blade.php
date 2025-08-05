@extends('template.layout')
@section('title', 'Account Management')
@section('submenuItem', 'accountmanagement')
@section('content')

    @php
        if($name == null){

            $name = session('name');
        }
    @endphp

    {!! $formaters->small_box("
        <h3>Character Removal Procedure</h3>
        <h4>Dear player,</h4>
        <p>We would like to inform you about an important procedure related to removing characters in our game. We understand that for different reasons you may want to remove a character from your account. However, it is crucial that you are aware of the implications before proceeding with this action.</p>
        <p>When removing a character, all items associated with it will be irreversibly lost. This includes equipment, belongings, houses, guild membership, and any progress associated with that character. This is a final process and there will be no possibility of recovery.</p>
        <h4>Steps for Character Removal:</h4>
        <p>Recovery Key:<br>To ensure the security of your account, the character removal process requires the use of your recovery key. The recovery key is an additional protection measure to prevent unauthorized removal. Make sure you have access to your recovery key before starting the process.</p>
        <p>Irreversibility:<br>After confirmation of removal, all data associated with the character will be permanently deleted. This includes items, achievements, houses, and any guild affiliations.</p>
        <p>Careful in Decision:<br>We recommend that you carefully evaluate the decision to remove a character, considering all the consequences involved. Make sure you are absolutely sure before proceeding.</p>
        <p>Removal Instructions:<br>Insert your recovery key to confirm.</p>
        We thank you for your understanding and cooperation. If you have any questions or concerns, please don't hesitate to contact our support team.
    ") !!}

    <br>
    
    <form method="post" action="{{ route('account.delete.action', ['id' => $name]) }}" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Remove Character</div>
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
                                            <div class="TableContentContainer">
                                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                    <tbody>
                                                    <tr class="LabelH">
                                                        <td style="width:50%;">
                                                            <span>Name</span>
                                                        </td>
                                                        <td>
                                                            <span>Recovery Key</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="Even">
                                                        <td>
                                                            <p>{{ $name }}</p>
                                                        </td>
                                                        <td>
                                                            <input name="recovery_key" id="recovery_key" value="">
                                                            <br>
                                                            <span style="font-size: 10px">
                                                                <div id="character_error">Please enter your Recovery Key.</div>
                                                            </span>
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
                        <div class="InnerTableContainer">
                            <table style="width: 100%;">
                                <tbody>
                                <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        <table style="width:100%;">
            <tbody>
            <tr align="center">
                <td>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="border:0px;">
                                <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                        <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                        <input class="BigButtonText" type="submit" value="Submit">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="border:0px;">
                                <div class="BigButton" onclick="RedirectToUrl('{{ route('account.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                                        <div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                        <input class="BigButtonText" type="button" value="Back">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
@endsection
