<?php
    require_once  "pdo.php";

    if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['usuario']) 
        && isset($_POST['password'])){
            $sql = "INSERT INTO  admins (nombre, apellidos, email, password) 
                    VALUES (:name, :lastname, :usr, :pwd)";

            $stmt = $pdo->prepare($sql);
            $stmt -> execute(array(
                ':name' => $_POST['nombre'],
                ':lastname' => $_POST['apellidos'],
                ':usr' => $_POST['usuario'],
                ':pwd' => $_POST['password']
            ));
    }

?>