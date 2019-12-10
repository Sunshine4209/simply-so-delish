<?php

class JPIBFI_Client_Helper {

	/**
	 * Returns URL address if available in the $css_property_value arg
	 *
	 * @param $css_property_value
	 *
	 * @return string|bool
	 */
	static function get_url_from_css_property( $css_property_value ) {
		$url_pattern = '/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'\".,<>?«»“”‘’]))/i';
		preg_match( $url_pattern, $css_property_value, $url);
		return count($url) > 0 ? $url[0] : false;
	}

	/**
	 * Returns background url if available
	 *
	 * @param $style_attr_value
	 *
	 * @return bool|string
	 */
	static public function get_background_image_url( $style_attr_value ) {
		$background_attr_pattern = '/(background|background-image)\s*:\s*([^;]+)\s*;?/i';
		preg_match( $background_attr_pattern, $style_attr_value, $background_attr );
		if ( count( $background_attr ) == 0 )
			return false;
		$property_value = $background_attr[2];
		return self::get_url_from_css_property( $property_value );
	}
}