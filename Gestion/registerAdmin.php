<?php
    require_once  "pdo.php";
    session_start();

    if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['usuario']) 
        && isset($_POST['password'])){
            $sql = "INSERT INTO  admins (nombre, apellidos, username, email, password) 
                    VALUES (:name, :lastname, :usr, :email, :pwd)";

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array(
                ':name' => $_POST['nombre'],
                ':lastname' => $_POST['apellidos'],
                ':usr' => $_POST['usuario'],
                ':email' => $_POST['email'],
                ':pwd' => $_POST['password']
            ));

            $_SESSION['success'] = "Usuario registrado correctamente.";
            header('Location: login.php');
            return;
    }

?>