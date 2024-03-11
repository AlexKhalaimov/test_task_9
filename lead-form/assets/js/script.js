document.addEventListener("DOMContentLoaded", function(event) {
  const form = document.getElementById('lead-form')
  const closeModalBtn = document.getElementById('close-modal')
  const nameInput = document.getElementById("lead-form-name")
  const emailInput = document.getElementById("lead-form-email")
  const phoneInput = document.getElementById("lead-form-phone")
  const button = document.getElementById("submitBtn")

  button.addEventListener("click", function () {
    if (isFormValid()) {
      const formData = new FormData(form)
      showSpinner()
      setTimeout(function () {
        sendAjax(formData)

      }, 2000);
    }
  })
  if (closeModalBtn) {
    closeModalBtn.addEventListener('click', closeModal)
  }
  nameInput.addEventListener("input", function () {
    validateName(nameInput)
  })
  emailInput.addEventListener("blur", function () {
    validateEmail(emailInput)
  })
  phoneInput.addEventListener("blur", function () {
    validatePhone(phoneInput)
  })

  function sendAjax(formData) {
    const pluginUrl = form.getAttribute('data-plugin-url');
    fetch(pluginUrl + '/lead-form/form-handler.php', {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        hideSpinner()
        showModal()
        clearForm()
      } else {
        hideSpinner()
        showValidationErrors(data.errors)
      }
    })
    .catch(error => {
      hideSpinner()
      showModalError()
      showModal()
      return console.error("Помилка при виконанні Ajax-запиту:", error)
    })
  }

  function isFormValid() {
    const errorElements = [...document.querySelectorAll(".has-error")]
    return errorElements.length === 0
  }
  function showModal() {
    const modal = document.getElementById("modal")
    modal.style.display = "block"
  }

  function closeModal() {
    const modal = document.getElementById("modal")
    modal.style.display = "none"
  }
  function validateName(element) {
    const nameError = document.getElementById("name-error")
    const regex =/^[A-Za-zА-Яа-яЁё]+(\s[A-Za-zА-Яа-яЁё]+)?$/

    if (!regex.test(element.value) || element.value.startsWith(" ")) {
      nameError.textContent = "Ім'я повинно містити лише букви та один пробіл між словами, без початкового пробілу.";
      addErrorClass(element)
    } else {
      nameError.textContent = ""
      removeErrorClass(element)
    }
  }

  function validatePhone(element) {
    const phoneError = document.getElementById("phoneError")
    const regex = /^\+?[0-9]+$/

    if (!regex.test(element.value)) {
      phoneError.textContent = "Номер телефону повинен містити лише цифри."
      addErrorClass(element)
    } else {
      phoneError.textContent = ""
      removeErrorClass(element)
    }
  }
  function validateEmail(element) {
    const emailError = document.getElementById("emailError")
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (element.value === '') {
      return
    }
    if (!regex.test(element.value)) {
      emailError.textContent = "Невірний email"
      addErrorClass(element)
    } else {
      emailError.textContent = ""
      removeErrorClass(element)
    }
  }
  function addErrorClass(element) {
    if (!element.classList.contains('has-error')) {
      element.classList.add('has-error')
    }
  }
  function removeErrorClass(element) {
    if (element.classList.contains('has-error')) {
      element.classList.remove('has-error')
    }
  }

  function showSpinner() {
    button.setAttribute('disabled', '')
    document.getElementById("spinner").style.display = "block"
    document.getElementById("submit-text").classList.add('text-hidden')

  }

  function hideSpinner() {
    document.getElementById("spinner").style.display = "none";
    document.getElementById("submit-text").classList.remove('text-hidden')
    button.removeAttribute('disabled')
  }
  function showValidationErrors(errors) {
    clearValidationErrors();
    for (const field in errors) {
      const errorMessage = errors[field];
      const errorElement = document.querySelector(`#lead-form-${field} + .lead-form__error-message`)
      errorElement.textContent = errorMessage
    }
  }

  function clearValidationErrors() {
    const errorElements = document.querySelectorAll(".lead-form__error-message");
    errorElements.forEach(element => {
      element.textContent = ""
    });
  }

  function showModalError() {
    const modalMessages = document.querySelector('.modal-content__message-container')
    const modalErrorMessages = document.querySelector('.modal-content__error-container')
    modalMessages.style.display = "none"
    modalErrorMessages.style.display = "block"
  }
  function clearForm() {
    const formElements = form.elements;
    for (let i = 0; i < formElements.length; i++) {
      if (formElements[i].type !== 'submit') {
        formElements[i].value = '';
      }
    }
  }

})



