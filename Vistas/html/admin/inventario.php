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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../../html/user/css/productsStyle.css">
    <title>Inventario</title>
</head>
<body class="super-container">
    <!--Empieza el modal-->
    <div id="priceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" role="content">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Precio de venta</h3>
                        <button class="close" type="button" data-dismiss="modal">
                            &times;
                        </button>
                    </div>
                    <div class="modal-body">
                        <main class="container">                            
                            <div class="row">
                                <div class="tab-content col-lg-9 offset-lg-2">
                                    <div class="tab-pane fade show active" role="tabpanel" id="inicio">
                                        <form>
                                          <div class="row">
                                              <div class="form-group row">
                                                  <label for="precio">Precio de Venta:</label>
                                                  <input name="precio" type="number" class="form-control col-10" id="precio" placeholder="Ingrese el precio de venta">
                                              </div>                                                                
                                          </div>                                                           
                                          <button type="submit" class="btn btn-primary ml-1">Agregar</button>
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>                                          
                                          <?php
                                            echo $_POST['idProducto'];
                                          ?>
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
                 aria-expanded="false" aria-label="Toggle navigation" data-toggle="collapse">
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
                      <a class="nav-link" href="controlpanel.php"><i class="fas fa-cogs fa-lg"></i><span class="sr-only">(control panel)</span></a>
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
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                  <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      Productos
                    </button>
                  </h2>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <!--INSERTAR TABLA PHP-->
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Precio de Compra</th>
                                <th scope="col">Precio de venta</th>
                                <th scope="col">Existencias</th>
                                <th scope="col">Action</th>                                  
                            </tr>
                        </thead>
                        <tbody>
                        <?php                            
                            $stmt = $pdo -> query("SELECT * FROM producto");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<th scope='row'>";
                                echo ($row['idProducto']);
                                echo "</th><td>";                                
                                echo ($row['Nombre']);
                                echo "</td><td>";                                
                                echo ($row['Precio_Compra']);
                                echo "</td><td>";      
                                echo ($row['Precio_Venta']);
                                echo "</td><td>";                           
                                echo ($row['Existencias']);
                                echo "</td><td>";                                                              
                                echo ('<form method="post"><input type="hidden" ');
                                echo ('name="idProducto" value="'.$row['idProducto'].'">'."\n");
                                echo ('<a data-toggle="modal" data-target="#priceModal">'); 
                                echo ('</a>');                          
                                echo ('<input type="submit" value="Precio de venta" name="price">');
                                echo ("\n</form>\n");                                
                                echo ("</td></tr>");     
                            }
                        ?>
                        </tbody>
                    </table>
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
                  </div>
                </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Todos los usuarios
                  </button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                <!--INSERTAR TABLA PHP-->
                <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Email</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                                <th scope="col">¿Es administrador?</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php                            
                            $stmt = $pdo -> query("SELECT * FROM usuarios");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                if($row['isAdmin'] == 1){
                                  $role = "Sí";
                                } else {
                                  $role = "No";
                                }
                                echo "<tr>";
                                echo "<th scope='row'>";
                                echo ($row['idUsuarios']);
                                echo "</th><td>";                                
                                echo ($row['Nombre']);
                                echo "</td><td>";                                
                                echo ($row['Apellidos']);
                                echo "</td><td>";                                
                                echo ($row['Email']);
                                echo "</td><td>";                                
                                echo ($row['Username']);
                                echo "</td><td>";
                                echo ($row['Password']);
                                echo "</td><td>";
                                echo ($role);
                                echo "</td><td>";
                                echo ('<form method="post"><input type="hidden" ');
                                echo ('name="deleteUsuarios" value="'.$row['idUsuarios'].'">'."\n");                          
                                echo ('<input type="submit" value="Delete" name="delete">');
                                echo ("\n</form>\n");
                                echo "</td><td>";
                                echo ('<a data-toggle="modal" data-target="#updateModal">');
                                echo ('<form method="post"><input type="hidden" ');
                                echo ('name="idUsuarios" value="'.$row['idUsuarios'].'">'."\n");                          
                                echo ('<input type="submit" value="Edit" name="edit">');
                                echo ("\n</form>\n");                        
                                echo ('</a>');                                
                                echo ("</td></tr>");                                
                            }
                        ?>
                        </tbody>
                    </table>
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
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                  <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Proveedores
                  </button>
                </h2>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                   <!--INSERTAR TABLA PHP-->
                   <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php                            
                            $stmt = $pdo -> query("SELECT * FROM proveedor");
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                echo "<tr>";
                                echo "<th scope='row'>";
                                echo ($row['idProveedor']);
                                echo "</th><td>";                                
                                echo ($row['Nombre']);
                                echo "</td><td>";                             
                                echo ('<form method="post"><input type="hidden" ');
                                echo ('name="idProveedor" value="'.$row['idProveedor'].'">'."\n");                          
                                echo ('<input type="submit" value="Delete" name="deleteProvider">');
                                echo ("\n</form>\n");
                                echo ("</td></tr>");                                
                            }
                        ?>
                        </tbody>
                    </table>
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