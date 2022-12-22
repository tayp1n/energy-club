<?php

use WPGDPRC\Objects\DataProcessor;
use WPGDPRC\Utils\Elements;
use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Admin\Pages\PageDashboard;
use WPGDPRC\WordPress\Plugin;

/**
 * @var DataProcessor $object
 */

if ( ! isset( $object ) ) {
	return;
}

$stamp = strtotime( $object->getDateModified() );
$date  = date( 'Y-m-d', $stamp );

if ( $stamp < 0 ) {
	$date = _x( 'never', 'admin', 'wp-gdpr-compliance' );
}

?>
<div class="wpgdprc-banner-item wpgdprc-banner-item--processor">
    <div class="wpgdprc-banner-item__inner">
        <div class="wpgdprc-banner-item__header">
            <p class="wpgdprc-banner-item__title h6"><?php echo $object->getTitle(); ?></p>
            <span class="wpgdprc-banner-item__edited"><?php printf( _x( '(Last edited on %1s)', 'admin', 'wp-gdpr-compliance' ), $date ); ?></span>
        </div>
        <div class="wpgdprc-banner-item__container">
            <div class="wpgdprc-banner-item__content wpgdprc-banner-item__content--default" aria-hidden="false">
                <p class="wpgdprc-banner-item__label">
					<?php Template::render( 'Admin/Pages/Processors/item-required', [
						'required' => boolval( $object->getRequired() ),
					] ); ?>
                </p>
                <ul class="wpgdprc-banner-item__actions">
                    <li>
						<?php Elements::link(
							add_query_arg( [ 'edit' => $object->getId() ], PageDashboard::getTabUrl( PageDashboard::TAB_PROCESSORS ) ),
							_x( 'Edit', 'admin', 'wp-gdpr-compliance' ),
							[ 'class' => 'wpgdprc-button wpgdprc-button--white wpgdprc-button--small', ]
						); ?>
                    </li>
                    <li>
                        <button class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--delete wpgdprc-button--small"
                                data-delete><?php _ex( 'Delete', 'admin', 'wp-gdpr-compliance' ); ?></button>
                    </li>
                </ul>
            </div>
            <div class="wpgdprc-banner-item__content wpgdprc-banner-item__content--delete" aria-hidden="true">
                <p class="wpgdprc-banner-item__text"><?php _ex( 'Are you sure you want to delete this processor?', 'admin', 'wp-gdpr-compliance' ); ?></p>
                <ul class="wpgdprc-banner-item__actions">
                    <li>
						<?php Elements::link(
							add_query_arg( [ 'delete' => $object->getId() ], PageDashboard::getTabUrl( PageDashboard::TAB_PROCESSORS ) ),
							_x( 'Yes', 'admin', 'wp-gdpr-compliance' ),
							[ 'class' => 'wpgdprc-button wpgdprc-button--white-alert wpgdprc-button--small', ]
						); ?>
                    </li>
                    <li>
                        <button class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--white wpgdprc-button--small"
                                data-cancel><?php _ex( 'Cancel', 'admin', 'wp-gdpr-compliance' ); ?></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
