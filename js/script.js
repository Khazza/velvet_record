// function deleteDisc(discId) {
//     const swalWithBootstrapButtons = Swal.mixin({
//       customClass: {
//         confirmButton: 'btn btn-success',
//         cancelButton: 'btn btn-danger'
//       },
//       buttonsStyling: false
//     });
  
//     swalWithBootstrapButtons.fire({
//       title: 'Êtes-vous sûr(e) ?',
//       text: "Vous ne pourrez pas revenir en arrière !",
//       icon: 'warning',
//       showCancelButton: true,
//       confirmButtonText: 'Oui, supprimer !',
//       cancelButtonText: 'Non, annuler !',
//       reverseButtons: true
//     }).then((result) => {
//       if (result.isConfirmed) {
//         // Redirection vers la page de suppression avec l'ID du disque
//         window.location.href = 'delete_disc.php?id=' + discId;
//       } else if (result.dismiss === Swal.DismissReason.cancel) {
//         swalWithBootstrapButtons.fire(
//           'Annulé',
//           'Votre fichier est en sécurité :)',
//           'error'
//         );
//       }
//     });
//   }
  


// -------------------------Supression disc-------------------------
  function deleteDisc(id) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Non, annuler!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Effectuez la requête de suppression ici
            $.ajax({
                url: 'delete_disc.php',  // URL vers votre script PHP pour supprimer le disque
                type: 'POST',
                data: {id: id},
                success: function() {
                    Swal.fire(
                        'Supprimé!',
                        'Le disque a été supprimé.',
                        'success'
                    ).then(() => {
                        // Redirigez l'utilisateur vers une autre page après la suppression
                        window.location.href = 'index.php';
                    });
                },
                error: function() {
                    Swal.fire(
                        'Erreur!',
                        'Une erreur s\'est produite lors de la suppression du disque.',
                        'error'
                    );
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Annulé',
                'Le disque est sûr :)',
                'error'
            );
        }
    });
}

// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------
// -------------------------Login / Signup-------------------------
function showLoginForm() {
    Swal.fire({
        title: 'Login',
        html:
            '<input type="text" id="login-username" class="swal2-input" placeholder="Username">' +
            '<input type="password" id="login-password" class="swal2-input" placeholder="Password">',
        confirmButtonText: 'Log in',
        focusConfirm: false,
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#login-username').value
            const password = Swal.getPopup().querySelector('#login-password').value
            if (!username || !password) {
                Swal.showValidationMessage(`Please enter username and password`)
            }
            return { username: username, password: password }
        }
    }).then((result) => {
        // send ajax request to login_handler.php
        $.ajax({
            url: 'login_handler.php',
            type: 'POST',
            data: {
                username: result.value.username,
                password: result.value.password
            },
            success: function(response) {
                // handle the response
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // handle the error
            }
        });
    })
}

function showSignupForm() {
    Swal.fire({
        title: 'Sign up',
        html:
            '<input type="text" id="signup-username" class="swal2-input" placeholder="Username">' +
            '<input type="password" id="signup-password" class="swal2-input" placeholder="Password">' +
            '<input type="password" id="signup-confirm-password" class="swal2-input" placeholder="Confirm Password">',
        confirmButtonText: 'Sign up',
        focusConfirm: false,
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#signup-username').value
            const password = Swal.getPopup().querySelector('#signup-password').value
            const confirmPassword = Swal.getPopup().querySelector('#signup-confirm-password').value
            if (!username || !password || !confirmPassword) {
                Swal.showValidationMessage(`Please enter all fields`)
            }
            return { username: username, password: password, confirmPassword: confirmPassword }
        }
    }).then((result) => {
        // send ajax request to signup_handler.php
        $.ajax({
            url: 'signup_handler.php',
            type: 'POST',
            data: {
                username: result.value.username,
                password: result.value.password,
                confirm_password: result.value.confirmPassword
            },
            success: function(response) {
                // handle the response
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // handle the error
            }
        });
    })
}
