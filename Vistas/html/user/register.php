<?php
    require_once "../../../Gestion/pdo.php";
    session_start();

    //Iniciar sesión
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
             
         } else {
             $_SESSION['usuario'] = $_POST['usuario'];
             
         }
     }

     //Registrar Usuario
     if(isset($_POST['correo']) && isset($_POST['password']) && isset($_POST['nombre'])
           && isset($_POST['apellidos'])){

        $sql = "INSERT INTO  usuarios (Identificacion, Nombre, Apellidos, Username,
                Email, Password, Telefono, isAdmin) 
                VALUES ( :id, :name, :lastname, :usr, :email, :pwd, :tel, FALSE)";

        $stmt = $pdo->prepare($sql);
        $stmt -> execute(array(
            ':id' => $_POST['cedula'],
            ':name' => $_POST['nombre'],
            ':lastname' => $_POST['apellidos'],
            ':usr' => $_POST['username'],
            ':email' => $_POST['correo'],
            ':pwd' => $_POST['password'],
            ':tel' => $_POST['phone']
        ));

        $_SESSION['success'] = "Usuario registrado correctamente.";
        header('Location: index.php');
        return;
    } else {
        $_SESSION['error'] = "Datos incompletos.";
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
    <link rel="stylesheet" href="../../html/user/css/indexStyle.css">
    <title>Mi tienda</title>
</head>
<body class="super-container">
    <header class="container-fluid">
        <div class="upper-jumbotron bg-secondary">
            <div class="float-right super-link" >
                <a data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
            </div>
        </div>
        <div class="jumbotron">
           <div class="text-center">
                <h1 class="display-1"><i>La tienda de Beltrán</i></h1>
                <p class="text-muted">La mejor tienda de La Sabana!</p>
           </div>
        </div>

        <!--Navbar-->

        <nav class="container navbar navbar-expand-lg navbar-light bg-light">
            <a href="index.html" class="nav-link">La Tienda</a>
            <button class="navbar-toggler" type="button" data-target="#navbarItems" aria-controls="navbarItems"
                 aria-expanded="false" aria-label="Toggle navigation" data-toggle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarItems">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                            <a class="nav-link" href="productos.php">Productos <span class="sr-only">(Products)</span></a>
                    </li>
                    <li class="nav-item active">
                            <a class="nav-link" href="nosotros.php">Nosotros <span class="sr-only">(Us)</span></a>
                    </li>                    
                </ul>
                <form class="form-inline m-auto my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-lg"></i> <span class="sr-only">(cart)</span></a>
                    </li>
                    <p> | </p>
                    <li class="nav-item active">
                        <a class="nav-link" href="profile.php"><i class="fas fa-user-circle fa-lg"></i><span class="sr-only">(profile)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    
    <main>
        <div class="container">
        <div id="" class="">
            <div class="card" role="">
                <div class="">
                    <div class="card-title">
                        <h3 class="m-3">Regístrate</h3>
                    </div>
                    <div class="card-body">
                        <main class="container">
                            <form method="post">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="nombre" class="col-md-4 col-form-label">Nombre:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nombre" id="nombre"
                                                placeholder="Nombre" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apellidos" class="col-md-4 col-form-label">Apellidos:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="apellidos" id="apellidos"
                                                placeholder="Apellidos" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cedula" class="col-md-4 col-form-label">Documento de identidad:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="cedula" id="cedula"
                                                placeholder="Documento de identidad" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correo" class="col-md-4 col-form-label">Email:</label>
                                        <div class="col-md-8">
                                            <input type="email" class="form-control" name="correo" id="correo"
                                                placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="username" class="col-md-4 col-form-label">Username:</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-md-4 col-form-label">Teléfono:</label>
                                        <div class="col-md-8">
                                            <input type="tel" class="form-control" name="phone" id="phone"
                                                placeholder="Teléfono" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label">Contraseña:</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password"
                                                id="password" placeholder="Contraseña" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password2" class="col-md-4 col-form-label">Confirmar
                                            contraseña:</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="password2"
                                                id="password2" placeholder="Confrimar contraseña" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                                <button type="submit" class="btn btn-primary ml-1">Regístrate</button>
                                                <button type="reset" class="btn btn-secondary">Cancelar</button>                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <footer class="bg-secondary">
       <div class="container">
           <div class="row">
               <div class="col-md-8">
                   <ul>
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                       <li><a href="#">Link</a></li>
                   </ul>
               </div>

               <div class="col-md-4 text-center">                
                    <p>Juan David Murillo Giraldo</p>
                    <p>ID: 0000155572</p>
                    <p>Universidad de La Sabana</p>                   
               </div>
               <div class="col-12 text-center" id="rights">
                   <p>Todos los derechos reservados 2019 &copy;</p>
               </div>
           </div>
       </div>
    </footer>
    <script src="../../js/jquery-3.4.1.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
</body>
</html>