<?php
    $configs = parse_ini_file($_SERVER['PWD'] .'/config/application.ini');

    try {
        $db_name = $configs['db_name'];
        $connection = new PDO('mysql:host='. $configs['db_hostname'], $configs['db_username'], $configs['db_password']);
        $sql =
<<<EOT
    CREATE DATABASE IF NOT EXISTS `$db_name` ;
    USE `$db_name`;
    
    CREATE TABLE IF NOT EXISTS `disburses` (
        `id` BIGINT(20) NOT NULL PRIMARY KEY,
        `bank_code` CHAR(50) DEFAULT NULL,
        `account_number` CHAR(50) DEFAULT NULL,
        `amount` INT(11) DEFAULT NULL,
        `fee` INT(11) DEFAULT NULL,
        `beneficiary_name` CHAR(50) DEFAULT NULL,
        `status` CHAR(50) DEFAULT NULL,
        `receipt` VARCHAR(255) DEFAULT NULL,
        `remark` VARCHAR(255) DEFAULT NULL,
        `timestamp` DATETIME DEFAULT NULL,
        `time_served` DATETIME DEFAULT NULL,
        `created_at` DATETIME DEFAULT NULL,
        `updated_at` DATETIME DEFAULT NULL
    );        
EOT;
        $connection->exec($sql);
      
        echo "[INFO] database and table created successfully";
    } catch(PDOException $error) {
        echo $sql ."\n". $error->getMessage();
    }
?>
