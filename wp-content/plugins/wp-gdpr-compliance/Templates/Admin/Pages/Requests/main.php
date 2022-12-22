<?php

use WPGDPRC\Objects\RequestAccess;
use WPGDPRC\Objects\RequestDelete;
use WPGDPRC\Utils\Template;
use WPGDPRC\WordPress\Admin\Pages\PageRequests;
use WPGDPRC\WordPress\Plugin;

/**
 * @var string $admin_url
 */

$list = [
    RequestAccess::STATUS_ACTIVE  => [
        'title' => _x('Active requests', 'admin', 'wp-gdpr-compliance'),
        'empty' => _x('No active requests to manage.', 'admin', 'wp-gdpr-compliance'),
        'data'  => RequestAccess::getActiveList(),
    ],
    RequestAccess::STATUS_EXPIRED => [
        'title' => _x('Expired requests', 'admin', 'wp-gdpr-compliance'),
        'empty' => _x('No expired requests here.', 'admin', 'wp-gdpr-compliance'),
        'data'  => RequestAccess::getExpiredList(),
    ],
];

?>

<article class="wpgdprc-container">
	<div class="wpgdprc-content">
		<header class="wpgdprc-content__header">
			<h2 class="wpgdprc-content__title">
                <?php _ex('Requests', 'admin', 'wp-gdpr-compliance'); ?>
			</h2>
			<p class="wpgdprc-content__text">
                <?php _ex("Here are the requests that are done via the request form. Requests are anonymized automatically after 30 days when no action is taken.", 'admin', 'wp-gdpr-compliance'); ?>
			</p>
		</header>

		<div class="wpgdprc-content__container">
			<section class="wpgdprc-tabs wpgdprc-tabs--requests" data-tabs>
				<div class="wpgdprc-tabs__header">
					<div class="wpgdprc-tabs__title-container">
						<h3 class="wpgdprc-tabs__title h3">
                            <?php _ex('Active requests', 'admin', 'wp-gdpr-compliance'); ?>
						</h3>
					</div>
					<ul class="wpgdprc-tabs__list" role="tablist">
                        <?php foreach( $list as $key => $data ) :
                            $selected = empty($selected) ? 'true' : 'false';
                            ?>
							<li class="wpgdprc-tabs__item" role="presentation">
								<a class="wpgdprc-tabs__anchor" data-title="<?php echo esc_attr($data['title']); ?>"
								   href="#<?php echo $key; ?>-requests" id="tab-<?php echo $key; ?>-requests" role="tab"
								   aria-controls="<?php echo $key; ?>-requests" aria-selected="<?php echo $selected ?>"
								   tabindex="0">
                                    <?php echo $data['title']; ?>
								</a>
							</li>
                        <?php endforeach; ?>
					</ul>
				</div>

				<div class="wpgdprc-tabs__container">
                    <?php foreach( $list as $key => $data ) :
                        $hidden = empty($hidden) ? 'false' : 'true';
                        ?>
						<div class="wpgdprc-tabs__block wpgdprc-tabs__block--<?php echo $key; ?>"
							 id="<?php echo $key; ?>-requests"
							 role="tabpanel"
							 aria-labelledby="tab-<?php echo $key; ?>-requests"
							 aria-hidden="<?php echo esc_attr($hidden) ?>"
						>
                            <?php if( empty($data['data']) ) : ?>
								<p><?php echo $data['empty']; ?></p>
                            <?php else : ?>
                                <?php foreach( $data['data'] as $id => $object ) : ?>
                                    <?php $requests = RequestDelete::getCountByAccessId($object->getId(), false); ?>
                                    <?php /** @var RequestAccess $object */ ?>
									<div class="wpgdprc-banner-item wpgdprc-banner-item--request">
										<div class="wpgdprc-banner-item__inner">
											<div class="wpgdprc-banner-item__header">
												<p class="wpgdprc-banner-item__title h6"><?php echo $object->getEmailAddress(); ?></p>
											</div>
											<div class="wpgdprc-banner-item__container">
												<div class="wpgdprc-banner-item__content wpgdprc-banner-item__content--default"
													 aria-hidden="false">
													<div class="wpgdprc-banner-item__content-wrap">
														<ul class="wpgdprc-banner-item__list">
															<li class="wpgdprc-banner-item__item">
																<span><?php _ex('Date of request', 'admin', 'wp-gdpr-compliance'); ?></span>
                                                                <?php echo $object->getDateCreated(); ?>
															</li>
															<li class="wpgdprc-banner-item__item">
																<span><?php _ex('IP Address', 'admin', 'wp-gdpr-compliance'); ?></span>
                                                                <?php echo $object->getIpAddress(); ?>
															</li>
															<li class="wpgdprc-banner-item__item">
																<span><?php _ex('Requests', 'admin', 'wp-gdpr-compliance'); ?></span>
                                                                <?php printf('%d', $requests); ?>
															</li>
														</ul>
													</div>
													<div class="wpgdprc-banner-item__actions-wrap">
														<ul class="wpgdprc-banner-item__actions">
															<?php if( $key == RequestAccess::STATUS_ACTIVE ) : ?>
															<li>
																<a href="<?php echo PageRequests::getEditUrl($object->getId()); ?>"
																   class="wpgdprc-button wpgdprc-button--white wpgdprc-button--small">
                                                                    <?php _ex('Manage', 'admin', 'wp-gdpr-compliance'); ?>
																</a>
															</li>
															<?php endif; ?>
															<li>
																<button class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--delete wpgdprc-button--small"
																		data-delete>
                                                                    <?php _ex('Delete', 'admin', 'wp-gdpr-compliance'); ?>
																</button>
															</li>
														</ul>
													</div>
												</div>

												<div class="wpgdprc-banner-item__content wpgdprc-banner-item__content--manage"
													 aria-hidden="true">
                                                    <?php // TODO: Make a RequestAccess manage feature + handling with JS ?? ?>
													<p class="wpgdprc-banner-item__text"><?php echo '@TODO'; ?></p>
												</div>

												<div class="wpgdprc-banner-item__content wpgdprc-banner-item__content--delete"
													 aria-hidden="true">
													<p class="wpgdprc-banner-item__text"><?php _ex('Are you sure you want to delete this request?', 'admin', 'wp-gdpr-compliance'); ?></p>
													<ul class="wpgdprc-banner-item__actions">
														<li>
															<a href="<?php echo PageRequests::getDeleteUrl($object->getId()); ?>"
															   class="wpgdprc-button wpgdprc-button--white-alert wpgdprc-button--small">
                                                                <?php _ex('Yes', 'admin', 'wp-gdpr-compliance'); ?>
															</a>
														</li>
														<li>
															<button class="wpgdprc-button wpgdprc-button--transparent wpgdprc-button--white wpgdprc-button--small"
																	data-cancel>
                                                                <?php _ex('Cancel', 'admin', 'wp-gdpr-compliance'); ?>
															</button>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
                                <?php endforeach; ?>
                            <?php endif; ?>
						</div>
                    <?php endforeach; ?>
				</div>
			</section>
		</div>
	</div>
</article>
