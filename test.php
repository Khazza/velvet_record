<?php
        // Afficher les erreurs s'il y en a
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p>" . $error . "</p>";
            }
            unset($_SESSION['errors']);
        }
        ?>