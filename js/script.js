// -------------------------Supression disc-------------------------
function deleteDisc(id) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer!',
        confirmButtonColor: '#6e0a19',
        cancelButtonText: 'Non, annuler!',
        cancelButtonColor: '#a41930',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Effectuez la requête de suppression ici
            $.ajax({
                url: 'delete_disc.php',  // URL vers script PHP pour supprimer le disque
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
                'Le disque safe ! :)',
                'error'
            );
        }
    });
}

// ----------------------------------Login------------------------------------
document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const login = urlParams.get('login');

    if (login === 'success') {
        Swal.fire({
            title: 'Connecté avec succès!',
            text: 'Bienvenue!',
            icon: 'success',
            confirmButtonText: 'Cool',
            confirmButtonColor: '#6e0a19'
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
            confirmButtonText: 'Cool',
            confirmButtonColor: '#6e0a19'
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
            'success',
            {
                confirmButtonColor: '#6e0a19'
            }
        ).then(() => {
            history.replaceState(null, '', 'index.php');
        });
    }
});

// ----------------------------------Artiste-----------------------------------
document.getElementById('artist').addEventListener('change', function() {
    if (this.value === 'add_new') {
        var newArtist = prompt('Entrez le nom du nouvel artiste :');
        if (newArtist) {
            var opt = document.createElement('option');
            opt.value = newArtist;
            opt.innerHTML = newArtist;
            this.appendChild(opt);
            this.value = newArtist;
        } else {
            this.value = '';
        }
    }
});

// ----------------------------------Form Edit----------------------------------
$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault(); 

        var form = $(this);
        var formData = new FormData(form[0]);

        // Récupérer l'ID du disque
        var discId = $('#disc-id').data('id');

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Afficher une alerte de succès
                Swal.fire({
                    icon: 'success',
                    title: 'Modifications enregistrées',
                    showConfirmButton: false,
                    timer: 1500,
                    confirmButtonColor: '#6e0a19'
                }).then(function() {
                    // Redirection vers la page de détails du disque
                    window.location.href = 'details.php?id=' + discId;
                });
            },
            error: function(xhr, status, error) {
                // Afficher une alerte d'erreur
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur s\'est produite lors de l\'enregistrement des modifications.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#6e0a19'
                });
            }
        });
    });
});

// formulaire envoi artiste
document.getElementById('discForm').addEventListener('submit', function(event) {
    var artist = document.getElementById('artist').value;
    var newArtist = document.getElementById('new_artist').value;
    if (artist === "" && newArtist === "") {
        event.preventDefault();
        alert("Veuillez remplir soit le champ Artiste, soit le champ Nouvel Artiste.");
    }
});