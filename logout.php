<?php
session_start();

// Supprime toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page d'accueil avec le paramètre de requête logout=success
header('Location: index.php?logout=success');
exit();
?>
