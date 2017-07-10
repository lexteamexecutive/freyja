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

// Datatables Init
var usersDatatable = $('#users-table').DataTable({
  bLengthChange: false,
  language: { url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/French.json' },
});

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
