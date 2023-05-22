 // Fonction de suppression réelle en utilisant une requête AJAX
 function deleteDisc(id) {
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

    // Appel AJAX pour supprimer le disque
    // Assurez-vous d'ajuster le chemin du fichier delete_disc.php si nécessaire
    $.ajax({
        url: 'delete_disc.php?id=' + id,
        type: 'GET',
        success: function (response) {
            Swal.fire('Suppression réussie', 'Le disque a été supprimé avec succès', 'success');
            // Faire d'autres actions après la suppression réussie si nécessaire
        },
        error: function (xhr, status, error) {
            Swal.fire('Erreur', 'Une erreur s\'est produite lors de la suppression', 'error');
            // Gérer l'erreur si nécessaire
        }
    });
}