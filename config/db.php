<?php
    $host = '127.0.0.1';
    $db   = 'WildeKlawerTydkaarte';
    $user = 'root';
    $pass = 'root00--';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        http_response_code(500);
        // throw new \PDOException($e->getMessage(), (int)$e->getCode());
        // echo 'DB_CONNECTION ERROR !';
    }
?>