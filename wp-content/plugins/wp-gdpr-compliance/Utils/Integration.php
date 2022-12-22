<?php

namespace WPGDPRC\Utils;

use WPGDPRC\Integrations\AbstractIntegration;
use WPGDPRC\Integrations\Plugins\AbstractPlugin;
use WPGDPRC\Integrations\Plugins\ContactForm;
use WPGDPRC\Integrations\Plugins\GravityForms;
use WPGDPRC\Integrations\Plugins\WooCommerce;
use WPGDPRC\Integrations\WPComments;
use WPGDPRC\Integrations\WPRegistration;
use WPGDPRC\WordPress\Admin\Pages\PageSettings;
use WPGDPRC\WordPress\Config;
use WPGDPRC\WordPress\Settings;

/**
 * Class Integrations
 * @package WPGDPRC\Utils
 */
class Integration {

	const KEY_ACTIVE = 'active';
	const KEY_FORMS = 'forms';
	const KEY_TEXT = 'text';
	const KEY_ERROR = 'error_message';
	const KEY_REQUIRED = 'required_message';

	/**
	 *
	 */
	public static function init() {
		self::getList();
	}

	/**
	 * @return int
	 */
	public static function getValidFormCount(): int {
		$allFormsPerIntegration = array_map( function ( $integration ) {
			if ( ! $integration->isValid() ) {
				return 0;
			}

			if ( $integration->hasForms() ) {
				return count( $integration->getList() );
			}

			return 1;
		}, self::getList() );

		return array_sum( $allFormsPerIntegration );
	}

	/**
	 * @return int
	 */
	public static function getActiveFormCount(): int {
		$enabledFormsPerIntegration = array_map( function ( $integration ) {
			if ( $integration->hasForms() ) {
				return count( $integration->getEnabledForms() );
			}

			return (int) $integration->isEnabled();
		}, self::getList() );

		return array_sum( $enabledFormsPerIntegration );
	}

	/**
	 * @return array
	 */
	public static function defaultTexts(): array {
		return [
			self::KEY_TEXT     => Config::consentText(),
			self::KEY_ERROR    => __( 'Please accept the privacy policy', 'wp-gdpr-compliance' ),
			self::KEY_REQUIRED => __( 'You need to accept this checkbox', 'wp-gdpr-compliance' ),
		];
	}

	/**
	 * @param string $type
	 *
	 * @return string
	 */
	public static function getDefaultText( string $type = self::KEY_TEXT ): string {
		$list = self::defaultTexts();

		return $list[ $type ] ?? '';
	}

	/**
	 * Lists supported WordPress features
	 * @return array
	 */
	public static function supportedWP(): array {
		return [
			WPRegistration::getInstance()->getId() => WPRegistration::getInstance(),
			WPComments::getInstance()->getId()     => WPComments::getInstance(),
		];
	}

	/**
	 * Lists supported plugins
	 * @return array
	 */
	public static function supportedPlugins(): array {
		return [
			ContactForm::getInstance()->getId()  => ContactForm::getInstance(),
			GravityForms::getInstance()->getId() => GravityForms::getInstance(),
			WooCommerce::getInstance()->getId()  => WooCommerce::getInstance(),
		];
	}

	/**
	 * Lists all supported features/plugins
	 * @return array[AbstractIntegration|AbstractPlugin]
	 */
	public static function getList(): array {
		return self::supportedWP() + self::supportedPlugins();
	}

	/**
	 * Lists all supported feature/plugin labels
	 * @return array
	 */
	public static function getLabels(): array {
		$list = [];
		foreach ( self::getList() as $item ) {
			$list[] = $item->getName();
		}

		return $list;
	}

	public static function handleForm() {
		if ( empty( $_POST ) ) {
			return;
		}
		if ( empty( $_POST['section'] ) ) {
			return;
		}
		if ( sanitize_key( $_POST['section'] ) != PageSettings::SECTION_INTEGRATE ) {
			return;
		}

		$settings = [];
		$group    = Settings::INTEGRATIONS_GROUP;
		foreach ( Integration::getList() as $type => $integration ) {
			/**
			 * @var $integration AbstractPlugin | AbstractIntegration
			 */
			$option   = Settings::getKey( $type, $group );
			$defaults = Integration::getDefaultText();

			$settings[ $type ] = ! empty( $_POST[ $option ] ) ? 1 : 0;
			if ( ! empty( $integration->getSelectForm() ) ) {
				$result = [];
				if ( isset( $_POST[ $option . '_' . static::KEY_FORMS ] ) ) {
					foreach ( $_POST[ $option . '_' . static::KEY_FORMS ] as $id => $set ) {
						if ( $set ) {
							$result[] = $id;
						}
					}
				}
				$settings[ $type . '_' . static::KEY_FORMS ] = $result;
			}

			foreach ( $defaults as $key => $value ) {
				if ( empty( $integration->getSelectForm() ) ) {
					$settings[ $type . '_' . $key ] = isset( $_POST[ $option . '_' . $key ] ) ? sanitize_text_field( $_POST[ $option . '_' . $key ] ) : $value;
				} else {
					$settings[ $type . '_' . $key ] = isset( $_POST[ $option . '_' . $key ] ) ? Helper::sanitizeStringArray( $_POST[ $option . '_' . $key ] ) : [ $value ];
				}
			}

			// check activation/disabling of integration
			if ( ! empty( $_POST[ $group ] ) ) {
				foreach ( $_POST[ $group ] as $key => $integration ) {
					$settings[ key( $integration ) ] = $key == 'disable' ? '0' : '1';
				}
			}

			foreach ( $settings as $key => $value ) {
				Settings::saveSetting( $key, $value, $group );
			}
		}
	}

}
