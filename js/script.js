// function confirmDelete(id) {
//     Swal.fire({
//         title: 'Confirmation de suppression',
//         text: 'Êtes-vous sûr de vouloir supprimer ce disque ?',
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonText: 'Confirmer',
//         cancelButtonText: 'Annuler'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             window.location.href = 'delete_disc.php?id=' + id;
//         }
//     });
// }
    function confirmDelete(id) {
        Swal.fire({
            title: 'Confirmation de suppression',
            text: 'Êtes-vous sûr de vouloir supprimer ce disque ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Appel AJAX ou redirection vers la page de suppression
                Swal.fire({
                    title: 'Suppression en cours',
                    icon: 'info',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    timerProgressBar: true,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Exécutez ici l'action de suppression (par exemple, appel AJAX)
                // Après la suppression réussie, affichez le message de réussite
                // Sinon, affichez le message d'erreur
                simulateDelete(id);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Annulé', 'La suppression a été annulée', 'error');
            }
        });
    }

    // Fonction de suppression simulée (à remplacer par votre propre logique de suppression)
    function simulateDelete(id) {
        // Code de suppression simulé avec une délai de 2 secondes
        setTimeout(() => {
            // Suppression réussie
            Swal.fire('Suppression réussie', 'Le disque a été supprimé avec succès', 'success');
        }, 2000);
    }
