<?php
  require_once "../../../Gestion/pdo.php";
  session_start();  
  

  if(! isset($_SESSION['usuario'])){
    header("Location: login.php");
    return;
}

//Añadir precio de venta
    if(isset($_POST['precio'])){
        $sql = "UPDATE producto SET Precio_Venta = :price WHERE idProducto = :id";
        $stmt = $pdo->prepare($sql);

        $stmt -> execute(array(
            ':price' => $_POST['precio'],
            ':id' => $_POST['idProducto']
        ));

        $_SESSION['success'] = 'Precio añadido correctamente.';
    } else {
        $_SESSION['error'] = 'Fallo al agregar el precio.';
    }
?>
