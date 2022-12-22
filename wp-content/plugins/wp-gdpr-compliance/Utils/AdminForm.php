<?php

namespace WPGDPRC\Utils;

use WPGDPRC\WordPress\Plugin;
use WPGDPRC\WordPress\Settings;

/**
 * Class AdminForm
 * @package WPGDPRC\Utils
 */
class AdminForm {

	/**
	 * Renders a form field row
	 *
	 * @param string $type
	 * @param string $label
	 * @param string $name
	 * @param string $value
	 * @param array $args
	 * @param bool $sr_only
	 */
	public static function renderField( $type = 'text', $label = '', $name = '', $value = '', $args = [], $sr_only = false, $info = '' ) {
		echo self::getField( $type, $label, $name, $value, $args, $sr_only, $info );
	}

	/**
	 * Builds a form field row
	 *
	 * @param string $type
	 * @param string $label
	 * @param string $name
	 * @param string $value
	 * @param array $args
	 * @param bool $sr_only_label
	 *
	 * @return string
	 */
	public static function getField( $type = 'text', $label = '', $name = '', $value = '', $args = [], $sr_only_label = false, $info = '' ) {
		if ( $label == '' ) {
			$label = self::createLabel( $name );
		}

		if ( ! isset( $args['class'] ) ) {
			$args['class'] = 'regular-text';
		}
		if ( ! isset( $args['id'] ) ) {
			$args['id'] = sanitize_key( str_replace( '[', '_', $name ) );
		}
		if ( ! isset( $args['name'] ) ) {
			$args['name'] = $name;
		}
		if ( ! isset( $args['value'] ) ) {
			$args['value'] = $value;
		}

		$description = '';
		if ( isset( $args['description'] ) && $type != 'message' ) {
			$description = self::buildDescription( $args['description'] );
			unset( $args['description'] );
		}

		// @TODO Use for $hidden?
		$hidden = isset( $args['data-condition-target'] );

		switch ( $type ) {
			case 'checkbox':
			case 'number':
			case 'text':
			case 'url':
			case 'radio':
				$args['type'] = $type;

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildInput( $args );

			case 'hidden':
				$args['type'] = $type;

				return self::buildInput( $args );

			case 'textarea':
				unset( $args['type'] );

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildTextarea( $args );

			case 'select':
				unset( $args['type'] );

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildSelect( $args );

			case 'multiselect':
				unset( $args['type'] );
				$args['multiple'] = 'multiple';

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildSelect( $args );

			case 'pageselect':
				unset( $args['type'] );

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildPageSelect( $args );

			case 'yesno':
				unset( $args['type'] );
				$args['choices'] = [
					'0' => _x( 'No', 'admin', 'wp-gdpr-compliance' ),
					'1' => _x( 'Yes', 'admin', 'wp-gdpr-compliance' )
				];
				$args['class']   = 'small-text';

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildSelect( $args );

			case 'enable':
				unset( $args['type'] );
				$args['choices'] = [
					'0' => _x( 'Disable', 'admin', 'wp-gdpr-compliance' ),
					'1' => _x( 'Enable', 'admin', 'wp-gdpr-compliance' )
				];
				$args['class']   = 'small-text';

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildSelect( $args );

			case 'colorpicker':
				$args['type']  = 'color';
				$args['class'] .= ' ' . Plugin::PREFIX . '-field__colorpicker';

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . $description . self::buildInput( $args );

			case 'truefalse':
				$args['type'] = 'checkbox';
				if ( empty( $args['label'] ) ) {
					$args['label'] = self::buildLabel( $args['id'], $label, $sr_only_label, $info );
				}

				if (!empty( $description )) {
				    if (isset($args['description']) && is_string($args['description'])) {
                        $args['description'] .= $description;
                    } else {
                        $args['description'] = $description;
                    }
                }

				return self::buildSwitch( $args );

			case 'message':
				if ( ! isset( $args['description'] ) ) {
					$args['description'] = '';
				}
				if ( ! isset( $args['message'] ) ) {
					$args['message'] = $args['description'];
				}

				return self::buildLabel( $args['id'], $label, $sr_only_label, $info ) . self::buildMessage( $args );

			default:
				if ( is_user_logged_in() ) {
					return Template::get( 'Admin/Form/field-todo' );
				}
		}

		return '';
	}

