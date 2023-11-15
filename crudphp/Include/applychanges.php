<?php
include "CRUD_logic.php";
//we call our classes
$update = new \Include\CRUD_logic();
$apply = new \Include\CRUD_logic();

//got our inputs
$id = filter_input(INPUT_POST, 'id');
$input_name = filter_input(INPUT_POST, 'nome');
$input_email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);

//we sent our inputs to their functions
$update->Update_client($id);
$apply ->apply_changes($id,$input_name,$input_email);
