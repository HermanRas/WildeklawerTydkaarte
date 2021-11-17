<?php
    $host = 'localhost';
    $db   = 'wildeklawer_tk';
    $user = 'wkadmin';
    $pass = 'Wk@dmin1';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => true,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        //throw new \PDOException($e->getMessage(), (int)$e->getCode());
        //echo 'DB_CONNECTION ERROR !';
    }
?>