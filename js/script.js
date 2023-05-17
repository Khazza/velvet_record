$(document).ready(function() {
    // Gestionnaire d'événements pour le clic sur le bouton "Supprimer" du modal
    $('#deleteModal .btn-danger').click(function() {
        // Effectuez ici l'action de suppression
        // Vous pouvez utiliser AJAX pour envoyer une requête de suppression au serveur

        // Fermez le modal après la suppression
        $('#deleteModal').modal('hide');
    });
});
