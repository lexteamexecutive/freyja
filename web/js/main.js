
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
          console.log(result);
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

function swalCancel(message = 'Aucune action n\'a été faite')
{
  swal('Annulé', message, 'error');
}
