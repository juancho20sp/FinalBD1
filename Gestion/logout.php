<?php
    session_start(); 
    session_destroy();    
    header('Location: ../Vistas/html/admin/index.php');
?>