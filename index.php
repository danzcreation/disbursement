<?php
    require 'app/models/disburse.php';

    function main_menu() {
        echo "---------------------\n";
        echo "1 - Show Disbursion\n";
        echo "2 - Submit Disbursion\n";
        echo "0 - Quit\n\n";
        echo "Enter your choice: ";
    }

    function show_disburse() {
        echo "Please enter transaction ID: ";
        $id = trim(fgets(STDIN));

        $disburse = new Disburse();
        $result = $disburse->find($id);

        disburse_presenter($result);
    }

    function create_disburse() {
        $input_values = array();

        echo "Please enter bank code: ";
        $input_values['bank_code'] = trim(fgets(STDIN));

        echo "Please enter account number: ";
        $input_values['account_number'] = trim(fgets(STDIN));

        echo "Please enter amount: ";
        $input_values['amount'] = trim(fgets(STDIN));

        echo "Please enter remark: ";
        $input_values['remark'] = trim(fgets(STDIN));

        $disburse = new Disburse();
        $result = $disburse->create($input_values);

        disburse_presenter($result);
    }

    function disburse_presenter($disburse) {
        echo "---------------------\n";
        echo('ID               : '. $disburse['id'] ."\n");
        echo('Bank Code        : '. $disburse['bank_code'] ."\n");
        echo('Account Number   : '. $disburse['account_number'] ."\n");
        echo('Amount           : '. $disburse['amount'] ."\n");
        echo('Fee              : '. $disburse['fee'] ."\n");
        echo('Beneficiary Name : '. $disburse['beneficiary_name'] ."\n");
        echo('Status           : '. $disburse['status'] ."\n");
        echo('Receipt          : '. $disburse['receipt'] ."\n");
        echo('Remark           : '. $disburse['remark'] ."\n");
        echo('Timestamp        : '. $disburse['timestamp'] ."\n");
        echo('Time Served      : '. $disburse['time_served'] ."\n");
        echo('Created At       : '. $disburse['created_at'] ."\n");
        echo('Updated At       : '. $disburse['updated_at'] ."\n");
    }


    echo "[Disbursion Service]\n";
    do {
        // Print the menu on console
        main_menu();

        // Read user choice
        $choice = trim(fgets(STDIN));

        // Act based on user choice
        switch($choice) {
        
            case 1: {
                show_disburse();
                break;
            }
            case 2: {
                create_disburse();
                break;
            }
            case 0: {
                break;
            }
            default: {
                echo "\n\nPlease provide a valid choice\n";
            }
        }
    } while ($choice != 0);

    exit(0);
?>
