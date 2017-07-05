
function deleteUser(element)
{
  var url = element.dataset.url;

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
            swal({
              title: 'Supprimé !',
              text: 'La page va se recharger automatiquement',
              timer: 2000,
              showConfirmButton: false,
            });
            setTimeout(function () {
                location.reload();
              }, 1900);
          } else {
            swal('Annulé', result.message, 'error');
          }
        },

        error: function (error) {
          swal('Annulé', 'Aucune action n\'a été faite', 'error');
        },
      });
    } else {
      swal('Annulé', 'Aucune action n\'a été faite', 'error');
    }

  });
}
