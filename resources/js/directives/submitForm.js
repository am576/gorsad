import axios from 'axios';

export const submitFormDirective = {
  bind(el) {
    el.addEventListener('click', function () {
        
      // Find the nearest form element
      const form = el.closest('form');

      if (form && form.checkValidity()) {
        // Submit the form using Axios
        axios.post("/sendMessage", new FormData(form))
          .then(response => {
            // Show a success message or handle the response as needed
            alert("Спасибо за обращение! Мы обязательно свяжемся с Вами в ближайшее время.")
            window.location.reload()
          })
          .catch(error => {
            // Show an error message or handle the error as needed
            console.error('Form submission failed', error);
          });
      }
    });
  }
};