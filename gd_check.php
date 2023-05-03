<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo 'L\'extension GD est activée.';
} else {
    echo 'L\'extension GD n\'est pas activée.';
}
