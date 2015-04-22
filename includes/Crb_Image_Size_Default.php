<?php

/**
 * 
 * 'width' => $widgt,
 * 'height' => $height,
 * 'crop' => $crop,
 * 'crop_from_position' => $crop_from_position,
 * 'jpeg_quality' => $jpeg_quality,
 * 'watermark_options' => $watermark_options,
 * 'type' => $type,
 * 
 */
class Crb_Image_Size_Default extends Crb_Image_Size {
	private $args;

	public function __construct($args) {
		$this->args = $this->sanitize_args($args);

		return $this;
	}

	public function sanitize_args($args) {
		if ( is_array($args) ) {
			$args = wp_parse_args($args, array(
				'name' => '',
				'width' => 0,
				'height' => 0,
				'crop' => false,
			));
		}

		return $args;
	}

	public static function get_info($image, $args, $additional_atts) {
		$args = $this->sanitize_args($args);

		wp_get_attachment_image_src( $attachment_id, $args );
		$image_data = wp_get_attachment_image_src($image, $args);
		if ( empty($image_data[0]) ) {
			return;
		}

		return array(
			'url' => $image_date[0],
			'width' => $image_date[1],
			'height' => $image_date[2],
			'crop' => false,
			'atts' => '',
		);
	}	
}