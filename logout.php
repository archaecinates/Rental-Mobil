<?php
session_start();
if (isset($_SESSION['user'])) {
    // Kosongkan variabel session yang ingin dihapus
    $_SESSION['user'] = null;
    // Hapus session
    session_unset();
    session_destroy();
    header("Location: index.php"); 
    exit;
}
?>
