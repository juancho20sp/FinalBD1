<?php
    require_once "pdo.php";

    if(isset($_POST['usuario']) && isset($_POST['password'])){
        $sql = "SELECT * FROM admins WHERE
                email = :em
                AND password = :pas";
        
        $stmt = $pdo->prepare($sql);
        $stmt -> execute(array(
            ':em' => $_POST['usuario'],
            ':pas' => $_POST['password']
        ));

        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        var_dump($row);

        if($row === FALSE){
            echo "JI ji ji ji";
            echo "<h2>Access denied</h2>";
        } else {
            echo "<h2>Welcome!</h2>";
        }
    }

?>