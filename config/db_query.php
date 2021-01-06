<?php 
function sqlQuery($sql,$args){
        require("config/db.php");
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($args);
        } catch (PDOException $e) {
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
            // echo $e->getMessage();
        }
        $results = $stmt->fetchAll();
        $count = $stmt->rowCount();
        return [$results, $count];
    }

?>