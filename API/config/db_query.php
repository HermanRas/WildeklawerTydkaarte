<?php 
function sqlQuery($sql,$args){
        require("config/db.php");
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($args);
        } catch (PDOException $e) {
            http_response_code(500);
            // echo $e->getMessage();
        }
        $results = $stmt->fetchAll();
        $count = $stmt->rowCount();
        return [$results, $count];
    }

function sqlQueryEmulate($sql,$args){
        require("config/db_emulate.php");
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($args);
        } catch (PDOException $e) {
            http_response_code(500);
            // echo $e->getMessage();
        }
        $results = $stmt->fetchAll();
        $count = $stmt->rowCount();
        return [$results, $count];
    }

?>