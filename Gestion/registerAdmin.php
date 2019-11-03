<?php
    require_once  "pdo.php";
    session_start();

    if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['usuario']) 
        && isset($_POST['password']) && isset($_POST['Identificacion']) && isset($_POST['Telefono'])
            && isset($_POST['email'])){
                
            $sql = "INSERT INTO  usuarios (Identificacion, Nombre, Apellidos, Username,
                        Email, Password, Telefono, isAdmin) 
                    VALUES (:id, :name, :lastname, :usr, :email, :pwd, :tel, TRUE)";

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array(
                ':id' => $_POST['Identificacion'],
                ':name' => $_POST['nombre'],
                ':lastname' => $_POST['apellidos'],
                ':usr' => $_POST['usuario'],
                ':email' => $_POST['email'],
                ':pwd' => $_POST['password'],
                ':tel' => $_POST['Telefono']
            ));

            $_SESSION['success'] = "Usuario registrado correctamente.";
            header('Location: login.php');
            return;
    } else {
        $_SESSION['error'] = "Datos incompletos.";
    }

?>