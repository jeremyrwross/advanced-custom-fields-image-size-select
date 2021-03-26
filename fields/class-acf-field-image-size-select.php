<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AcfFieldImageSizeSelect' ) ) {


	class AcfFieldImageSizeSelect extends acf_field {

		function __construct( $settings ) {

			/*
			*  name (string) Single word, no spaces. Underscores allowed
			*/
			$this->name = 'image_size_select';

			/*
			*  label (string) Multiple words, can include spaces, visible when selecting a field type
			*/
			$this->label = 'Image Size';

			/*
			*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			*/
			$this->category = 'choice';

			/*
			*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
			*/
			$this->defaults = array(
				'image_size' => '',
			);

			/*
			*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
			*/
			$this->settings = $settings;

			/*
			*  image_sizes (array) Store all image sizes.
			*/
			$this->image_sizes = $this->get_image_sizes();

			parent::__construct();

		}


		/*
		*  render_field_settings()
		*
		*  Create settings the field. These are visible when editing a field.
		*/

		function render_field_settings( $field ) {

			acf_render_field_setting( $field, array(
				'label'         => 'Image Sizes',
				'instructions'  => 'Select which image sizes appear.',
				'type'          => 'select',
				'name'          => 'image_size',
				'choices'       => $this->create_field_choices(),
				'multiple'      => 1,
				'ui'            => 1,
				'allow_null'    => 1,
				'placeholder'   => __( 'All image sizes', 'acf-image-size-select' ),
			));

			acf_render_field_setting( $field, array(
				'label'			=> 'Show Dimensions',
				'instructions'	=> 'Display the image size inside the drop down.',
				'type'			=> 'true_false',
				'name'			=> 'show_dimensions',
				'ui'			=> 1,
			));

		}


		/*
		*  get_image_sizes()
		*
		*  Create settings the field. These are visible when editing a field.
		*/

		function get_image_sizes( $single_size = '' ) {

			$sizes       = array();
			$image_sizes = get_intermediate_image_sizes();
			$image_names = apply_filters(
				'image_size_names_choose',
				array(
					'thumbnail' => 'Thumbnail',
					'medium'    => 'Medium',
					'large'     => 'Large',
					'full'      => 'Full Size',
				)
			);

			foreach ( $image_sizes as $size ) {

				// If single size is set, and this loop isn't the size requested, then skip.
				if ( $single_size && $size != $single_size ) {
					continue;
				}

				$dimensions = $this->get_image_dimensions( $size );

				if ( isset( $image_names[ $size ] ) && $size != $image_names[ $size ] ) {
					$name = $image_names[ $size ];
				} else {
					$name = $size;
				}

				$sizes[ $size ] = array(
					'name'   => $name,
					'width'  => intval( $dimensions['width'] ),
					'height' => intval( $dimensions['height'] ),
					'crop'   => $dimensions['crop'],
				);

			}

			// Return only 1 size if set
			if ( $single_size ) {
				if ( isset( $sizes[ $single_size ] ) ) {
					return $sizes[ $single_size ];
				} else {
					return false;
				}
			}

			return $sizes;
		}


		/*
		*  get_image_dimensions()
		*
		*  Retrive image dimensions based on the image size name.
		*  https://developer.wordpress.org/reference/functions/get_intermediate_image_sizes/#comment-730
		*/

		function get_image_dimensions( $single_size = '' ) {
			global $_wp_additional_image_sizes;

			$sizes       = array();
			$image_sizes = get_intermediate_image_sizes();

			// Create the full array with sizes and crop info
			foreach ( $image_sizes as $_size ) {
				if ( in_array( $_size, array( 'thumbnail', 'medium', 'large', 'medium_large' ) ) ) {
					$sizes[ $_size ] = array(
						'width'  => intval( get_option( $_size . '_size_w' ) ),
						'height' => intval( get_option( $_size . '_size_h' ) ),
						'crop'   => (bool) get_option( $_size . '_crop' ),
					);
				} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
					$sizes[ $_size ] = array(
						'width'  => intval( $_wp_additional_image_sizes[ $_size ]['width'] ),
						'height' => intval( $_wp_additional_image_sizes[ $_size ]['height'] ),
						'crop'   => (bool) $_wp_additional_image_sizes[ $_size ]['crop'],
					);
				}
			}

			// Return only 1 size if set
			if ( $single_size ) {
				if ( isset( $sizes[ $single_size ] ) ) {
					return $sizes[ $single_size ];
				} else {
					return false;
				}
			}
			return $sizes;
		}

		/*
		*  create_field_choices()
		*
		*  Create the array data for the HTML interface.
		*/
		function create_field_choices() {

			$choices = array();

			foreach ( $this->image_sizes as $size => $settings ) {
				$choices[ $size ] = $settings['name'] . ' (' . $settings['width'] . ' x ' . $settings['height'] . ')';
			}

			return $choices;

		}

		/*
		*  render_field()
		*
		*  Create the HTML interface for the field.
		*/
		function render_field( $field ) {

			$image_sizes = array();

			if ( ! $field['image_size'] ) {
				$image_sizes = $this->image_sizes;
			} else {
				foreach ( $field['image_size'] as $image_size ) {
					$image_settings = $this->get_image_sizes( $image_size );
					if ( $image_settings ) {
						$image_sizes = array_merge( $image_sizes, array( $image_size => $image_settings ) );
					}
				}
			}

			echo '<select name="' . esc_attr( $field['name'] ) . '" value="' . esc_attr( $field['value'] ) . '">';

			foreach ( $image_sizes as $size => $settings ) {

				echo '<option value="' . esc_attr( $size ) . '"';

				if ( $size === $field['value'] ) {
					echo ' selected="selected"';
				}

				echo '>' . esc_html( $settings['name'] ) . '';

				if ( $field['show_dimensions'] ) {
					echo ' (' . esc_html( $settings['width'] ) . ' x ' . esc_html( $settings['height'] ) . ')';
				}

				echo '</option>';
			}
			echo '</select>';
		}
	}

	new AcfFieldImageSizeSelect( $this->settings );

}
