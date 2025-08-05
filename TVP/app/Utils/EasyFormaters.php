<?php 
/*
* @description Char-Bazaar - Montagem de Box
* @author Rickson Kauê
* @date Data de criação 05/12/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
*/

declare(strict_types=1);

namespace App\Utils;

class  EasyFormaters{
    public static function small_box(string $contentBox): string{

        $contentBox = '

            <div class="SmallBox">
                <div class="MessageContainer">
                <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                <div class="BoxFrameEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="BoxFrameEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="Message">
                <div class="BoxFrameVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                <div class="BoxFrameVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
                    <table>
                        <tbody>
                            <tr>
                            <td>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td style="border:0px; font-weight:bold">
                                                '.$contentBox.'
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
                <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
                </div>
            </div>
        
        ';
        
        return $contentBox;
    }

    public static function progressBar(array $colorBars, $finalBar): string {
        $colors = [0 => "green.gif", 1 => "green-blue.gif", 2 => "blue.gif"];
        $sizesBar = [0, 35, 35, 30];
        $steps = [
            ['icon' => 'progress-bar-icon-2-', 'text' => 'Select Character'],
            ['icon' => 'progress-bar-icon-1-', 'text' => 'Check Character'],
            ['icon' => 'progress-bar-icon-3-', 'text' => 'Set up auction'],
            ['icon' => 'progress-bar-icon-4-', 'text' => 'Confirm auction'],
        ];
    
        $progressBar = "
            <div id='ProgressBar'>
                <div id='MainContainer'>
                    <div id='BackgroundContainer'>
                        <img id='BackgroundContainerLeftEnd' src='" . asset('/assets/tibiarl/images/content/stonebar-left-end.gif') . "'>
                        <div id='BackgroundContainerCenter'>
                            <div id='BackgroundContainerCenterImage' style='background-image:url(" . asset('/assets/tibiarl/images/content/stonebar-center.gif') . ");'></div>
                        </div>
                        <img id='BackgroundContainerRightEnd' src='" . asset('/assets/tibiarl/images/content/stonebar-right-end.gif') . "'>
                    </div>
                    <img id='TubeLeftEnd' src='" . asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-left-green.gif') . "'>
                    <img id='TubeRightEnd' src='" . asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-right-'.$colors[$finalBar].'') . "'>
                    <div id='FirstStep' class='Steps'>
                        <div class='SingleStepContainer'>
                            <img class='StepIcon' src='" . asset('/assets/tibiarl/images/content/progressbar/progress-bar-icon-2-green.gif') . "'>
                            <div class='StepText' style='font-weight:bold;'>Select Character</div>
                        </div>
                    </div>
                    <div id='StepsContainer1'>
                        <div id='StepsContainer2'>
        ";

    
        for ($i = 0; $i < count($steps); $i++) {
            $progressBar .= "
                <div class='Steps' style='width:" . $sizesBar[$i] . "%'>
                    <div class='TubeContainer'>
                        <img class='Tube' src='" . asset('/assets/tibiarl/images/content/progressbar/progress-bar-tube-'.$colors[($colorBars[$i][0])]) . "'>
                    </div>";

                $progressBar .= "
                    <div class='SingleStepContainer'>
                        <img class='StepIcon' src='" . asset('/assets/tibiarl/images/content/progressbar/' . $steps[$i]['icon'] . $colors[($colorBars[$i][1])]) . "'>
                        <div class='StepText'>" . $steps[$i]['text'] . "</div>
                    </div>
                </div>";
        }
    
        $progressBar .= "
                        </div>
                    </div>
                </div>
            </div>
        ";
    
        return $progressBar;
    }
    
    
    
}
