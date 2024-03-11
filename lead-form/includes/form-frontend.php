<?php
	$options = get_option('lead_form_options');
	$lead_form_title = $options['lead_form_title'] ?? '';
	$lead_form_disclaimer = $options['lead_form_disclaimer'] ?? '';
?>
<div class="lead-form-wrapper">
	<h3 class="lead-form__heading"><?php echo esc_attr($lead_form_title); ?></h3>
	<form id="lead-form" class="lead-form" data-plugin-url="<?php echo plugins_url(); ?>">
		<div class="lead-form__group">
			<label for="lead-form-name" class="lead-form__label">Ваше ім’я:</label>
			<input type="text" id="lead-form-name" name="name" class="lead-form__input" required  placeholder="Вкажіть Ваше ім’я">
			<span id="name-error" class="lead-form__error-message"></span>
		</div>
		<div class="lead-form__group">
			<label for="lead-form-phone" class="lead-form__label">Ваш телефон:</label>
			<input type="tel" id="lead-form-phone" name="phone" class="lead-form__input" required >
			<span id="phoneError" class="lead-form__error-message"></span>
		</div>
		<div class="lead-form__group">
			<label for="lead-form-email" class="lead-form__label">Ваш e-mail:</label>
			<input type="email" id="lead-form-email" name="email" class="lead-form__input" placeholder="email@gmail.com">
			<span id="emailError" class="lead-form__error-message"></span>
		</div>
		<div class="lead-form__group">
			<label for="lead-form-description" class="lead-form__label">
				<textarea id="lead-form-description" name="description" class="lead-form__textarea" rows="7" placeholder="Коротко опишіть проблему, яку хочете вирішити"></textarea>
			</label>
		</div>
		<button type="button" id="submitBtn" class="lead-form__submit"><span id="submit-text" class="lead-form__submit-text">Надіслати</span><span class="lead-form__submit-spinner" id="spinner"></span></button>
	</form>
	<div class="lead-form__agreement">
	  <?php echo htmlspecialchars_decode($lead_form_disclaimer); ?>
	</div>
</div>

<div id="modal" class="modal">
	<div class="modal-content">
		<button class="modal-content__close" id="close-modal" >Закрити&nbsp;<span class="modal-content__close-cross">&times;</span></button>
		<div class="modal-content__body">
			<figure class="modal-content__figure"><img src="<?php echo plugins_url() . '/lead-form/assets/img/spaceship.png'; ?>" alt="spaceship" class="modal-content__img"></figure>
			<div class="modal-content__message-container">
				<p class="modal-content__message">Ваш запит надіслано</p>
				<p class="modal-content__heading">Дякуємо,<br>що довіряєте!</p>
			</div>
			<div class="modal-content__error-container">
				<p class="modal-content__message">Щось пішло не так :(</p>
				<p class="modal-content__heading">Перезавантажте сторінку,<br>та спробуйте ще раз.</p>
			</div>
		</div>
	</div>
</div>
