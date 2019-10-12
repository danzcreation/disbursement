<?php
    require 'db/connection.php';

    class Disburse {
        function __construct() {
            $this->connection = Connection::getInstance();
        }

        function all() {
            $statement = $this->connection->prepare('SELECT * FROM `disburses`');
            $statement->execute();
            return $statement->fetchAll();
        }

        function find($id) {
            $sql = "SELECT * FROM disburses WHERE id = :id";

            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->execute();

            return $statement->fetch();
        }
    }
?>
