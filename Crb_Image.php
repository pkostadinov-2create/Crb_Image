<?php

include_once('includes/Crb_Image_Size.php');
include_once('includes/Crb_Image_Size_Array.php');
include_once('includes/Crb_Image_Size_Default.php');
include_once('includes/Crb_Image_Size_Wp_Thumb.php');
include_once('includes/wp-thumb/wpthumb.php');

class Crb_Image {

	public static function help($args) {
		$args = Crb_Image_Size::sanitize_args($args);

		$before = 'Largest image size: ';

		$after = ' px. Larger images will be scaled down ';
		if ( $args['crop'] ) {
			$before = 'Recommended image size: ';
			$after .= 'and cropped ';
		} else {
			$after .= 'to fit this size ';
		}
		$after .= 'automatically.';
		
		return $before . $args['width'] . ' x ' . $args['height'] . $after;

	}


	public static function get_src() {

	}

	public static function get() {

	}

	public static function get_info() {

	}

	public static function get_width() {

	}

	public static function get_height() {

	}

	public static function get_crop() {

	}

}