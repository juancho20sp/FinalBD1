<?php    
    require_once "../../../Gestion/loginValidation.php";  
    session_start();

    var_dump($_SESSION['usuario']);

     //Delete method
    if(isset($_POST['delete']) && isset($_POST['idProducto'])){
        $sql = "DELETE FROM carrito WHERE idProducto = :zip";
      
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':zip' => $_POST['idProducto']
        )); 

        $_SESSION['success'] = 'Producto eliminado correctamente';
    }

    //Transacción Final

    //Montamos la fecha actual
    $date = date('Y-m-d H:i:s');

    //Treaemos el id del usuario
    $idCliente = $pdo -> prepare("SELECT * FROM usuarios WHERE Username = :user");
    $idCliente -> execute(array(
        ':user' => $_SESSION['usuario']
    ));
    $fila = $idCliente -> fetch(PDO::FETCH_ASSOC);
    $idCliente = $fila['idUsuarios'];

    //----------------------
    echo "ID CLIENTE: {$idCliente}";

    if(isset($_POST['pay'])){
        echo "PAGANDO!";

        //Llenamos la tabla venta

        $sql = "INSERT INTO venta (idCliente) VALUES (:idCliente)";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array(
            ':idCliente' => $idCliente 
        ));

        //Traemos el ID de la venta

        $idVenta = $pdo -> query("SELECT idVenta FROM venta ORDER BY idVenta DESC LIMIT 1");
        $rowId = $idVenta -> fetch(PDO::FETCH_ASSOC);
        $idVenta = $rowId['idVenta'];

        //Traemos los datos necesarios para llenar venta_producto

        $stmt2 = $pdo -> query("SELECT * FROM carrito");
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
            //Llenamos la tabla venta_producto
            echo "ID PRODUCTO {$row['idProducto']}";


            $sql3 = "INSERT INTO venta_producto VALUES (:idVenta, :idProducto,
                        :cantidad, :precio, :fecha)";
            $stmt3 = $pdo -> prepare($sql3);
            $stmt3 -> execute(array(
                ':idVenta' => $idVenta,
                ':idProducto' => $row['idProducto'],
                ':cantidad' => $row['Cantidad'],
                ':precio' => $row['Precio'],
                ':fecha' => $date
            ));

            //Llenamos la tabla cliente_producto
            $sql4 = "INSERT INTO cliente_producto (idProducto, idCliente)
                        VALUES (:idProducto, :idCliente)";
            $stmt4 = $pdo -> prepare($sql4);
            $stmt4 -> execute(array(
                ':idProducto' => $row['idProducto'],
                ':idCliente' => $idCliente
            ));

            //Traemos las existencias actuales
            $existenciasPasadas = $pdo -> query("SELECT Existencias FROM producto WHERE idProducto = {$row['idProducto']}");
            $rowEx = $existenciasPasadas -> fetch(PDO::FETCH_ASSOC);
            $existencias = $rowEx['Existencias'];

            echo "Existencias {$existencias}";
            //---------------------------------------

            //Modificamos existencias en producto
            $sql5 = "UPDATE producto SET Existencias = :existencias
                        WHERE idProducto = :idProducto";
            $stmt5 = $pdo -> prepare($sql5);
            $stmt5 -> execute(array(
                ":existencias" => ($existencias - $row['Cantidad']) ,
                ":idProducto" => $row['idProducto']
            ));
        }

        $_SESSION['success'] = "Compra realizada!";
        $sqlDelete = "DELETE FROM carrito";
        $stmtDelete = $pdo -> query($sqlDelete);
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
    <title>Checkout</title>
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
            <a href="index.php" class="nav-link">La Tienda</a>
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
                            <h3 class="m-3">Factura</h3>
                            <?php
                                if (isset($_SESSION['success'])){
                                    echo ('<p class="bg-primary mt-2">'.$_SESSION['success'].'</p>');
                                    unset($_SESSION["success"]);
                                }  
                            ?>
                        </div>
                        <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php   
                        $_COOKIE['pFinal'] = 0;                         
                            $stmt = $pdo -> query("SELECT * FROM carrito");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<th scope='row'>";
                                echo ($row['Nombre']);
                                echo "</th><td>";                                
                                echo ($row['Precio']);
                                echo "</td><td>";                                
                                echo ($row['Cantidad']);
                                echo "</td><td>"; 
                                echo "$".($row['Cantidad'] * $row['Precio']);   
                                $_COOKIE['pFinal'] += $row['Cantidad'] * $row['Precio'];                            
                                echo '<form method="post">';                           
                                echo ('<input type="hidden" ');
                                echo ('name="idProducto" value="'.$row['idProducto'].'">'."\n");
                                echo '</td><td class="">';                          
                                echo ('<input type="submit" value="Delete" name="delete" class="btn bg-danger text-center text-light">');
                                echo ("\n</form>\n");
                                echo ("</td></tr>");                                
                            }
                        ?>
                        </tbody>
                    </table>
                    <?php                         
                        if (isset($_SESSION['success'])){
                            echo ('<p class="bg-primary mt-2">'.$_SESSION['success'].'</p>');
                            unset($_SESSION["success"]);
                        }  
                    ?>
                    <div class="text-center">
                        <h4>Total a pagar:</h4>
                        <p><b>$<?=$_COOKIE['pFinal']?></b></p>
                    </div>
                    <form method="post">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn bg-primary col-sm-3 text-light" name="pay">Pagar</button>
                            <button type="submit" class="btn bg-secondary col-sm-3 offset-sm-1 text-light" name="empty">Vaciar carrito</button>
                        </div>
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