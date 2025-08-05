<?php
if (isset($_GET['txt'])) {
    $text = trim($_GET['txt']);
    if (!empty($text)) {
        if (strlen($text) > 35) {
            exit;
        }
        $text = ucfirst($text);
        $size = 18;
        $sizex = 320;
        $sizey = 28;
        $x = 4;
        $y = 20;
        $color = 'efcfa4';

        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));

        $img = imagecreatetruecolor($sizex, $sizey);
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $transparentColor = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparentColor);

        $outlineColor = imagecolorallocate($img, 0, 0, 0);
        $textColor = imagecolorallocate($img, $red, $green, $blue);
		$fontFile = __DIR__ . '/headline.ttf';
        for ($ox = -1; $ox <= 1; $ox++) {
            for ($oy = -1; $oy <= 1; $oy++) {
                imagettftext($img, $size, 0, $x + $ox, $y + $oy, $outlineColor, $fontFile, $text);
            }
        }

        imagettftext($img, $size, 0, $x, $y, $textColor, $fontFile, $text);

        header('Cache-Control: public, max-age=3600');
        header('Content-type: image/png');
        imagepng($img);
        imagedestroy($img);
        exit;
    }
}
