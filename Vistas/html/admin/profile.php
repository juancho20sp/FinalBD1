<?php
    require_once "../../../Gestion/pdo.php";
    session_start();
        
    if(!isset($_SESSION['usuario'])){
        header("Location: login.php");
        return;
    }

    //Hacemos la edición
    if(isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['email'])){
        $sql = "UPDATE usuarios SET Nombre = :nombre,
            Apellidos = :apellidos,
            Email = :email,
            Password = :password
            WHERE idUsuarios = :idUsuarios";

        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array(
            ':nombre' => $_POST['nombre'],
            ':apellidos' => $_POST['apellidos'],
            ':email' => $_POST['email'],
            ':password' => $_POST['password'],
            ':idUsuarios' => $_SESSION['usrId']
    ));
        $_SESSION['success'] = "Usuario actualizado correctamente";
    }

    //Traemos la información del usuario
    $sql = "SELECT * FROM usuarios WHERE Username = :usr";
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(":usr" => $_SESSION['usuario']));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['usrId'] = $user['idUsuarios'];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../admin/css/profileStyle.css">
    <title>Perfil</title>
</head>
<body class="super-container">
    <header class="container-fluid">
        <div class="upper-jumbotron bg-secondary">            
            <div class="float-right super-link" >
                <a href="../../../Gestion/logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
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
            <a href="../admin/index.php" class="nav-link">Mi tiendita</a>
            <button class="navbar-toggler" type="button" data-target="#navbarItems" aria-controls="navbarItems"
                 aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarItems">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="menu.php">Menú <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Registros
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="clientes.php">Clientes</a>
                          <a class="dropdown-item" href="proveedores.php">Proveedores</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="inventario.php">Inventario</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pagos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="#">Por cobrar</a>
                          <a class="dropdown-item" href="#">Por realizar</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
                <form class="form-inline m-auto my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="controlpanel.php"><i class="fas fa-cogs fa-lg"></i><span class="sr-only">(cart)</span></a>
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
           <div class="row justify-content-center profile-container">
               <aside class="col-md-4">
                    <div class="aside bg-secondary">
                        <div class="text-center subprofile">
                            <img src="../../public/img/profile.png" alt="profile" width="250px" height="250px">
                            <p><?= $user['Nombre']?>  <?= $user['Apellidos']?></p>
                            <p>Rol: Administrador</p>
                            <div class="row justify-content-center">
                                <a href="../../../Gestion/logout.php" class=" col-4 btn btn-primary">Salir</a>
                            </div>
                        </div>
                    </div>
               </aside>
               <div class="col-md-8">
                    <div class="main bg-light">
                        <div class="card2">
                            <form method="post">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input name="nombre" type="text" class="form-control" id="nombre" value="<?= $user['Nombre']?>">
                                </div>
                                <div class="form-group">
                                    <label for="apellidos">Apellidos:</label>
                                    <input name="apellidos" type="text" class="form-control" id="apellidos" value="<?= $user['Apellidos']?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input name="email" type="text" class="form-control" id="email" value="<?= $user['Email']?>">
                                </div>
                                <div class="form-group">
                                    <label for="usuario">Usuario:</label>
                                    <input name="usuario" type="text" class="form-control" id="usuario" value="<?= $user['Username']?>" disabled>
                                </div>
                                <div class="from-group" id="lower">
                                    <label for="password">Contraseña:</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Ingrese su contraseña" required>
                                </div>
                                <?php 
                                    if(isset($_SESSION['success'])){
                                        echo '<p>'.$_SESSION['success'].'</p>';
                                        unset($_SESSION['success']);
                                    }
                                ?>                                                             
                                <button type="submit" class="btn btn-primary ml-1">Editar</button>
                                <button type="button" class="btn btn-secondary">Cancelar</button>                                
                            </form>
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