	/**
	 * Creates label (used when no label provided)
	 *
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected static function createLabel( $name = '' ) {
		return ucfirst( str_replace( [ '_', '-' ], ' ', $name ) );
	}

	/**
	 * Builds field label
	 *
	 * @param string $id
	 * @param string $text
	 * @param bool $sr_only
	 *
	 * @return string
	 */
	protected static function buildLabel( $id = '', $text = '', $sr_only = false, $info = '' ) {
		return Template::get( 'Admin/Form/label', [
			'id'      => $id,
			'text'    => $text,
			'sr_only' => $sr_only,
			'info'    => $info,
		] );
	}

	/**
	 * Builds field description
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	protected static function buildDescription( $text = '' ) {
		if ( empty( $text ) ) {
			return '';
		}

		return Template::get( 'Admin/Form/description', [
			'text' => $text,
		] );
	}

	/**
	 * Builds input field with attributes
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildInput( $args = [] ) {
		return Template::get( 'Admin/Form/field-input', [
			'id'    => $args['id'],
			'type'  => $args['type'],
			'name'  => $args['name'],
			'value' => $args['value'],
			'class' => $args['class'],
			'attr'  => self::buildAttributes( $args ),
		] );
	}

	/**
	 * Builds text message with attributes
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildMessage( $args = [] ) {
		$field = $args['message'];
		if ( ! isset( $args['value'] ) ) {
			return $field;
		}

		$args['type'] = 'hidden';
		unset( $args['description'] );
		unset( $args['message'] );

		return $field . self::buildInput( $args );
	}

	/**
	 * Builds select field with attributes
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildSelect( $args = [] ) {
		if ( ! isset( $args['choices'] ) ) {
			$args['choices'] = [];
		}

		$selected = '';
		if ( isset( $args['value'] ) ) {
			$selected = $args['value'];
			unset( $args['value'] );
		}

		if ( isset( $args['multiple'] ) && $args['multiple'] ) {
			$args['name'] .= '[]';
		}

		$field = '<select ';
		foreach ( $args as $key => $data ) {
			if ( $key == 'choices' ) {
				continue;
			}
			$field .= $key . '="' . $data . '" ';
		}

		$field = trim( $field ) . '>';
		foreach ( $args['choices'] as $current_value => $text ) {
			$field .= '<option value="' . $current_value . '" ' . self::isSelected( $selected, $current_value, false ) . '>' . $text . '</option>';
		}

		return $field . '</select>';
	}

	/**
	 * @param             $selected
	 * @param bool|string $current
	 * @param bool $echo
	 *
	 * @return string
	 */
	protected static function isSelected( $selected, $current = true, $echo = true ) {
		$result = '';
		if ( is_string( $selected ) ) {
			$result = selected( esc_attr( $selected ), esc_attr( $current ), false );

		} elseif ( is_array( $selected ) ) {
			if ( in_array( $current, $selected ) ) {
				$result = ' selected="selected"';
			}
		}

		if ( $echo ) {
			echo $result;
		}

		return $result;
	}

