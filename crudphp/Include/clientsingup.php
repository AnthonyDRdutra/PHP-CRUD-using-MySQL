<?php
include "CRUD_logic.php";


$input_name = filter_input(INPUT_POST, 'nome');
$input_email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);

$logic_process = new \Include\CRUD_logic();
$logic_process -> Create_client($input_name, $input_email);





