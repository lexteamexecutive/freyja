
function deleteUser(element)
{
  var url = element.dataset.url;
  var tr = element.parentNode.parentNode; // Récupère le TR de l'element

  swal({
    title: 'Etes-vous sûr?',
    text: 'Vous ne pourrez plus retrouver cet utilisateur !',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Oui',
    cancelButtonText: 'Non',
    closeOnConfirm: false,
    closeOnCancel: false,
  },
  function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        url: url,
        success: function (result) {
          if (result.success) {
            swal('Supprimé!', 'La suppression a été effectué.', 'success');
            tr.style.display = 'none';
          } else {
            swalCancel(result.message);
          }
        },

        error: function (error) {
          swalCancel();
        },
      });
    } else {
      swalCancel();
    }

  });
}

function updateUserIsActive(element)
{
  var url = element.dataset.url;
  var message = '';

  initToastr();

  $.ajax({
    url: url,
    success: function (result) {
      if (element.checked) {
        message = 'Utilisateur activé';
      } else {
        message = 'Utilisateur désactivé';
      }

      sendInfoToastr('La modification à été prise en compte', message);
    },

    error: function (error) {
      sendErrToastr('Une erreur est survenue. Veuillez contactez la personne en charge de l\'application', 'Erreur');
    },
  });

}

function initToastr()
{
  toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: true,
    progressBar: false,
    positionClass: 'toast-bottom-full-width',
    preventDuplicates: false,
    onclick: null,
  };
}

function sendInfoToastr(message, title)
{
  toastr.info(message, title);
}

function sendErrToastr(message, title)
{
  toastr.error(message, title);
}

function swalCancel(message = 'Aucune action n\'a été faite')
{
  swal('Annulé', message, 'error');
}
