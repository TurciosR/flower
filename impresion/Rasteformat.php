<?php
/**
 * This is a minimal ESC/POS printing script which uses the 'raster format'
 * of image output.
 *
 * The snippet is designed to efficiently delegate image processing to
 * ImageMagick, rather than spend CPU cycles looping over pixels.
 *
 * Do not attempt to use this snippet in production, get a copy of escpos-php instead!
 */

/**
 * Return data in raster format. This leverages the fact that the PBM image format data
 * is identical to ESC/POS raster data (just the header changes)
 *
 * @param Imagick $im
 * @param int $lineHeight
 *        	Height of printed line in dots. 8 or 24.
 * @return string[]
 */
 class Rasteformat
 {
	function toRasterFormat($im) {
		$im -> setFormat('pbm');
		$blob = $im -> getImageBlob();
		$i = strpos($blob, "\n", 3); // Find where header ends
		return substr($blob, $i + 1);
	}

	/**
	 * Generate number as ESC/POS image header
	 *
	 * @param int $input
	 *        	number
	 * @param int $length
	 *        	number of bytes output
	 * @return string
	 */
	 function intLowHigh($input, $length) {
		$outp = "";
		for($i = 0; $i < $length; $i ++) {
			$outp .= chr ( $input % 256 );
			$input = ( int ) ($input / 256);
		}
		return $outp;
	}
function init($filename){
		// Configure
		$highDensityHorizontal = true;
		$highDensityVertical = true;

		// Load image
		$im = new \Imagick();
		$im->setResourceLimit ( 6, 1 ); // Prevent libgomp1 segfaults, grumble grumble.
		$im -> readimage($filename);
    $im->scaleImage(300, 200, true);
		// Print
		$GS = "\x1d";

		$widthBytes = intval(($im -> getimagewidth() + 7) / 8);
		$heightPixels = $im -> getimageheight();
    $v1=self::intLowHigh($widthBytes, 2);
    $v2 =self::intLowHigh($heightPixels, 2);
		$densityByte = ($highDensityHorizontal ? 0 : 1) + ($highDensityVertical ? 0 : 2);
		$header = $GS . "v0" . chr($densityByte) . $v1 . $v2;
		$imagen= $header . self::toRasterFormat($im);
		return $imagen;
	}
}
?>
