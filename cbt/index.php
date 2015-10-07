<?php
function redirect($DoDie = true) {
    header('Location: media.php?module=home');
    if ($DoDie)
        die();
}
session_start();
if(isset($_SESSION['username'])) {
    redirect();
}
header ('location:login.php');
?>