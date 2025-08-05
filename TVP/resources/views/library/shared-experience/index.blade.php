@extends('template.layout')
@section('title', 'Shared Experience')
@section('submenuItem', 'sharedexperience')
@section('content')
    <center><h1>Shared Experience System</h1></center>
    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
        <tbody>
        <tr>
            <td class="NewsTableContainer">
                <p><img src="{{ asset('/assets/tibiarl/images/letters/letter_martel_G.gif') }}" border="0" align="bottom">et ready to enhance your gaming adventures with your party members. With Shared Experience enabled, experience points are distributed among all members of your party, making your journey even more rewarding.</p>
                <p>Means you'll be able to level up at an accelerated rate, forging stronger characters together! To make the most of Shared Experience, there are a few conditions to keep in mind.</p>
                <p class="MsoNormal" style="margin-bottom: 0cm;"><img class="NewsImageLinkThumbnail" src="{{ asset('/assets/tibiarl/images/sharedexperience/shared_experience.gif') }}" hspace="10" vspace="10" width="202" height="233" align="left" onclick="ImageInNewWindow('{{ asset('/assets/tibiarl/images/sharedexperience/shared_experience.gif') }}');"></p>
                <p>Firstly, ensure that you're in a party, collaborating with fellow adventurers. Additionally, for experience to be shared, your party members should have a level that is at least 2/3 of your own level. This requirement ensures that party members are reasonably aligned in their progression, fostering balanced growth within the group.</p>
                <p>But that's not all—active participation in combat is key to reaping the benefits of Shared Experience. Engage in fierce battles, whether it's dealing devastating attacks or providing vital healing support to your comrades. By actively contributing to the fights, you'll ensure a fair distribution of experience points among those who actively partake in the adventures.</p>
                <p>Embrace the power of Shared Experience and embark on an epic journey alongside your party members. Work together, conquer challenges, and watch as your experience points soar to new heights. Level up faster, strengthen your bonds, and enjoy the immersive cooperative gameplay that awaits you. The world is yours to conquer, so assemble your party and let the shared adventure begin!</p>
                <ul class="BulletPointList">
                    <br>
                    <li><img src="{{ asset('/assets/tibiarl/images/content/bullet.gif') }}"><strong>Party Membership:</strong> Players must join a party to access the benefits of shared experience.</li>
                    <li><img src="{{ asset('/assets/tibiarl/images/content/bullet.gif') }}"><strong>Level Proximity:</strong> Party members should have a level that is at least 2/3 of the player's level, ensuring reasonable alignment of progression within the group.</li>
                    <li><img src="{{ asset('/assets/tibiarl/images/content/bullet.gif') }}"><strong>Active Participation:</strong> Players must actively engage in combat by either healing or attacking to qualify for shared experience points.</li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>

    <br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Bonus Information</div>
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
            <div class="TableScrollbarWrapper" style="width: unset;">
                <div class="TableScrollbarContainer"></div>
            </div>
            <div class="InnerTableContainer" style="max-width: unset;">
                <table style="width:100%;">
                <tbody>
                    <tr>
                    <td>
                        <div class="TableContentContainer">
                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                            <tbody>
                                <tr class="Odd">
                                    <td class="LabelV175" colspan="2">
                                        When any vocation is repeated—regardless of hunting party size—the bonus is capped at 10%.
                                    </td>
                                </tr>
                                <tr class="Even">
                                    <td class="LabelV175">Hunting Bonus (2 vocations, same or different):</td>
                                    <td>10% extra experience when hunting with two vocations, even if they are the same.</td>
                                </tr>
                                <tr class="Odd">
                                    <td class="LabelV175">Hunting Bonus (3 different vocations):</td>
                                    <td>15% extra experience when hunting with three different vocations.</td>
                                </tr>
                                <tr class="Even">
                                    <td class="LabelV175">Hunting Bonus (4 different vocations):</td>
                                    <td>20% extra experience when hunting with four different vocations.</td>
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
    
@endsection
