var applicants = (function () {
  var lastNameInput = document.getElementById('applicant_lastName');

  lastNameInput.onkeyup = function () {
      this.value = this.value.toUpperCase();
    };
}());
