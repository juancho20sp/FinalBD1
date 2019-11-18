<?php
    require_once "../../../Gestion/pdo.php";
    session_start();

    //Delete method
    if(isset($_POST['delete']) && isset($_POST['idProducto'])){
        $sql = "DELETE FROM carrito WHERE idProducto = :zip";
      
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':zip' => $_POST['idProducto']
        )); 

        $_SESSION['success'] = 'Producto eliminado correctamente';
    }

    //Update method
    if(isset($_POST['update']) && isset($_POST['idProducto'])){
        $sql = "UPDATE carrito SET Cantidad = :cantidad WHERE idProducto = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array(
            ":cantidad" => $_POST['cantidad'],
            ":id" => $_POST['idProducto']
        ));

        $_SESSION['success'] = "Cantidad actualizada correctamente";
    }


    //Limpiar carrito
    if(isset($_POST['empty'])){
        $sql = "DELETE FROM carrito";
        $stmt = $pdo -> query($sql);

        $_SESSION['success'] = "Se ha limpiado el carrito de compras";
    }

    //Pagar
    if(isset($_POST['pay'])){
        header("Location: register.php");
        return;
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
    <link rel="stylesheet" href="../../html/user/css/productsStyle.css">
    <title>Mi tienda</title>
</head>
<body class="super-container">
    <!--Empieza el modal-->
    <div id="loginModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Inicia sesión</h3>
                        <button class="close" type="button" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <main class="container">
                            <div class="row">
                                <div class="col-md-9 offset-md-2">
                                    <ul class="nav nav-pills justify-content-center">
                                        <li class="nav-item"><a href="#inicio" class="nav-link active" role="tab"
                                                data-toggle="tab">
                                                Iniciar sesión
                                            </a>
                                        </li>
                                        <li class="nav-item"><a href="#registro" class="nav-link" role="tab"
                                                data-toggle="tab">
                                                Regístrate
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="tab-content col-lg-9 offset-lg-2">
                                    <div class="tab-pane fade show active" role="tabpanel" id="inicio">
                                        <form>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="correo" class="col-md-4 col-form-label">Email:</label>
                                                    <div class="col-md-8">
                                                        <input type="email" class="form-control" name="correo" id="correo"
                                                            placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password"
                                                        class="col-md-4 col-form-label">Contraseña:</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" placeholder="Contraseña">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <div class="col-4"></div>
                                                <div class="col-auto input-group-lg">
                                                    <input type="checkbox" class="form-check-input" name="recuerdame"
                                                        id="recuerdame" value="">
                                                    <label for="recuerdame" class="form-check-label">Recuérdame</label>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary ml-1">Ingresar</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                            </div>
    
    
                                        </form>
                                    </div>
                                    <div class="tab-pane fade show" role="tabpanel" id="registro">
                                        <form>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="correo" class="col-md-4 col-form-label">Email:</label>
                                                    <div class="col-md-8">
                                                        <input type="email" class="form-control" name="correo" id="correo"
                                                            placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password"
                                                        class="col-md-4 col-form-label">Contraseña:</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control" name="password"
                                                            id="password" placeholder="Contraseña">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password2" class="col-md-4 col-form-label">Confirmar
                                                        contraseña:</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control" name="password2"
                                                            id="password2" placeholder="Confrimar contraseña">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary ml-1">Regístrate</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

    <!--Acaba del modal-->
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
                            <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-lg"></i><span class="sr-only">(cart)</span></a>
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
            <!--Serán generados con PHP-->
            <h2>Carrito de compras</h2>
            <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php                            
                            $stmt = $pdo -> query("SELECT * FROM carrito");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<th scope='row'>";
                                echo ($row['idProducto']);
                                echo "</th><td>";                                
                                echo ($row['Nombre']);
                                echo "</td><td>";                                
                                echo ($row['Precio']);
                                echo "</td><td>";                                
                                echo '<form method="post">';
                                echo '<input type="number" value="'.$row['Cantidad'].'" class="form-group" name="cantidad">' ;                           
                                echo ('<input type="hidden" ');
                                echo ('name="idProducto" value="'.$row['idProducto'].'">'."\n");
                                echo '</td><td class="row justify-content-center">';                          
                                echo ('<input type="submit" value="Delete" name="delete" class="col-3 btn bg-warning text-center">');
                                echo ('<input type="submit" value="Update" name="update" class="col-3 offset-2 btn bg-primary text-center">');
                                echo ("\n</form>\n");
                                echo ("</td></tr>");                                
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php
                         if (isset($_SESSION['error'])){
                            echo ('<p class="bg-primary mt-2">'.$_SESSION['error'].'</p>');
                            unset($_SESSION["error"]);
                        }    
                        
                        if (isset($_SESSION['success'])){
                            echo ('<p class="bg-primary mt-2">'.$_SESSION['success'].'</p>');
                            unset($_SESSION["success"]);
                        }  
                    ?>
                    <form method="post">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn bg-primary col-sm-3 text-light" name="pay">Pagar</button>
                            <button type="submit" class="btn bg-secondary col-sm-3 offset-sm-1 text-light" name="empty">Vaciar carrito</button>
                        </div>
                    </form>
                    <?php
                        
                        
                    ?>
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