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
// --------------------------------CSRF token---------------------------------

var csrf_token = '';

$(document).ready(function() {
    $.get('get_csrf_token.php', function(data) {
        csrf_token = data;
    });
});


// -------------------------Login / Signup-------------------------
document.getElementById('loginBtn').addEventListener('click', function(e) {
    e.preventDefault();
    showLoginForm();
});

document.getElementById('signupBtn').addEventListener('click', function(e) {
    e.preventDefault();
    showSignupForm();
});

function showLoginForm() {
    Swal.fire({
        title: 'Login',
        html: '<input type="text" id="loginUsername" class="swal2-input" placeholder="Username">' +
            '<input type="password" id="loginPassword" class="swal2-input" placeholder="Password">' +
            '<input type="hidden" id="loginCsrfToken" class="swal2-input" value="' + csrf_token + '">',
        confirmButtonText: 'Log in',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('loginUsername').value,
                document.getElementById('loginPassword').value,
                document.getElementById('loginCsrfToken').value
            ]
        }
    }).then((result) => {
        if (result.value) {
            handleLogin(result.value);
        }
    });
}


function handleLogin(username, password, csrf_token) {
    $.ajax({
        url: 'login_handler.php',
        type: 'post',
        dataType: 'json',
        data: {
            username: username,
            password: password,
            csrf_token: csrf_token
        },
        success: function(response) {
            if (response.status === "success") {
                location.reload();
            } else {
                Swal.fire('Erreur', response.message, 'error');
            }
        }
    });
}

function showSignupForm() {
    Swal.fire({
        title: 'Sign up',
        html: '<input type="text" id="signupUsername" class="swal2-input" placeholder="Username">' +
            '<input type="password" id="signupPassword" class="swal2-input" placeholder="Password">' +
            '<input type="password" id="signupConfirmPassword" class="swal2-input" placeholder="Confirm Password">' +
            '<input type="hidden" id="signupCsrfToken" class="swal2-input" value="' + csrf_token + '">',
        confirmButtonText: 'Sign up',
        focusConfirm: false,
        preConfirm: () => {
            return [
                document.getElementById('signupUsername').value,
                document.getElementById('signupPassword').value,
                document.getElementById('signupConfirmPassword').value,
                document.getElementById('signupCsrfToken').value
            ]
        }
    }).then((result) => {
        if (result.value) {
            handleSignup(result.value);
        }
    });
}


function handleSignup(username, password, confirmPassword, csrf_token) {
    $.ajax({
        url: 'signup_handler.php',
        type: 'post',
        dataType: 'json',
        data: {
            username: username,
            password: password,
            confirm_password: confirmPassword,
            csrf_token: csrf_token
        },
        success: function(response) {
            if (response.status === "success") {
                location.reload();
            } else {
                Swal.fire('Erreur', response.message, 'error');
            }
        }
    });
}
