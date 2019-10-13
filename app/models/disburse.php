<?php
    require 'db/connection.php';
    require 'app/services/sbig-api.php';

    class Disburse {
        function __construct() {
            $this->connection = Connection::getInstance();
        }

        function create($params) {
            echo "[INFO] submitting data to API ...\n";
            $api = new SBigAPI();
            $api_result = json_decode($api->disburse_create($params), true);

            if (strtotime($api_result['time_served']) < 0) {
                unset($api_result['time_served']);
            }

            return $this->save_data($api_result);
        }

        function find($id, $get_update = true) {
            $sql = "SELECT * FROM disburses WHERE id = :id";

            $statement = $this->connection->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_STR);
            $statement->execute();

            $result = $statement->fetch();

            if ($result['status'] != 'SUCCESS' && $get_update) {
                $result = $this->update_from_api($result['id']);
            }

            return $result;
        }

        private function update_from_api($id) {
            echo "[INFO] updating data from API ...\n";
            $api = new SBigAPI();
            $api_result = json_decode($api->disburse_detail($id), true);

            if ($api_result['status'] == 'SUCCESS') {
                // only update status, receipt and time served value
                $selected_attributes = array_flip(array('id', 'status', 'receipt', 'time_served'));
                $params = array_intersect_key($api_result, $selected_attributes);

                return $this->update_data($params);
            } else {
                return $this->find($id, false);
            }
        }

        private function save_data($disburse) {
            $sql = sprintf(
                "INSERT INTO disburses (%s) values (%s)",
                implode(", ", array_keys($disburse)),
                ':'. implode(", :", array_keys($disburse))
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($disburse);

            return $this->find($disburse['id'], false);
        }

        private function update_data($disburse) {
            foreach($disburse as $key => $value) {
                $columns[] = $key .' = :'. $key;
            }

            $sql = sprintf(
                "UPDATE disburses SET %s, updated_at = CURRENT_TIMESTAMP WHERE id = :id",
                implode(", ", array_values($columns))
            );

            $statement = $this->connection->prepare($sql);
            $statement->execute($disburse);

            return $this->find($disburse['id'], false);
        }
    }
?>
