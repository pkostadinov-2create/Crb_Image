<?php

abstract class Crb_Image_Size {
	private static $image_sizes = array();
	private $size_type;

	public function sanitize_args($args) {
		if ( !is_array($args) ) {
			global $_wp_additional_image_sizes;
			if ( !empty($_wp_additional_image_sizes[ $args ]) ) {
				$current_size = $_wp_additional_image_sizes[ $args ];
			} else {
				$current_size = crb_get_unregistered_image_size($args);
			}

			if (!empty($current_size)) {
				$args = $current_size;
			}
		}

		return wp_parse_args($args, array(
			'width' => 0,
			'height' => 0,
			'crop' => false,
		));
	}

	private function get_size_type() {
		global $_wp_additional_image_sizes;

		if ( is_array($args) ) {
			$this->size_type = 'Array';
		} elseif ( !empty($_wp_additional_image_sizes[ $args ]) ) {
			$this->size_type = 'Default';
		} elseif (  ) {
			$this->size_type = 'Wp_Thumb';
		}

		if ( !is_array($args) ) {
			global $_wp_additional_image_sizes;
			if ( !empty($_wp_additional_image_sizes[ $args ]) ) {
				$current_size = $_wp_additional_image_sizes[ $args ];
			} else {
				$current_size = crb_get_unregistered_image_size($args);
			}

			if (!empty($current_size)) {
				$args = $current_size;
			}
		}
	}
	
	abstract public function get_args();

	// abstract public function help();
	// abstract public function get_src();
	// abstract public function get();
	// abstract public function get_info();
	// abstract public function get_width();
	// abstract public function get_height();
	// abstract public function get_crop();



	/**
	 * return one of three types of image size class:
	 * _Array - if we have 
	 * _Default - 
	 * _Wp_Thumb - 
	 */
	private function set_size_type() {

	}
	
	private function get_size_type() {

	}
}