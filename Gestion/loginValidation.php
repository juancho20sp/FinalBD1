<?php  
    require_once "pdo.php";
    /*if(isset($_POST['usuario']) && isset($_POST['password'])){
        unset($_SESSION['usuario']); //Logout al usuario actual
         
        echo "User and password are set";
        $sql = "SELECT * FROM admins WHERE
                 email = :em
                 AND password = :pas";
         
         $stmt = $pdo->prepare($sql);
         $stmt -> execute(array(
             ':em' => $_POST['usuario'],
             ':pas' => $_POST['password']
         ));
 
         $row = $stmt -> fetch(PDO::FETCH_ASSOC);
 
         if($row === false){
             $_SESSION['error'] = 'Usuario o contraseña incorrecta.';
             header('Location: login.php');
             return;
         } else {
             $_SESSION['usuario'] = $POST['usuario'];
             header('Location: index.php');
             return;
         }
 
         var_dump($row);
     }*/

?>