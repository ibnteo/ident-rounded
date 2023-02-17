<?php
/*
 * echo IdentRounded::svg('id1', 128);
 */
class IdentRounded {
	static function svg($text, $size=64) {
		$hash = md5($text);
		$svg = "<svg width=\"$size\" height=\"$size\" viewBox=\"0 0 128 128\">";
		$svg .= '<defs><clipPath id="rounded-circle"><circle cx="64" cy="64" r="64"/></clipPath></defs>';
		for ($i=0; $i<5; $i++) {
			$rgb = [];
			for ($ci=0; $ci<3; $ci++) {
				$rgb[] = self::map(hexdec(substr($hash, $i*6+$ci, 2)), 0, 255, 25, 200);
			}
			$x = $i == 0 ? 64 : self::map(hexdec(substr($hash, $i*2+6, 2)), 0, 255, 0, 128);
			$y = $i == 0 ? 64 : self::map(hexdec(substr($hash, $i*2+8, 2)), 0, 255, 0, 128);
			$r = $i == 0 ? 64 : self::map(hexdec(substr($hash, $i*2+10, 2)), 0, 255, (6-$i)*5+20, (6-$i)*5+30);
			$svg .= "<circle cx=\"$x\" cy=\"$y\" r=\"$r\" fill=\"rgb($rgb[0], $rgb[1], $rgb[2])\" clip-path=\"url(#rounded-circle)\"/>";
		}
		$svg .= '</svg>';
		return $svg;
	}
	private static function map($value, $fromLow, $fromHigh, $toLow, $toHigh) {
		$fromRange = $fromHigh - $fromLow;
		$toRange = $toHigh - $toLow;
		$scaleFactor = $toRange / $fromRange;
		$tmpValue = $value - $fromLow;
		$tmpValue *= $scaleFactor;
		return $tmpValue + $toLow;
	}
}
