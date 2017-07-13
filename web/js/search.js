var search = (function () {

var $applicantSelect2 = $('#search-select2').select2({
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

  minimumInputLength: 2,
});

  function getUrlForSelect2()
  {
    return $('#search-select2').data('url');
  }

  $applicantSelect2.on('change', function (event) {
    var dataset = event.target.dataset;
    var applicantId = $('#search-select2').select2('data').id;
    var url = dataset.urlToApplicant.replace('__id__', applicantId);

    document.location.href = url;
  });
}());
