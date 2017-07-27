var applicants = (function () {
  var lastNameInput = document.getElementById('applicant_lastName');

  if (lastNameInput !== null) {
    lastNameInput.onkeyup = function () {
      this.value = this.value.toUpperCase();
    };
  }
}());
