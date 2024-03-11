<?php
	header('Content-Type: text/html; charset=utf-8');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


	function validateForm($name, $email, $phone) {
		$errors = array();

		if (empty($name)) {
			$errors['name'] = 'Поле "Ім\'я" є обов\'язковим';
		} elseif (!preg_match('/^[A-Za-zА-Яа-яЁё]+(\s[A-Za-zА-Яа-яЁё]+)?$/', $name)) {
			$errors['name'] = 'Ім\'я повинно містити лише букви та один пробіл між словами, без початкового пробілу';
		}

		if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Некоректний формат електронної пошти';
		}
		if (empty($phone)) {
			$errors['phone'] = 'Поле "Номер телефону" є обов\'язковим';
		} elseif (!preg_match('/^\+?[0-9]+$/', $phone)) {
			$errors['phone'] = 'Номер телефону повинен містити лише цифри';
		}

		return $errors;
	}

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$description = $_POST["description"];
		$raw_emails = $_POST['lead_form_options']['lead_email'];
		$email_array = explode(' ', $raw_emails);

		$validationErrors = validateForm($name, $email, $phone);

		if (empty($validationErrors)) {
			echo json_encode(array("success" => true));

			function sendLead($name, $emails, $phone, $description) {
				$to = "admin@example.com";
				$subject = "New Lead";

				foreach ($emails as $email) {
					$email = trim($email);
					if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$message = "Name: $name\nEmail: $email\nPhone: $phone\nDescription: $description";
						mail($email, $subject, $message);
						$post_data = array(
							'post_title' => $name . ' ' . $phone . ' ' . $email,
							'post_type' => 'lead',
							'post_content' => $description,
							'post_status' =>'publish'
						);
						wp_insert_post($post_data);
					} else {
						// Обробити помилку, якщо імейл не валідний
					}
				}

			}
			sendLead($name, $email_array, $phone, $description);
		} else {
			$response = array("status" => "error", "errors" => $validationErrors);
			echo json_encode($response);
		}
	}
