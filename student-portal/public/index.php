<?php
require_once '../config.php';
require_once '../components/header.php';

if (isLoggedIn()) {
    redirect('pages/dashboard.php');
} else {
    redirect('pages/home.php');
}

require_once '../components/footer.php';
?>