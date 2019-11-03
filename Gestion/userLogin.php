<?php

    if(isset($_POST['correo']) && isset($_POST['password'])){
        unset($_SESSION['usuario']); //Logout al usuario actual
        
        $sql = "SELECT * FROM usuarios  WHERE
                 (Email = :em OR Username = :usr)
                 AND Password = :pas";
         
         $stmt = $pdo->prepare($sql);
         $stmt -> execute(array(
             ':em' => $_POST['correo'],
             ':usr' => $_POST['correo'],
             ':pas' => $_POST['password']
         ));
 
         $row = $stmt -> fetch(PDO::FETCH_ASSOC);
 
         if($row === false){
             $_SESSION['error'] = 'Usuario o contraseña incorrecta.';
             header('Location: login.php');
             return;
         } else {
             $_SESSION['usuario'] = $_POST['usuario'];
             header('Location: index.php');
             return;
         }
     }

?>