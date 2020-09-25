let xhr = new XMLHttpRequest();

/**
 * Add handlers for error and success, then send request with paramaters
 * @param params [string] GET paramaters
 */
function sendXhr(params) {
  xhr.addEventListener('error', handleError);
  xhr.addEventListener('loadend', handleLoadend);
  xhr.responseType = 'json';
  xhr.open('GET', bookidAjaxurl + params);
  xhr.send(null);
}

/**
 * Get paramters from button and send add booking request
 * @param event [Event] click event
 */
function addBooking(event) {
  event.preventDefault();
  if (document.getElementById('guests').checkValidity()) {
    let params = "?action=bookid_add" +
      "&post=" + event.target.dataset.post +
      "&timeslot=" + event.target.dataset.timeslot +
      "&guests=" + document.getElementById('guests').value;
    sendXhr(params);
  } else {
    alert("Please let us know who’s joining you!");
  }
}

/**
 * Get paramters from button and send cancel booking request
 * @param event [Event] click event
 */
function cancelBooking(event) {
  let params = "?action=bookid_cancel" +
    "&post=" + event.target.dataset.post;
  sendXhr(params)
}

/**
 * Reload page because the booking was successful
 */
function handleLoadend(e) {
  if (e.target.response.success) {
    window.location.reload(false);
  } else {
    let error = "";
    switch (e.target.response.problem) {
      case 'consecutive':
        error = "To make sure as many people as possible are able to visit ID Kafee, you can’t book two consecutive weeks. Sorry!";
        break;
      default:
        console.log('unknown error');
    }
    showError(error);
  }
}

/**
 * Alert the user that something went wrong
 */
function handleError(e) {
  showError("Sorry, something went wrong. Please try again. If this keeps happening, please email us at svid@tudelft.nl");
}

/**
 * Render an error message for the user
 * @param message [string] the error message to show
 */
function showError(message) {
  let errorEl = document.createElement('div');
  errorEl.classList.add('contact-form__message', 'contact-form__message--failed');
  errorEl.innerHTML = message;
  document.getElementById('bookid-form').appendChild(errorEl);
}

/**
 * Put the functions to work when the DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
  let addBookingButton = document.querySelectorAll('.js-add-booking'),
    cancelBookingButton = document.querySelector('.js-cancel-booking');

  if(addBookingButton) addBookingButton.forEach(button => button.addEventListener('click', addBooking));
  if(cancelBookingButton) cancelBookingButton.addEventListener('click', cancelBooking);
});
