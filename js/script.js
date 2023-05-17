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
            window.location.href = 'delete_disc.php?id=' + id;
        }
    });
}