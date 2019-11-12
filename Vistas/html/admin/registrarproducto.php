<?php
    require_once "../../../Gestion/pdo.php";
    session_start();
        
    if(!isset($_SESSION['usuario'])){
        header("Location: login.php");
        return;
    }

    //Traemos todos los proveedores
    $stmt = $pdo -> query("SELECT * FROM proveedor");
    
    //Registramos el producto
    //Tabla Producto
    if(isset($_POST['select']) && isset($_POST['nombre']) 
        && isset($_POST['precio']) && isset($_POST['cantidad'])){

        $sql = "INSERT INTO producto (Nombre, Precio_Compra, Existencias)
                    VALUES (:nombre, :precio, :cantidad)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array(
            ':nombre' => $_POST['nombre'],
            ':precio' => $_POST['precio'],
            ':cantidad' => $_POST['cantidad']
        ));
        
        //-------------------------------------------------------------

        //id de proveedor
        $sqlProveedor = "SELECT * FROM proveedor WHERE Nombre = :name";
        $stmtProveedor = $pdo -> prepare($sqlProveedor);
        $stmtProveedor -> execute(array(
            ':name' => $_POST['select']
        ));

        $proveedor = $stmtProveedor -> fetch(PDO::FETCH_ASSOC);
        $idProveedor = $proveedor['idProveedor'];

        //id de producto
        $sqlProducto = "SELECT * FROM producto WHERE Nombre = :name";
        $stmtProducto = $pdo -> prepare($sqlProducto);
        $stmtProducto -> execute(array(
            ':name' =>$_POST['nombre']
        ));

        $producto = $stmtProducto -> fetch(PDO::FETCH_ASSOC);
        $idProducto = $producto['idProducto'];
        
        //-------------------------------------------------------------

        //Llenamos la tabla derivada
        $finalsql = "INSERT INTO proveedor_producto (idProveedor, idProducto) VALUES (:proveedor, :producto)";
        $stmtFinal = $pdo -> prepare($finalsql);
        $stmtFinal -> execute(array(
            ':proveedor' => $idProveedor,
            ':producto' => $idProducto
        ));

        //--------------------------------------------------------------

        $_SESSION['success'] = 'Producto registrado exitosamente.';
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
    <title>Registrar Producto</title>
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
                          <a class="dropdown-item" href="#">Clientes</a>
                          <a class="dropdown-item" href="#">Proveedores</a>
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
                                    <label for="proveedor">Seleccione un proveedor:</label>
                                    <select class="borwser-default custom-select" name="select">
                                        <option>Seleccione una opción:</option>
                                        <?php
                                            while($proveedor = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                echo '<option value="'.$proveedor['Nombre'].'">';
                                                echo $proveedor['Nombre'];
                                                echo '</option>';
                                            }
                                        ?>
                                    </select>
                                    <!--<?php
                                        echo $idProveedor;
                                    ?>-->                                    
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="nombre">Nombre:</label>
                                    <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre del Producto">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="precio">Precio de Compra (unidad):</label>
                                    <input name="precio" type="number" class="form-control" id="precio" min="0" placeholder="Ingrese el precio unitario de compra">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="cantidad">Cantidad:</label>
                                    <input name="cantidad" type="number" class="form-control" id="cantidad" min="0" placeholder="Ingrese la cantidad">
                                </div>
                            </div>                                                   

                            <div>
                                <button type="submit" class="btn btn-primary ml-1">Registrar</button>
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