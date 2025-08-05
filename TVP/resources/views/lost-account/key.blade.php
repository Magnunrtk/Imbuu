@extends('template.layout')
@section('title', 'Lost Account')
@section('submenuItem', 'lostaccount')
@section('content')
@if($lostAccount instanceof \App\Models\Account)
    <h2 style="text-align: center;">Email: {{ $emailOrChar }}</h2>
@else
    <h2 style="text-align: center;">Character Name: {{ $emailOrChar }}</h2>
@endif
<br>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">New Recovery Key</div>
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
                            <td>
                                In order to receive a new recovery key, you will have to purchase a new one from the store.
                                <p></p>
                                <p>Once you have done so, you will receive a new recovery key to your current email.</p>
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
<br><br>
<center>
    <form action="{{ route('account.lost.action') }}" method="post" style="padding:0px;margin:0px;">
        @csrf
        <input type="hidden" name="step" value="problem">
        <input type="hidden" name="email_or_char" value="{{ $emailOrChar }}">
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </form>
</center>
@endsection
