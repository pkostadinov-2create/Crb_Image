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
class Crb_Image_Size_Wpthumb extends Crb_Image_Size {
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
				'Crb_Image_Size_Wpthumb/crop_from_position', 
				apply_filters(
					'Crb_Image_Size/crop_from_position', 
					'center,center'
				)
			),
			'jpeg_quality' => apply_filters(
				'Crb_Image_Size_Wpthumb/jpeg_quality', 
				apply_filters(
					'Crb_Image_Size/jpeg_quality', 
					90
				)
			),
			'watermark_options' => apply_filters(
				'Crb_Image_Size_Wpthumb/watermark_options', 
				apply_filters(
					'Crb_Image_Size/watermark_options', 
					array()
				)
			),
			'type' => 'Wpthumb',
		));
	}

	public static function get_info($image, $args, $additional_atts) {
		$args = $this->sanitize_args($args);

		$args_attrs = array( 'class', 'alt' );
		$attrs = array();

		foreach ( $args_attrs as $att ) {
			if ( isset( $args[$att] ) ) {
				$attrs[$att] = $args[$att];
				unset( $args[$att] );
			}
		}

		if ( !empty( $args ) ) {
			$url = esc_url( $args['url'] );
			unset( $args[0] );

			$image = wpthumb( $url, $args );

			list( $width, $height ) = getimagesize( $image );

			$attr = '';

			foreach ( $attrs as $a => $value ) {
				$attr .= ' ' . $a . '="' . esc_attr( $value ) . '"';
			}

			return array(
				'src' => $image,
				'width' => $width,
				'height' => $height,
				'attr' => $attr
			);
		}
	}

}
