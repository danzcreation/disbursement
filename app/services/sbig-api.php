<?php
    class SBigAPI {
        function __construct() {}

        function disburse_create($payload) {
            return self::perform_request('POST', 'disburse', $payload);
        }

        function disburse_detail($id) {
            return self::perform_request('GET', 'disburse/'. $id);
        }

        private static function perform_request($method, $path, $data = false) {
            $configs = parse_ini_file($_SERVER['PWD'] .'/config/application.ini');
            $url = $configs['api_url_base'] ."/$path";
            $curl = curl_init();

            switch ($method)
            {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);

                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                default:
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }

            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, $configs['api_key_secret'] .':');

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);

            curl_close($curl);

            return $result;
        }
    }
?>
