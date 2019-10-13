# Disbursement Service

Requires PHP with cURL plugin to run, also MySQL to store data.

This disbursement service will send the disbursement data to the 3rd party API and save the detailed data about the disbursement into database, this service also have capability to check disbursement status and update the information

### Installation

1. Change configuration file on **config/application.ini** to match your database and API credentials

1. Run database and table migration `php migration.php`

### Usage

Run index file to start `php index.php`

- Show Disbursion

  requires **transaction id** input to update/view latest disbursion request status and detail (will get update from 3rd party API until disbursion status succeeded)
 
- Submit Disbursion

  create new disbursion request with **bank code**, **account number**, **amount** and **remark** input
