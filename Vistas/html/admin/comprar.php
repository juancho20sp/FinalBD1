<?php
    require_once "../../../Gestion/pdo.php";
    session_start();
        
    if(!isset($_SESSION['usuario'])){
        header("Location: login.php");
        return;
    }

    //Traemos los productos
        $stmt = $pdo -> query("SELECT * FROM producto");

    //Capturamos el ID del producto seleccionado
    if(isset($_POST['productoSelect']) && isset($_POST['rellenar'])){
        $sqlProducto = "SELECT * FROM producto WHERE Nombre = :nombre";
        $stmtProducto = $pdo -> prepare($sqlProducto);
        $stmtProducto -> execute(array(
            ":nombre" => $_POST['productoSelect']
        ));

        $producto = $stmtProducto -> fetch(PDO::FETCH_ASSOC);
        $idProducto = $producto['idProducto'];

        $_SESSION['nombreProducto'] = $_POST['productoSelect'];
        $_SESSION['precioProducto'] = $producto['Precio_Compra'];
        $_SESSION['idProducto'] = $idProducto;
    }

    //Dejamos los datos finales en la sesión para la factura
    if(isset($_POST['precio']) && isset($_POST['pagar']) && ($_POST['cantidad'] != 0)){
        $_SESSION['cantidadProducto'] = $_POST['cantidad'];
        header("Location: payment.php");
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
    <link rel="stylesheet" href="../admin/css/generateStyle.css">
    <title>Comprar</title>
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
               <div class="col-md-8">
                    <div class="main bg-light">
                        <form method="post" class="field">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="proveedor">Seleccione un Producto:</label>
                                    <select class="browser-default custom-select" name="productoSelect">
                                        <option>Seleccione una opción:</option>
                                        <?php                                            
                                            while($producto = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                echo '<option value="'.$producto['Nombre'].'">';
                                                echo $producto['Nombre'];
                                                echo '</option>';
                                            }
                                        ?>
                                    </select>
                                    <?php
                                        if(isset($_SESSION['nombreProducto'])){
                                            echo $_SESSION['nombreProducto'];
                                        }
                                    ?>                                   
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="cantidad">Cantidad:</label>
                                    <input name="cantidad" type="number" class="form-control" id="cantidad" min="0" placeholder="Ingrese la cantidad">
                                </div>
                            </div>
                            <div class="row offset-sm-2">
                                <button type="submit" class="btn bg-primary text-light" name="rellenar" id="link">Rellenar campos</button>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="precio">Precio de Compra (unidad):</label>
                                    <input name="precio" type="number" class="form-control" id="precio" min="0" value="<?= $_SESSION['precioProducto']?>" readonly>
                                </div>
                                
                            </div>                                                   

                            <div>
                                <button type="submit" class="btn btn-primary ml-1" name="pagar">Generar factura</button>
                                <button type="reset" class="btn btn-secondary">Cancelar</button>
                                <a href="menu.php">Volver</a>
                            </div>
                        </form>
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