var applicants = (function () {
  const FORM = document.getElementById('applicants-form');
  const APPLICANT_LAST_NAME = document.getElementById('applicantLastNameSelect2');

  function getUrlForSelect2()
  {
    //return APPLICANT_LAST_NAME.dataset.url;
  }

  var applicantSelect2 = $('#applicantLastNameSelect2').select2({
    ajax: {
      url: getUrlForSelect2(),
      dataType: 'json',
      type: 'GET',
      delay: 250,
      data: function (params) {
        return {
            q: params,
          };
      },

      results: function (data, page) {
          return {
              results: data,
            };
        },

      cache: true,

    },
    escapeMarkup: function (markup) { return markup; },

    minimumInputLength: 1,
  });

}());
