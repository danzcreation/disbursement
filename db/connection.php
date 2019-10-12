<?php
    class Connection {
        private static $instance = NULL;

        private function __construct() {}

        public static function getInstance() {
            if (!isset(self::$instance)) {
                $configs = parse_ini_file($_SERVER['PWD'] .'/config/application.ini');
                $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            
                try {
                    self::$instance = new PDO(
                        'mysql:host='. $configs['db_hostname'] .';dbname='. $configs['db_name'],
                        $configs['db_username'],
                        $configs['db_password'],
                        $options
                    );
                }
                catch (PDOException $error) {
                    exit("[ERROR] Can't connect to database\n". $error->getMessage());
                }
            }

            return self::$instance;
        }
    }
?>
