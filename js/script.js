function deleteDisc(discId) {
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    });
  
    swalWithBootstrapButtons.fire({
      title: 'Êtes-vous sûr(e) ?',
      text: "Vous ne pourrez pas revenir en arrière !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Oui, supprimer !',
      cancelButtonText: 'Non, annuler !',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirection vers la page de suppression avec l'ID du disque
        window.location.href = 'delete_disc.php?id=' + discId;
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          'Annulé',
          'Votre fichier est en sécurité :)',
          'error'
        );
      }
    });
  }
  