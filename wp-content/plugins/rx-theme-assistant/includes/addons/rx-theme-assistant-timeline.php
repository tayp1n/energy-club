<?php
/**
 * Class: Rx_Theme_Assistant_Timeline
 * Name: Timeline
 * Slug: rx-theme-assistant-timeline
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Rx_Theme_Assistant_Timeline extends Rx_Theme_Assistant_Base {
	public $__processed_item_index = 0;

	public function get_name() {
		return 'rx-theme-assistant-timeline';
	}

	public function get_title() {
		return esc_html__( 'Timeline', 'rx-theme-assistant' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return array( 'rx-theme-assistant' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'rx-theme-assistant/timeline/css-scheme',
			array(
				'line'               => '.rx-theme-assistant-timeline__line',
				'progress'           => '.rx-theme-assistant-timeline__line-progress',
				'item'               => '.rx-theme-assistant-timeline-item',
				'item_point'         => '.timeline-item__point',
				'item_point_content' => '.timeline-item__point-content',
				'item_meta'          => '.timeline-item__meta-content',
				'card'               => '.timeline-item__card',
				'card_inner'         => '.timeline-item__card-inner',
				'card_img'           => '.timeline-item__card-img',
				'card_content'       => '.timeline-item__card-content',
				'card_title'         => '.timeline-item__card-title',
				'card_desc'          => '.timeline-item__card-desc',
				'card_arrow'         => '.timeline-item__card-arrow',
			)
		);

		$this->start_controls_section(
			'section_cards',
			array(
				'label' => esc_html__( 'Cards', 'rx-theme-assistant' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'show_item_image',
			array(
				'label'        => esc_html__( 'Show Image', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$repeater->add_control(
			'item_image',
			array(
				'label'     => esc_html__( 'Image', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'show_item_image' => 'yes'
				),
				'dynamic'  => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_title',
			array(
				'label'   => esc_html__( 'Title', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_meta',
			array(
				'label'   => esc_html__( 'Meta', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_desc',
			array(
				'label'   => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_member',
			array(
				'label'     => esc_html__( 'Speaker / Member', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$repeater->add_control(
			'item_show_member',
			array(
				'label'        => esc_html__( 'Show Speaker / Member', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'label_off',
			)
		);
		$repeater->add_control(
			'item_member_image',
			array(
				'label'     => esc_html__( 'Member Avatar', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'dynamic'  => array( 'active' => true ),
				'condition' => array(
					'item_show_member' => 'yes'
				),
			)
		);
		$repeater->add_control(
			'item_member_name',
			array(
				'label'   => esc_html__( 'Name', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
				'condition' => array(
					'item_show_member' => 'yes'
				),
			)
		);
		$repeater->add_control(
			'item_member_position',
			array(
				'label'   => esc_html__( 'Position', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
				'condition' => array(
					'item_show_member' => 'yes'
				),
			)
		);

		$repeater->add_control(
			'item_member_desc',
			array(
				'label'   => esc_html__( 'Description', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
				'condition' => array(
					'item_show_member' => 'yes'
				),
			)
		);

		$repeater->add_control(
			'item_point',
			array(
				'label'     => esc_html__( 'Point', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$repeater->add_control(
			'item_point_type',
			array(
				'label'   => esc_html__( 'Point Content Type', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => array(
					'icon' => esc_html__( 'Icon', 'rx-theme-assistant' ),
					'text' => esc_html__( 'Text', 'rx-theme-assistant' ),
				),
			)
		);

		$this->add_advanced_icon_control(
			'item_point_icon',
			[
				'label'       => esc_html__( 'Point Icon', 'rx-theme-assistant' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'file'        => '',
				'default'     => 'fa fa-calendar',
				'fa5_default' => [
					'value'   => 'fas fa-calendar',
					'library' => 'solid',
				],
				'condition'   => array(
					'item_point_type' => 'icon'
				)
			],
			$repeater
		);

		$repeater->add_control(
			'item_point_text',
			array(
				'label'     => esc_html__( 'Point Text', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'A',
				'condition' => array(
					'item_point_type' => 'text'
				)
			)
		);

		$repeater->add_control(
			'item_show_button',
			array(
				'label'        => esc_html__( 'Show Button', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'rx-theme-assistant' ),
				'label_off'    => esc_html__( 'No', 'rx-theme-assistant' ),
				'return_value' => 'yes',
				'default'      => 'label_off',
			)
		);

		$repeater->add_control(
			'item_button_text',
			array(
				'label'     => esc_html__( 'Button Text', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'rx-theme-assistant' ),
				'condition' => array(
					'item_show_button' => 'yes'
				)
			)
		);

		$repeater->add_control(
			'item_button_link',
			array(
				'label'     => esc_html__( 'Button Link', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '#',
				'condition' => array(
					'item_show_button' => 'yes'
				)
			)
		);

		$this->add_control(
			'cards_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_title'      => esc_html__( 'Card #1', 'rx-theme-assistant' ),
						'item_title_icon' => 'fa fa-birthday-cake',
						'item_desc'       => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'rx-theme-assistant' ),
						'item_point_icon' => 'fa fa-calendar',
						'item_meta'       => esc_html__( 'Thursday, August 31, 2018', 'rx-theme-assistant' ),
					),
					array(
						'item_title'      => esc_html__( 'Card #2', 'rx-theme-assistant' ),
						'item_title_icon' => 'fa fa-birthday-cake',
						'item_desc'       => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'rx-theme-assistant' ),
						'item_point_icon' => 'fa fa-calendar',
						'item_meta'       => esc_html__( 'Thursday, August 29, 2018', 'rx-theme-assistant' ),
					),
					array(
						'item_title'      => esc_html__( 'Card #3', 'rx-theme-assistant' ),
						'item_title_icon' => 'fa fa-birthday-cake',
						'item_desc'       => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'rx-theme-assistant' ),
						'item_point_icon' => 'fa fa-calendar',
						'item_meta'       => esc_html__( 'Thursday, August 28, 2018', 'rx-theme-assistant' ),
					),
					array(
						'item_title'      => esc_html__( 'Card #4', 'rx-theme-assistant' ),
						'item_title_icon' => 'fa fa-birthday-cake',
						'item_desc'       => esc_html__( 'Lorem ipsum dolor sit amet, mea ei viderer probatus consequuntur, sonet vocibus lobortis has ad. Eos erant indoctum an, dictas invidunt est ex, et sea consulatu torquatos. Nostro aperiam petentium eu nam, mel debet urbanitas ad, idque complectitur eu quo. An sea autem dolore dolores.', 'rx-theme-assistant' ),
						'item_point_icon' => 'fa fa-calendar',
						'item_meta'       => esc_html__( 'Thursday, August 27, 2018', 'rx-theme-assistant' ),
					),
				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'animate_cards',
			array(
				'label'        => esc_html__( 'Animate Cards', 'rx-theme-assistant' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'rx-theme-assistant-timeline-item--animated',
				'default'      => '',
			)
		);

		$this->add_control(
			'horizontal_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
			)
		);

		$this->add_control(
			'vertical_alignment',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'rx-theme-assistant' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'middle',
				'options' => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'rx-theme-assistant' ),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => esc_html__( 'Middle', 'rx-theme-assistant' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'rx-theme-assistant' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
			)
		);

		$this->add_responsive_control(
			'horizontal_space',
			array(
				'label'      => esc_html__( 'Horizontal Space', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item_point'] => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-left ' . $css_scheme['item_point']   => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-right ' . $css_scheme['item_point']  => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'vertical_space',
			array(
				'label'      => esc_html__( 'Vertical Space', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 150,
					),
				),
				'default'    => array(
					'size' => 30,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '+' . $css_scheme['item'] => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cards_style',
			array(
				'label'      => esc_html__( 'Cards', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_cards( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			array(
				'label'      => esc_html__( 'Image', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_image( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_meta_style',
			array(
				'label'      => esc_html__( 'Meta', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_meta( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_content_style',
			array(
				'label'      => esc_html__( 'Content', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_card_content( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_title_style',
			array(
				'label'      => esc_html__( 'Title', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_card_title( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_card_desc( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_member_style',
			array(
				'label'      => esc_html__( 'Speaker / Member', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'member_image_heading',
			[
				'label' => __( 'Image', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'member_image_width',
			[
				'label' => esc_html__( 'Width', 'rx-theme-assistant' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .timeline-item__member-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'member_image_max_width',
			[
				'label' => esc_html__( 'Max Width', 'rx-theme-assistant' ) . ' (%)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .timeline-item__member-image img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'member_image_align',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
				],
			]
		);

		$this->add_control(
			'member_name_heading',
			[
				'label' => __( 'Name', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'member_name_typography',
				'label'      => esc_html__( 'Typography', 'rx-theme-assistant' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .timeline-item__member-name',
			]
		);

		$this->add_control(
			'member_name_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .timeline-item__member-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'member_name_alignment',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .timeline-item__member-name' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'member_position_heading',
			[
				'label' => __( 'Position', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'member_position_typography',
				'label'      => esc_html__( 'Typography', 'rx-theme-assistant' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .timeline-item__member-position',
			]
		);

		$this->add_control(
			'member_position_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .timeline-item__member-position' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'member_position_alignment',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .timeline-item__member-position' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'member_desc_heading',
			[
				'label' => __( 'Description', 'plugin-name' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'member_desc_typography',
				'label'      => esc_html__( 'Typography', 'rx-theme-assistant' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .timeline-item__member-desc',
			]
		);

		$this->add_control(
			'member_desc_color',
			[
				'label' => esc_html__( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .timeline-item__member-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'member_desc_alignment',
			[
				'label' => esc_html__( 'Alignment', 'rx-theme-assistant' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'rx-theme-assistant' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .timeline-item__member-desc' => 'text-align: {{VALUE}};',
				],
			]
		);
		//$this->_control_section_card_desc( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Button', 'rx-theme-assistant' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'rx-theme-assistant' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'rx-theme-assistant' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'rx-theme-assistant' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'rx-theme-assistant' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_point_style',
			array(
				'label'      => esc_html__( 'Point', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_points( $css_scheme );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_line_style',
			array(
				'label'      => esc_html__( 'Line', 'rx-theme-assistant' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->_control_section_line( $css_scheme );

		$this->end_controls_section();
	}

	public function _control_section_cards( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'cards_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card'] . ',' . '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'],
			)
		);

		$this->add_responsive_control(
			'cards_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card']       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow:hidden;'
				),
			)
		);

		$this->add_responsive_control(
			'cards_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after'
			)
		);

		$this->start_controls_tabs( 'cards_style_tabs' );

		$this->start_controls_tab(
			'cards_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'cards_background_normal',
			array(
				'label'     => esc_html__( 'Background', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card']       => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_inner'] => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cards_box_shadow_normal',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cards_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'cards_background_hover',
			array(
				'label'     => esc_html__( 'Background', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card']       => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_inner'] => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_arrow'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cards_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card']       => 'border-color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_arrow'] => 'border-color: {{VALUE}};'
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cards_box_shadow_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cards_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'cards_background_active',
			array(
				'label'     => esc_html__( 'Background', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card']       => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_inner'] => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_arrow'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'cards_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card']       => 'border-color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_arrow'] => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cards_box_shadow_active',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cards_arrow_heading',
			array(
				'label'     => esc_html__( 'Arrow', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'cards_arrow_width',
			array(
				'label'      => esc_html__( 'Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'size' => 20,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'] => 'width:{{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(odd) ' . $css_scheme['card_arrow'] => 'margin-left:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(even) ' . $css_scheme['card_arrow'] => 'margin-left:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'(desktop){{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(odd) ' . $css_scheme['card_arrow'] => 'margin-right:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'(desktop){{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(even) ' . $css_scheme['card_arrow'] => 'margin-left:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'(desktop) .rtl {{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(odd) ' . $css_scheme['card_arrow'] => 'margin-left:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'(desktop) .rtl {{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['item'] . ':nth-child(even) ' . $css_scheme['card_arrow'] => 'margin-right:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-left ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'] => 'margin-left:calc( -{{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-right ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'] => 'margin-right:calc( -{{SIZE}}{{UNIT}} / 2 );',
				),
			)
		);

	}

	public function _control_section_image( $css_scheme ) {

		$this->add_responsive_control(
			'image_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_img'] => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_img'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

	}

	public function _control_section_meta( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'meta_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'],
			)
		);

		$this->add_control(
			'meta_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_responsive_control(
			'meta_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after'
			)
		);

		$this->start_controls_tabs( 'meta_style_tabs' );

		$this->start_controls_tab(
			'meta_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'meta_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_normal_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'meta_normal_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['item_meta'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'meta_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'meta_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_meta'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_meta'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_meta'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'meta_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_meta'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'meta_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'meta_active_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_meta'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_active_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_meta'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'meta_active_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_meta'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'meta_active_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_meta'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	public function _control_section_card_content( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'card_content_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_content'],
			)
		);

		$this->add_control(
			'card_content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_content'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow:hidden;',
				),
			)
		);

		$this->add_responsive_control(
			'card_content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after'
			)
		);

		$this->start_controls_tabs( 'card_content_style_tabs' );

		$this->start_controls_tab(
			'card_content_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_content_normal_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_content_normal_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_content'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_content_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_content_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_content_hover_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_content'],
			)
		);

		$this->add_control(
			'card_content_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_content'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_content_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_content_active_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_content_active_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_content'],
			)
		);

		$this->add_control(
			'card_content_active_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_content'] => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'card_arrow_heading',
			array(
				'label'     => esc_html__( 'Card Arrow', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'vertical_alignment!' => 'middle'
				)
			)
		);

		$this->add_responsive_control(
			'card_arrow_offset',
			array(
				'label'      => esc_html__( 'Card Arrow Offset', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
					'%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
					'%'  => array(
						'min' => 0,
						'max' => 80,
					),
				),
				'default'    => array(
					'size' => 12,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-top ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow']    => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-bottom ' . $css_scheme['item'] . ' ' . $css_scheme['card_arrow'] => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'vertical_alignment!' => 'middle'
				)
			)
		);
	}

	public function _control_section_card_title( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_title'],
			)
		);

		$this->add_responsive_control(
			'card_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after'
			)
		);

		$this->start_controls_tabs( 'card_title_style_tabs' );

		$this->start_controls_tab(
			'card_title_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_title_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_title_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_title_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_title_active_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	public function _control_section_card_desc( $css_scheme ) {

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_desc_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_desc'],
			)
		);

		$this->add_responsive_control(
			'card_desc_margin',
			array(
				'label'      => esc_html__( 'Margin', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'after'
			)
		);

		$this->start_controls_tabs( 'card_desc_style_tabs' );

		$this->start_controls_tab(
			'card_desc_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_desc_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['card_desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_desc_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_desc_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['card_desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'card_desc_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'card_desc_active_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['card_desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	public function _control_section_points( $css_scheme ) {

		$this->start_controls_tabs( 'point_type_style_tabs' );

		$this->start_controls_tab(
			'point_type_text_styles',
			array(
				'label' => esc_html__( 'Text', 'rx-theme-assistant' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'point_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_point_content'] . '.timeline-item__point-content--text',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'point_type_icon_styles',
			array(
				'label' => esc_html__( 'Icon', 'rx-theme-assistant' ),
			)
		);

		$this->add_responsive_control(
			'point_type_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 16,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_point_content'] . '.timeline-item__point-content--icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'point_size',
			array(
				'label'      => esc_html__( 'Point Size', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default'    => array(
					'size' => 40,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_point_content']               => 'height:{{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-center ' . $css_scheme['line'] => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-left ' . $css_scheme['line']   => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 );',
					'{{WRAPPER}} .rx-theme-assistant-timeline--align-right ' . $css_scheme['line']   => 'margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'point_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['item_point_content'],
			)
		);

		$this->add_control(
			'point_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['item_point_content'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'point_style_tabs' );

		$this->start_controls_tab(
			'point_normal_styles',
			array(
				'label' => esc_html__( 'Normal', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'point_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item_point_content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'point_normal_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item_point_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'point_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'point_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_point_content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'point_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_point_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'point_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['item_point_content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'point_active_styles',
			array(
				'label' => esc_html__( 'Active', 'rx-theme-assistant' ),
			)
		);

		$this->add_control(
			'point_active_color',
			array(
				'label'     => esc_html__( 'Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_point_content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'point_active_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_point_content'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'point_active_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['item'] . '.is--active ' . $css_scheme['item_point_content'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	}

	public function _control_section_line( $css_scheme ) {

		$this->add_control(
			'line_background_color',
			array(
				'label'     => esc_html__( 'Line Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['line'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'progress_background_color',
			array(
				'label'     => esc_html__( 'Progress Color', 'rx-theme-assistant' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['progress'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'line_width',
			array(
				'label'      => esc_html__( 'Thickness', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 15,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['line'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'line_border',
				'label'       => esc_html__( 'Border', 'rx-theme-assistant' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['line'],
			)
		);

		$this->add_control(
			'line_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'rx-theme-assistant' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['line'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

	}

	public function _generate_point_content( $item_settings ) {
		echo '<div class="timeline-item__point">';
		switch ( $item_settings['item_point_type'] ) {
			case 'icon':
				echo $this->__get_icon( 'item_point_icon', '<div class="timeline-item__point-content timeline-item__point-content--icon">%s</div>' );
				break;
			case 'text':
				echo $this->__loop_item( array( 'item_point_text' ), '<div class="timeline-item__point-content timeline-item__point-content--text">%s</div>' );
				break;
		}
		echo '</div>';
	}

	public function _generate_item_button( $item_settings ) {
		if( 'yes' === $item_settings['item_show_button'] && $item_settings['item_button_text'] && $item_settings['item_button_link'] ) {
			$format = apply_filters( 'rx-theme-assistant/timeline/button-html', '<div class="timeline-item__button-wrap"><a href="%s" class="btn btn-primary elementor-button elementor-size-md timeline-item__button %s"><span class="btn__text">%s</span></a></div>' );
			$hover_animation = empty( $item_settings['hover_animation'] ) ? '' : 'elementor-animation-' . $item_settings['hover_animation'] ;

			return sprintf( $format, $item_settings['item_button_link'], $hover_animation, $item_settings['item_button_text'] );
		}
	}

	public function get_item_inline_editing_attributes( $settings_item_key, $repeater_item_key, $index, $classes ) {
		$item_key = $this->get_repeater_setting_key( $settings_item_key, $repeater_item_key, $index );
		$this->add_render_attribute( $item_key, [ 'class' => $classes ] );
		$this->add_inline_editing_attributes( $item_key, 'basic' );

		return $this->get_render_attribute_string( $item_key );
	}

	protected function render() {
		$this->__context = 'render';

		$this->__open_wrap();
		include $this->__get_global_template( 'index' );
		$this->__close_wrap();

		$this->__processed_item_index = 0;
	}

}