	/**
	 * Builds page select field with attributes
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildPageSelect( $args = [] ) {
		$class = explode( ' ', $args['class'] );
		foreach ( [ 'regular-text', 'page-selector' ] as $string ) {
			if ( ! in_array( $string, $class ) ) {
				$class[] = $string;
			}
		}

		return Template::get( 'Admin/Form/field-pageselect', [
			'id'    => $args['id'],
			'name'  => $args['name'],
			'value' => $args['value'],
			'class' => implode( ' ', $class ),
			'args'  => $args,
		] );
	}

	/**
	 * Builds textarea field with attributes
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildTextarea( $args = [] ) {
		return Template::get( 'Admin/Form/field-textarea', [
			'id'    => $args['id'],
			'name'  => $args['name'],
			'value' => $args['value'],
			'class' => $args['class'],
			'attr'  => self::buildAttributes( $args ),
		] );
	}

	/**
	 * Builds switch field
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildSwitch( $args = [] ) {
		return Template::get( 'Admin/Form/field-switch', [
			'id'    => $args['id'],
			'type'  => $args['type'],
			'name'  => $args['name'],
			'value' => $args['value'],
			'class' => $args['class'],
			'args'  => $args,
			'data'  => self::buildAttributes( array_filter( $args, function ( $attr ) {
				return strpos( $attr, 'data-' ) !== false;
			}, ARRAY_FILTER_USE_KEY ) ),
		] );
	}

	/**
	 * @param array $args
	 *
	 * @return string
	 */
	protected static function buildAttributes( $args = [] ) {
		$list = [];
		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) ) {
				continue;
			}
			if ( in_array( $key, [ 'type', 'name', 'value', 'class', 'id' ] ) ) {
				continue;
			}
			if ( in_array( $key, [ 'checked', 'selected' ] ) && ! boolval( $value ) ) {
				continue;
			}
			$list[] = $key . '="' . esc_attr( $value ) . '"';
		}

		return implode( ' ', $list );
	}

	/**
	 * Renders a form setting field
	 *
	 * @param string $type
	 * @param string $label
	 * @param string $key
	 * @param array $args
	 * @param bool $sr_only
	 */
	public static function renderSettingField( $type = 'text', $label = '', $key = '', $args = [], $sr_only = false, $group = Settings::SETTINGS_GROUP ) {
		echo self::getSettingField( $type, $label, $key, $args, $sr_only, $group );
	}

	/**
	 * Builds a form setting field
	 *
	 * @param string $type
	 * @param string $label
	 * @param string $key
	 * @param array $args
	 * @param bool $sr_only
	 *
	 * @return string
	 */
	public static function getSettingField( $type = 'text', $label = '', $key = '', $args = [], $sr_only = false, $group = Settings::SETTINGS_GROUP ) {
		return self::getField( $type, $label, Settings::getKey( $key, $group ), Settings::get( $key, $group ), $args, $sr_only );
	}

	/**
	 * Renders a form setting field (based on an array of data)
	 *
	 * @param array $data
	 */
	public static function renderSettingFieldFromArray( $data = [], $group = Settings::SETTINGS_GROUP ) {
		echo self::getSettingFieldFromArray( $data, $group );
	}

	/**
	 * Builds a form setting field (based on an array of data)
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	public static function getSettingFieldFromArray( $data = [], $group = Settings::SETTINGS_GROUP ) {
		$type    = isset( $data['type'] ) ? $data['type'] : 'text';
		$label   = isset( $data['label'] ) ? $data['label'] : '';
		$key     = isset( $data['key'] ) ? $data['key'] : '';
		$args    = isset( $data['args'] ) ? $data['args'] : [];
		$sr_only = ! empty( $data['sr_only'] );

		return self::getSettingField( $type, $label, $key, $args, $sr_only );
	}

	/**
	 * Renders submit button
	 *
	 * @param string $group
	 * @param string $section
	 */
	public static function renderSubmitButton( $section = '', $group = Settings::SETTINGS_GROUP ) {
		$name = $group . '[submit]';
		if ( ! empty( $section ) ) {
			$name .= '[' . $section . ']';
		}

		submit_button( _x( 'Save settings', 'admin', 'wp-gdpr-compliance' ), 'wpgdprc-button', $name, false, [ 'class' => 'wpgdprc-button' ] );
	}

}
