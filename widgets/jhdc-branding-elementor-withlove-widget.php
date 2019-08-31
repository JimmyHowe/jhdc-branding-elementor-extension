<?php

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;

if ( ! defined('ABSPATH') )
{
	exit; // Exit if accessed directly.
}

class JHDC_Elementor_WithLove_Widget extends Widget_Base
{

	/**
	 * Get widget name.
	 * Retrieve Branding widget name.
	 *
	 * @return string Widget name.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_name()
	{
		return 'jhdc-branding-withlove';
	}

	/**
	 * Get widget title.
	 * Retrieve oEmbed widget title.
	 *
	 * @return string Widget title.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_title()
	{
		return __('With Love', 'jhdc-branding-elementor-extension');
	}

	/**
	 * Get widget icon.
	 * Retrieve oEmbed widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_icon()
	{
		return 'fa fa-heart';
	}

	/**
	 * Get widget categories.
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @return array Widget categories.
	 * @since  1.0.0
	 * @access public
	 */
	public function get_categories()
	{
		return [ 'jhdc-elementor-widgets' ];
	}

	/**
	 * Register oEmbed widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _register_controls()
	{
		$this->start_controls_section('brand_colors', [
			'label' => __('Colors', 'jhdc-branding-elementor-extension'),
			'tab'   => Controls_Manager::TAB_STYLE,
		]);

		$this->add_control('color', [
			'label'     => __('Color', 'jhdc-branding-elementor-extension'),
			'type'      => Controls_Manager::COLOR,
			'default'   => '#ababab',
			//'scheme'    => [
			//	'type'  => Scheme_Color::get_type(),
			//	'value' => Scheme_Color::COLOR_1,
			//],
			'selectors' => [
				'{{WRAPPER}} a' => 'color: {{VALUE}}',
			],
		]);

		$this->end_controls_section();
	}

	/**
	 * Render oEmbed widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		echo '<div class="jhdc-branding-withlove">';

		//$url   = $settings["url"];
		$url   = "https://jimmyhowe.com";
		$color = $settings["color"];

		echo "<a href='{$url}'
				 style='color: {$color}'
 				 target='_blank'>Made with ❤ by JimmyHowe.com</a>";

		echo '</div>';
	}

	protected function _content_template()
	{
		?>
        <div class="jhdc-branding-withlove">

            <a href='{{{ settings.url }}}'
               style='{{{ settings.color }}}'
               target='_blank'>Made with ❤ by JimmyHowe.com</a>

        </div>
		<?php
	}
}
