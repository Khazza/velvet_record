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

function showLoginForm() {
    Swal.fire({
        title: 'Log In',
        html:
        '<input id="swal-input1" class="swal2-input" placeholder="Username">' +
        '<input id="swal-input2" class="swal2-input" placeholder="Password" type="password">',
        confirmButtonText: 'Log in',
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#swal-input1').value
            const password = Swal.getPopup().querySelector('#swal-input2').value
            if (!username || !password) {
                Swal.showValidationMessage(`Please enter username and password`)
            }
            return { username: username, password: password }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'login_script.php',
                type: 'POST',
                data: {
                    username: result.value.username,
                    password: result.value.password
                },
                success: function(response) {
                    if (response === 'success') {
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Invalid username or password', 'error');
                    }
                }
            });
        }
    });
}

function showSignupForm() {
    Swal.fire({
        title: 'Sign Up',
        html:
        '<input id="swal-input1" class="swal2-input" placeholder="Username">' +
        '<input id="swal-input2" class="swal2-input" placeholder="Email">' +
        '<input id="swal-input3" class="swal2-input" placeholder="Password" type="password">' +
        '<input id="swal-input4" class="swal2-input" placeholder="Confirm Password" type="password">',
        confirmButtonText: 'Sign up',
        preConfirm: () => {
            const username = Swal.getPopup().querySelector('#swal-input1').value
            const email = Swal.getPopup().querySelector('#swal-input2').value
            const password = Swal.getPopup().querySelector('#swal-input3').value
            const confirmPassword = Swal.getPopup().querySelector('#swal-input4').value
            if (!username || !email || !password || !confirmPassword) {
                Swal.showValidationMessage(`Please enter all fields`)
            } else if (password !== confirmPassword) {
                Swal.showValidationMessage(`Passwords do not match`)
            }
            return { username: username, email: email, password: password }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'signup_script.php',
                type: 'POST',
                data: {
                    username: result.value.username,
                    email: result.value.email,
                    password: result.value.password
                },
                success: function(response) {
                    if (response === 'success') {
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Unable to sign up', 'error');
                    }
                }
            });
        }
    });
}
