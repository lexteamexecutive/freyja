var applicants = (function () {
  var lastNameInput = document.getElementById('applicant_lastName');
  var specialitiesCombo = document.getElementById('applicant_evaluation_specialities');

  if (lastNameInput !== null) {
    lastNameInput.onkeyup = function () {
      this.value = this.value.toUpperCase();
    };
  }

  if (specialitiesCombo !== null) {
    $(specialitiesCombo).select2({
      placeholder: 'Selection...',
    });
  }
}());
