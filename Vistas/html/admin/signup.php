<?php
    require_once  "../../../Gestion/registerAdmin.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../admin/css/signinStyle.css">
    <title>Registrar administrador</title>
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
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="nombre">Nombre:</label>
                            <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="apellidos">Apellidos:</label>
                            <input name="apellidos" type="text" class="form-control" id="apellidos" placeholder="Ingrese sus apellidos">
                        </div>                    
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="Identificacion">Identificación:</label>
                            <input name="Identificacion" type="text" class="form-control" id="Identificacion" placeholder="Ingrese su Identificación">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="Telefono">Teléfono:</label>
                            <input name="Telefono" type="text" class="form-control" id="Telefono" placeholder="Ingrese su Teléfono">
                        </div>                    
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" type="text" class="form-control" id="email" placeholder="Ingrese su usuario">
                    </div>
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
                    ?>

                    <button type="submit" class="btn btn-primary ml-1">Registrar</button>
                    <button type="button" class="btn btn-secondary">Cancelar</button>
                    <a href="login.php">Volver</a>
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