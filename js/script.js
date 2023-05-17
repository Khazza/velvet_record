    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Confirmation de suppression',
            text: 'Êtes-vous sûr de vouloir supprimer ce disque ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Confirmer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigez vers la page de suppression du disque
                window.location.href = 'details.php?id=<?php echo $row['disc_id']; ?>';
            }
        });
    });
