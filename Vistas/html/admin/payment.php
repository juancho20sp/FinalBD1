<?php
    require_once "../../../Gestion/pdo.php";
    session_start();
        
    if(!isset($_SESSION['usuario'])){
        header("Location: login.php");
        return;
    }

    //Recalculamos el precio en caso de modificaciones
    if(isset($_POST['calcular'])){
        $_SESSION['cantidadProducto'] = $_POST['cantidad'];
    }

    //Montamos la fecha actual
    $date = date('Y-m-d H:i:s');


    //Traemos el proveedor del producto
        $sqlProveedor = "SELECT proveedor.idProveedor
                    FROM ((proveedor
                    INNER JOIN proveedor_producto
                    ON proveedor.idProveedor = proveedor_producto.idProveedor)
                    INNER JOIN producto
                    ON producto.idProducto = proveedor_producto.idProducto)
                    WHERE producto.idProducto = :idProducto";

        $stmtProveedor = $pdo -> prepare($sqlProveedor);
        $stmtProveedor -> execute(array(
            ":idProducto" => $_SESSION['idProducto']
        ));

        $proveedor = $stmtProveedor -> fetch(PDO::FETCH_ASSOC);
        $proveedor = $proveedor['idProveedor'];
    //--------------------------------------

    if(isset($_POST['pagar'])){
       //Llenamos la tabla compra

        $sql = "INSERT INTO compra (Proveedor, Producto, Fecha) 
                VALUES (:proveedor, :producto, :fecha)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array(
            ':proveedor' => $proveedor,
            ':producto' => $_SESSION['idProducto'],
            ':fecha' => $date
        ));
        //-------------------------------------------

        //Traemos el id de esta compra
        $sqlId = $pdo -> query("SELECT idCompra FROM compra ORDER BY idCompra DESC LIMIT 1");
        $rowId = $sqlId -> fetch(PDO::FETCH_ASSOC);
        $idCompra = $rowId['idCompra'];
        //------------------------------------------

        //Llenamos la tabla compra_producto
        $sql2 = "INSERT INTO compra_producto (idCompra, idProducto,
                    Cantidad, Precio_Unitario) VALUES (:idCompra,
                        :idProducto, :cantidad, :precio)";

        $stmt2 = $pdo -> prepare($sql2);
        $stmt2 -> execute(array(
            ":idCompra" => $idCompra,
            ":idProducto" => $_SESSION['idProducto'],
            ":cantidad" => $_SESSION['cantidadProducto'],
            ":precio" => $_SESSION['precioProducto']
        ));
        //----------------------------------------

        //Traemos las existencias actuales
        $existenciasPasadas = $pdo -> query("SELECT Existencias FROM producto WHERE idProducto = {$_SESSION['idProducto']}");
        $rowEx = $existenciasPasadas -> fetch(PDO::FETCH_ASSOC);
        $existencias = $rowEx['Existencias'];
        //---------------------------------------

        //Modificamos existencias en producto
        $sql3 = "UPDATE producto SET Existencias = :existencias
                    WHERE idProducto = :idProducto";
        $stmt3 = $pdo -> prepare($sql3);
        $stmt3 -> execute(array(
            ":existencias" => ($existencias + $_SESSION['cantidadProducto']) ,
            ":idProducto" => $_SESSION['idProducto']
        ));

        //Unnset a los elementos de la sesión
        unset($_SESSION['idProducto']);
        unset($_SESSION['cantidadProducto']);
        unset($_SESSION['precioProducto']);
        unset($_SESSION['nombreProducto']);

        $_SESSION['success'] = "Compra exitosa";

        header("Location: menu.php");
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
    <title>Finaliza tu compra!</title>
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
                                    <label for="producto">Producto:</label>
                                    <input name="producto" class="form-control" id="producto" value="<?= $_SESSION['nombreProducto']?>" readonly>
                                </div>                                                                              
                                <div class="form-group col-sm-6">
                                    <label for="precio">Precio de Compra (unidad):</label>
                                    <input name="precio" type="number" class="form-control" id="precio" min="0" value="<?= $_SESSION['precioProducto']?>" readonly>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="cantidad">Cantidad:</label>
                                    <input name="cantidad" class="form-control" id="cantidad" value="<?= $_SESSION['cantidadProducto']?>">
                                </div>                                                                              
                                <div class="form-group col-sm-6 align-self-end">                                    
                                    <button class="btn bg-primary text-light" type="submit" name="calcular">Calcular valor</button>
                                </div>  
                            </div>
                                
                            <div id="finalPrice" class="border-top mb-4">
                                <h4>Total a pagar:</h4>
                                <p>$ <?= $_SESSION['cantidadProducto'] * $_SESSION['precioProducto']?></p>

                            </div>

                                                                                  

                            <div>
                                <button type="submit" class="btn btn-primary ml-1" name="pagar">Comprar</button>
                                <button type="reset" class="btn btn-secondary">Cancelar</button>
                                <a href="comprar.php">Volver</a>
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