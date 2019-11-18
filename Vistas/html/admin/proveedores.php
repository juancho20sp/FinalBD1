<?php
  require_once "../../../Gestion/pdo.php";
  session_start();  
  

  if(! isset($_SESSION['usuario'])){
    header("Location: login.php");
    return;
}

//Eliminar Proveedor
    if(isset($_POST['deleteProvider']) && isset($_POST['idProveedor'])){
        $sql = "DELETE FROM proveedor WHERE idProveedor = :zip";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':zip' => $_POST['idProveedor']
        ));

        $_SESSION['success'] = "Proveedor eliminado correctamente.";
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
    <link rel="stylesheet" href="css/providerStyle.css">
    <title>Proveedores</title>
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
            <a href="index.php" class="nav-link">Mi tiendita</a>
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
        <div class="table-container">
            <table class="table table-striped">
                <thead class="thead-dark">
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