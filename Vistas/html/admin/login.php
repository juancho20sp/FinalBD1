<?php    
    require_once "../../../Gestion/loginValidation.php";  
    session_start();

    if(isset($_POST['usuario']) && isset($_POST['password'])){
        unset($_SESSION['usuario']); //Logout al usuario actual
        
        $sql = "SELECT * FROM admins WHERE
                 (email = :em OR username = :usr)
                 AND password = :pas";
         
         $stmt = $pdo->prepare($sql);
         $stmt -> execute(array(
             ':em' => $_POST['usuario'],
             ':usr' => $_POST['usuario'],
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../admin/css/loginStyle.css">
    <title>Admin Login</title>
</head>
<body class="super-container">
    <header class="container-fluid">
        <div class="jumbotron">
           <div class="text-center align-middle">
                <h1 class="display-1"><i>Bienvenido, Sr. Beltrán!</i></h1>
           </div>
    </header>
    
    <main id="super-card">
       <div class="container-fluid row">
            <div class="" id="card">
                <form method="post">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Ingrese su usuario">
                    </div>
                    <div class="from-group" id="lower">
                        <label for="password">Contraseña:</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
                    </div>

                    <?php
                        if (isset($_SESSION['error'])){
                            echo ('<p class="bg-primary">'.$_SESSION['error'].'</p>');
                            unset($_SESSION["error"]);
                        }    
                        
                        if (isset($_SESSION['success'])){
                            echo ('<p class="bg-primary">'.$_SESSION['success'].'</p>');
                            unset($_SESSION["success"]);
                        }  
                    ?>
                    <button type="submit" class="btn btn-primary ml-1" name="enter">Ingresar</button>
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                    <a href="signup.php">Registrar un usuario</a>
                </form>
            </div>
       </div>
    </main>

    <footer class="bg-secondary">
       <div class="container">
            <div class="d-flex justify-content-around">                
                <p>Juan David Murillo Giraldo</p>
                <p>ID: 0000155572</p>
                <p>Universidad de La Sabana</p>                   
            </div>
            <div class="col-12 text-center" id="rights">
                <p>Todos los derechos reservados 2019 &copy;</p>
            </div>
       </div>
    </footer>
    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
</body>
</html>