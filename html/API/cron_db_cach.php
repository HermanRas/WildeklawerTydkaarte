<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	
	function sqlQuery($sql,$args){
			    $host = 'localhost';
				$db   = 'wildefgf_WildeKlawerTydkaarte';
				$user = 'wildefgf_root';
				$pass = 'C%QvVKcjh?w2';
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
				 throw new \PDOException($e->getMessage(), (int)$e->getCode());
				 echo 'DB_CONNECTION ERROR !';
			}
				
			try {
				$stmt = $pdo->prepare($sql);
				$stmt->execute($args);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$results = $stmt->fetchAll();
			$count = $stmt->rowCount();
			return [$results, $count];
		}
	
	function sqlQueryEmulate($sql,$args){
			    $host = 'localhost';
				$db   = 'wildefgf_WildeKlawerTydkaarte';
				$user = 'wildefgf_root';
				$pass = 'C%QvVKcjh?w2';
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
				 throw new \PDOException($e->getMessage(), (int)$e->getCode());
				 echo 'DB_CONNECTION ERROR !';
			}
			
			try {
				$stmt = $pdo->prepare($sql);
				$stmt->execute($args);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			$results = $stmt->fetchAll();
			$count = $stmt->rowCount();
			return [$results, $count];
		}

    // Create Views as Tmp Tables
    echo date("l jS \of F Y h:i:s A")." STARTING: Creating tmp_tables if required \n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Creating t_vshifttotal_temp if required \n\r";
    $sql = "CREATE TABLE IF NOT EXISTS t_vshifttotal_temp(
        `TimeWorked`  time,
        `Date`  date,
        `naam`  VARCHAR(254),
        `van`  VARCHAR(254),
        `CN`  VARCHAR(254),
        `managerNaam`  VARCHAR(254),
        `managerVan`  VARCHAR(254));";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Created t_vshifttotal_temp if required \n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Creating t_vworktimecalc_temp if required \n\r";
    $sql = "CREATE TABLE IF NOT EXISTS t_vworktimecalc_temp(
        `MinutesOnClock` time,
        `inDate`  date,
        `inTime`  time,
        `outDate`  date,
        `outTime`  time,
        `naam`  VARCHAR(254),
        `van`  VARCHAR(254),
        `CN`  VARCHAR(254),
        `managerNaam`  VARCHAR(254),
        `managerVan`  VARCHAR(254),
        `plaasNaam`  VARCHAR(254),
        `spilpuntNaam`  VARCHAR(254),
        `gewas`  VARCHAR(254),
        `taakNaam`  VARCHAR(254));";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Created t_vworktimecalc_temp if required \n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Creating t_vshifttotal if required \n\r";
    $sql = "CREATE TABLE IF NOT EXISTS t_vshifttotal(
        `TimeWorked`  time,
        `Date`  date,
        `naam`  VARCHAR(254),
        `van`  VARCHAR(254),
        `CN`  VARCHAR(254),
        `managerNaam`  VARCHAR(254),
        `managerVan`  VARCHAR(254));";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Created t_vshifttotal if required \n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Creating t_vworktimecalc if required \n\r";
    $sql = "CREATE TABLE IF NOT EXISTS t_vworktimecalc(
        `MinutesOnClock` time,
        `inDate`  date,
        `inTime`  time,
        `outDate`  date,
        `outTime`  time,
        `naam`  VARCHAR(254),
        `van`  VARCHAR(254),
        `CN`  VARCHAR(254),
        `managerNaam`  VARCHAR(254),
        `managerVan`  VARCHAR(254),
        `plaasNaam`  VARCHAR(254),
        `spilpuntNaam`  VARCHAR(254),
        `gewas`  VARCHAR(254),
        `taakNaam`  VARCHAR(254));";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Created t_vworktimecalc if required \n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Creating tmp_tables \n\r";

    // Clearing old data from tmp
    echo date("l jS \of F Y h:i:s A")." STARTING: Clean old data from tmp_tables\n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vshifttotal_temp\n\r";
    $sql = "TRUNCATE TABLE t_vshifttotal_temp;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vshifttotal_temp\n\r";

    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vworktimecalc_temp\n\r";
    $sql = "TRUNCATE TABLE t_vworktimecalc_temp;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vworktimecalc_temp\n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Clean old data from tmp_tables\n\r";

    // Copy new data to tmp
    echo date("l jS \of F Y h:i:s A")." STARTING: Copy new data to tmp_tables\n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Coping new data to t_vshifttotal\n\r";
    $sql = "INSERT INTO t_vshifttotal_temp
            SELECT * FROM vshifttotal;";
    $sqlargs = array();
    $result = sqlQueryEmulate($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Copied new data to t_vshifttotal\n\r";

    echo date("l jS \of F Y h:i:s A")." UPDATE: Coping new data to t_vworktimecalc\n\r";
    $sql = "INSERT INTO t_vworktimecalc_temp
            SELECT * FROM vworktimecalc;";
    $sqlargs = array();
    $result = sqlQueryEmulate($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Copied new data to t_vworktimecalc\n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Copy new data to tmp_tables\n\r";

    // Clearing old data
    echo date("l jS \of F Y h:i:s A")." STARTING: Clean old data from tmp_tables\n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vshifttotal\n\r";
    $sql = "TRUNCATE TABLE t_vshifttotal;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vshifttotal\n\r";

    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vworktimecalc\n\r";
    $sql = "TRUNCATE TABLE t_vworktimecalc;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vworktimecalc\n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Clean old data from tmp_tables\n\r";

    // Copy new data
    echo date("l jS \of F Y h:i:s A")." STARTING: Copy new data to tmp_tables\n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Coping new data to t_vshifttotal\n\r";
    $sql = "INSERT INTO t_vshifttotal
            SELECT * FROM t_vshifttotal_temp;";
    $sqlargs = array();
    $result = sqlQueryEmulate($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Copied new data to t_vshifttotal\n\r";

    echo date("l jS \of F Y h:i:s A")." UPDATE: Coping new data to t_vworktimecalc\n\r";
    $sql = "INSERT INTO t_vworktimecalc
            SELECT * FROM t_vworktimecalc_temp;";
    $sqlargs = array();
    $result = sqlQueryEmulate($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Copied new data to t_vworktimecalc\n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Copy new data to tmp_tables\n\r";
    
    // Clearing old data from tmp
    echo date("l jS \of F Y h:i:s A")." STARTING: Clean old data from tmp_tables\n\r";
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vshifttotal_temp\n\r";
    $sql = "TRUNCATE TABLE t_vshifttotal_temp;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vshifttotal_temp\n\r";

    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaning t_vworktimecalc_temp\n\r";
    $sql = "TRUNCATE TABLE t_vworktimecalc_temp;";
    $sqlargs = array();
    $result = sqlQuery($sql, $sqlargs);
    echo date("l jS \of F Y h:i:s A")." UPDATE: Cleaned t_vworktimecalc_temp\n\r";
    echo date("l jS \of F Y h:i:s A")." DONE: Clean old data from tmp_tables\n\r";