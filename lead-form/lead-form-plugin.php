<?php
	/*
		Plugin Name: Lead Form Plugin
		Description: Додавання форми для введення даних.
		Version: 1.0
		Author: Me
		*/
	add_action('template_redirect', 'include_wp_load');

	function include_wp_load() {
		// Підключення wp-load.php
		include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	}

	include plugin_dir_path(__FILE__) . 'includes/form.php';

	add_action('admin_menu', 'lead_form_plugin_menu');
	function enqueue_lead_form_scripts(): void {
		wp_enqueue_style('lead-form-styles', plugins_url('assets/css/style.css', __FILE__));
		wp_enqueue_script('lead-form-scripts', plugins_url('assets/js/script.js', __FILE__), null, null, true);
	}

	add_action('wp_enqueue_scripts', 'enqueue_lead_form_scripts');

	function register_lead_post_type(): void {
		$labels = array(
			'name'               => 'Ліди',
			'singular_name'      => 'Лід',
			'menu_name'          => 'Ліди',
			'add_new'            => 'Додати новий',
			'add_new_item'       => 'Додати новий лід',
			'edit_item'          => 'Редагувати лід',
			'new_item'           => 'Новий лід',
			'view_item'          => 'Переглянути лід',
			'search_items'       => 'Пошук лідів',
			'not_found'          => 'Ліди не знайдено',
			'not_found_in_trash' => 'В кошику лідів не знайдено',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor' ),
			'has_archive'        => false,
			'menu_position'      => 20,
		);

		register_post_type( 'lead', $args );
	}

	add_action( 'init', 'register_lead_post_type' );

	function lead_form_plugin_menu(): void {
		add_menu_page(
			'Lead Form Settings',
			'Lead Form Settings',
			'manage_options',
			'lead-form-settings',
			'lead_form_settings_page'
		);
	}

	function lead_form_settings_page(): void {
		?>
		<div class="wrap">
			<h1>Lead Form Settings</h1>
			<form method="post" action="options.php">
				<?php settings_fields('lead_form_options'); ?>
				<?php do_settings_sections('lead_form_settings_page'); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}