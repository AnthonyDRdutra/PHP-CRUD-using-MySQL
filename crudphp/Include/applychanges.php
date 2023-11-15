<?php
include "CRUD_logic.php";

$update = new \Include\CRUD_logic();
$apply = new \Include\CRUD_logic();

$id = filter_input(INPUT_POST, 'id');
$input_name = filter_input(INPUT_POST, 'nome');
$input_email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);

$update->Update_client($id);
$apply ->apply_changes($id,$input_name,$input_email);