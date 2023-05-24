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
        html: '<input type="text" id="loginEmail" class="swal2-input" placeholder="Email">' +
            '<input type="password" id="loginPassword" class="swal2-input" placeholder="Password">',
        confirmButtonText: 'Log in',
        focusConfirm: false,
        preConfirm: function() {
            return new Promise(function(resolve) {
                resolve([
                    document.getElementById('loginEmail').value,
                    document.getElementById('loginPassword').value
                ]);
            });
        }
    }).then(function(result) {
        var email = result.value[0];
        var password = result.value[1];
        handleLogin(email, password);
    });
}

function showSignupForm() {
    Swal.fire({
        title: 'Sign up',
        html: '<input type="text" id="signupEmail" class="swal2-input" placeholder="Email">' +
            '<input type="password" id="signupPassword" class="swal2-input" placeholder="Password">',
        confirmButtonText: 'Sign up',
        focusConfirm: false,
        preConfirm: function() {
            return new Promise(function(resolve) {
                resolve([
                    document.getElementById('signupEmail').value,
                    document.getElementById('signupPassword').value
                ]);
            });
        }
    }).then(function(result) {
        var email = result.value[0];
        var password = result.value[1];
        handleSignup(email, password);
    });
}

function handleLogin(email, password) {
    $.ajax({
        url: 'login_handler.php',
        type: 'post',
        dataType: 'json',
        data: {
            email: email,
            password: password
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

function handleSignup(email, password) {
    $.ajax({
        url: 'signup_handler.php',
        type: 'post',
        dataType: 'json',
        data: {
            email: email,
            password: password
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
