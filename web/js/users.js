var users = (function () {
  const TABLE = document.getElementById('users-table');

  function updateUser(element) {
    var url = element.dataset.url;
    var tr = element.parentNode.parentNode.parentNode;
    var message = '';

    $.ajax({
      url: url,
      success: function () {
        if (element.checked) {
          message = 'Utilisateur activé';
          tr.style.backgroundColor = '#f5f5f5';
          element.parentElement.children[2].innerHTML = '1';
        } else {
          message = 'Utilisateur désactivé';
          tr.style.backgroundColor = 'lightgrey';
          element.parentElement.children[2].innerHTML = '0';
        }

        sendInfoToastr('La modification à été prise en compte', message);
      },

      error: function (error) {
        sendErrToastr('Une erreur est survenue.', 'Erreur');
      },
    });
  };

  function deleteUser(element) {
    var url = element.dataset.url;
    var tr = element.parentNode.parentNode.parentNode;

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
              usersDatatable.row($(tr)).remove().draw();
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
  };

  function passEventTarget(className, callback, liveEvent) {
    if (liveEvent.target.classList.contains(className)) {
      callback(liveEvent.target);
    }
  };

  var passUpdateUser = passEventTarget.bind(null, 'user-update', updateUser);
  var passDeleteUser = passEventTarget.bind(null, 'user-delete', deleteUser);

  if (TABLE !== null) {
    TABLE.addEventListener('change', passUpdateUser);
    TABLE.addEventListener('click', passDeleteUser);
  }
}());
