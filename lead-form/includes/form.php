<?php
	add_action('admin_init', 'lead_form_settings_init');

	function lead_form_settings_init(): void {
		register_setting(
			'lead_form_options',
			'lead_form_options',
			'lead_form_sanitize_options'
		);

		add_settings_section(
			'lead_form_main_section',
			'Основні налаштування',
			'lead_form_main_section_callback',
			'lead_form_settings_page'
		);

		add_settings_field(
			'lead_email',
			'Email для отримання лідів',
			'lead_email_callback',
			'lead_form_settings_page',
			'lead_form_main_section'
		);
	  add_settings_field(
		  'lead_form_title',
		  'Заголовок форми',
		  'lead_form_title_callback',
		  'lead_form_settings_page',
		  'lead_form_main_section'
	  );

	  add_settings_field(
		  'lead_form_disclaimer',
		  'Дисклеймер',
		  'lead_form_disclaimer_callback',
		  'lead_form_settings_page',
		  'lead_form_main_section'
	  );
	}

	function lead_form_sanitize_options($input): array {
		$sanitized_input = array();

		if (isset($input['lead_email'])) {
			$sanitized_input['lead_email'] = sanitize_email($input['lead_email']);
		}
	  if (isset($input['lead_form_title'])) {
		  $sanitized_input['lead_form_title'] = sanitize_text_field($input['lead_form_title']);
	  }

	  if (isset($input['lead_form_disclaimer'])) {
		  $sanitized_input['lead_form_disclaimer'] = wp_kses_post($input['lead_form_disclaimer']);
	  }

	  return $sanitized_input;
	}

	function lead_form_main_section_callback(): void {
		echo 'Загальні налаштування для форми отримання лідів.';
	}

	function lead_email_callback(): void {
		$options = get_option('lead_form_options');
		?>
			<input type="text" name="lead_form_options[lead_email]" value="<?php echo esc_attr($options['lead_email']); ?>" style="width: 100%">
		<?php
	}
	function lead_form_title_callback(): void {
		$options = get_option('lead_form_options');
		?>
			<input type="text" name="lead_form_options[lead_form_title]" value="<?php echo esc_attr($options['lead_form_title']); ?>" style="width: 100%">
		<?php
	}

	function lead_form_disclaimer_callback(): void {
		$options = get_option('lead_form_options');
		$disclaimer = $options['lead_form_disclaimer'] ?? '';

		wp_editor($disclaimer, 'lead_form_disclaimer', array('textarea_name' => 'lead_form_options[lead_form_disclaimer]'));
	}