// Toastr Init
toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: true,
  progressBar: false,
  positionClass: 'toast-bottom-full-width',
  preventDuplicates: false,
  onclick: null,
};

// Datatables init
var usersDatatable = $('#users-table').DataTable({
  destroy: true,
  bLengthChange: false,
  language: { url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' },
});

// Summernote init
var applicantsSummernote = $('#evaluation-summernote').summernote({
  lang: 'fr-FR',
  placeholder: 'Vous pouvez écrire votre description ici...',
  height: 300,
  minHeight: 300,
  maxHeight: 500,
  toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
  ],
});

// Select2 init
var usersRoleSelect2 = $('#usersRoleSelect2').select2({
  maximumSelectionSize: 1,
  formatSelectionTooBig: function (limit) { return 'Vous ne pouvez selectionner qu\'un rôle'; },
});

// Parsley init
var userForm =  $('#security-login').parsley();

// Various functions to use plugins
// Toastr functions
function sendInfoToastr(message, title)
{
  toastr.info(message, title);
}

function sendErrToastr(message, title)
{
  toastr.error(message, title);
}

// SweetAlert functions
function swalCancel(message = 'Aucune action n\'a été faite')
{
  swal('Annulé', message, 'error');
}
