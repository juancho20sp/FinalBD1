<?php
    $pdo = new PDO('mysql:host=127.0.0.1:3406;port=80;dbname=test',
                    'root', 'admin');
    
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>