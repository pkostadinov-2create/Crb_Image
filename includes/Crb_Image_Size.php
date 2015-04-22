<?php

abstract class Crb_Image_Size {
	/** 
	 * $image_sizes example:
	 * 
	 *  array(
	 *  	$name => $instance,
	 *  )
	 * 
	 */
	private static $image_sizes = array();

	/**
	 * Accepts array of args, example:
	 *  
	 *  
	 * @param $args - accepts either:
	 *  $image_size_name
	 * 
	 *  array(
	 *  	'width' => $width,
	 *  	'height' => $height,
	 *  	'crop' => $crop,
	 *  )
	 * 
	 * @param $additional_atts - accepts array with additional args
	 * 
	 */
	public static function get($image, $args, $additional_atts = array()) {
		$image_info = $this->get_info($image, $args, $additional_atts);

		return '
		<img 
			src="' . $image_info['url'] . '" 
			width="' . $image_info['width'] . '" 
			height="' . $image_info['height'] . '" ' . 
			$image_info['atts'] . ' 
		/>';
	}

	public static function get_url($image, $args, $additional_atts = array()) {
		$image_info = $this->get_info($image, $args, $additional_atts);

		return $image_info['url'];
	}

	public static function get_width($image, $args, $additional_atts = array()) {
		$image_info = $this->get_info($image, $args, $additional_atts);

		return $image_info['width'];
	}

	public static function get_height($image, $args, $additional_atts = array()) {
		$image_info = $this->get_info($image, $args, $additional_atts);

		return $image_info['height'];
	}

	public static function get_crop($image, $args, $additional_atts = array()) {
		$image_info = $this->get_info($image, $args, $additional_atts);

		return $image_info['height'];
	}

	public static function get_info($image, $args, $additional_atts = array()) {
		$args = $this->sanitize_args($args);
		$name = $args['name'];

		$info = self::$image_sizes[$name]->get_info($image, $args);

		$info['atts'] = $this->sanitize_additional_atts($additional_atts, $name);

		return $info;
	}

	/**
	 * 
	 * Accepts array of args, example:
	 * 
	 *  $name = 'crb_100_100_false'
	 * 
	 *  array(
	 *  	'name' => $name,
	 *  	'width' => $width,
	 *  	'height' => $height,
	 *  	'crop' => $crop,
	 *  )
	 * 
	 *  array(
	 *  	'name' => 'crb_100_100_false',
	 *  )
	 * 
	 *  array(
	 *  	'width' => $width,
	 *  	'height' => $height,
	 *  	'crop' => $crop,
	 *  )
	 * 
	 */
	public static function set($args) {
		if ( !empty(self::$image_sizes[$image_size_name]) ) {
			return self::$image_sizes[$image_size_name];
		}

		$type = $this->get_image_type($args);
		$class_name = 'Crb_Image_Size_' . $type;

		$args = $this->sanitize_args($args);

		self::$image_sizes[$image_size_name] = new $class_name($args);

		return self::$image_sizes[$image_size_name];
	}

	/* ==========================================================================
		# Private Functions Below
	========================================================================== */

	/**
	 * Returns Image_Size type
	 */
	private function get_image_type($args) {
		$type = '';

		if ( $this->is_default_size($args) ) {
			$type = 'Default';
		} else {
			$type = 'Wpthumb';
		}

		return $type;
	}

	/**
	 * Prepares the additional img attributes
	 */
	public function sanitize_additional_atts($additional_atts, $size_name) {
		$additional_atts_output = '';
		$additional_atts = wp_parse_args($additional_atts, array(
			'class' => '',
			'alt' => '',
		));

		$additional_atts['class'] .= ' ' . $name;

		foreach ( $additional_atts as $attr => $value ) {
			$additional_atts_output .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
		}

		return $additional_atts_output;
	}

	/**
	 * Takes care of cases when the image size is defined only with 
	 * name -> example crb_100_100_false
	 * image sizes -> example array('width' => 100, 'height' => 100)
	 */
	private function sanitize_args($args) {
		$args = wp_parse_args($args, array(
			'width' => 0,
			'height' => 0,
			'crop' => false,
		));

		if ( $this->is_array_size($args) ) {
			$args['name'] = 'crb_' . $args['width'] . '_' . $args['height'] . '_' . $args['crop'];
		} elseif ( $this->is_name_size($args) ) {
			$name_args = explode('_', $args['name']);
			if ( 
				$name_args[0] == 'crb' && 
				is_numeric($name_args[1]) && 
				is_numeric($name_args[2]) && 
				in_array($name_args[3], array('true', 'false')) 
			) {
				$args = array(
					'name' => $args['name'],
					'width' => intval($name_args[1]),
					'height' => intval($name_args[2]),
					'crop' => $name_args[3],
				);
			}
		}

		return $args;
	}

	/**
	 * Helper Checks
	 */
	private function is_array_size($args) {
		return empty($args['name']) && !empty($args['width']) && !empty($args['height']);
	}
	private function is_name_size($args) {
		return !empty($args['name']) && empty($args['width']) && empty($args['height']);
	}
	private function is_default_size($args) {
		global $_wp_additional_image_sizes;

		return !empty($args['name']) && !empty($_wp_additional_image_sizes[$args['name']]);
	}
}