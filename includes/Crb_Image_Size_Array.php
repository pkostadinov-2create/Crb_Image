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
class Crb_Image_Size_Array extends Crb_Image_Size {
	private $args;

	public function __construct($args) {
		$this->args = $this->sanitize_args($args);
	}

	protected function sanitize_args($args) {
		return wp_parse_args($args, array(
			'width' => 0,
			'height' => 0,
			'crop' => false,
			'crop_from_position' => apply_filters(
				'Crb_Image_Size_Array/crop_from_position', 
				apply_filters(
					'Crb_Image_Size/crop_from_position', 
					'center,center'
				)
			),
			'jpeg_quality' => apply_filters(
				'Crb_Image_Size_Array/jpeg_quality', 
				apply_filters(
					'Crb_Image_Size/jpeg_quality', 
					90
				)
			),
			'watermark_options' => apply_filters(
				'Crb_Image_Size_Array/watermark_options', 
				apply_filters(
					'Crb_Image_Size/watermark_options', 
					array()
				)
			),
			'type' => 'Array',
		));
	}

	public static function set($args) {

	}
}
