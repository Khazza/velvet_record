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
// ----------------------------------Login------------------------------------
document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const login = urlParams.get('login');

    if (login === 'success') {
        Swal.fire({
            title: 'Connecté avec succès!',
            text: 'Bienvenue dans votre compte.',
            icon: 'success',
            confirmButtonText: 'Cool'
        }).then(() => {
            history.replaceState(null, '', 'index.php');
        })
    }
});

// ----------------------------------Logout-----------------------------------
document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const logout = urlParams.get('logout');

    if (logout === 'success') {
        Swal.fire({
            title: 'Déconnecté avec succès!',
            text: 'Vous avez été déconnecté de votre compte.',
            icon: 'success',
            confirmButtonText: 'Cool'
        }).then(() => {
            history.replaceState(null, '', 'index.php');
        })
    }
});

// ----------------------------------Signup-----------------------------------
$(document).ready(function() {
    if (typeof register_success !== 'undefined' && register_success) {
        Swal.fire(
            'Inscription réussie !',
            register_success,
            'success'
        ).then(() => {
            history.replaceState(null, '', 'index.php');
        });
    }
});
