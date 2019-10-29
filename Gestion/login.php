<?php
    session_start();

    if(isset($_POST['usuario']) && isset($_POST['password'])){
        unset($_SESSION['usuario']); //Le hacemos logout al usuario actual
        
        if($_POST['password' === "bla"]){

        }
    }

?>