<?php
include "CRUD_logic.php";
//this is the intermediate code that will get the data inputed on URL page
//and process it using our class 'CRUD_logic.php' and function 'Create_client'

$input_name = filter_input(INPUT_POST, 'nome');
//we validate the email to be sure of it structure 
$input_email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);

//we call our class
$logic_process = new \Include\CRUD_logic();
//our function an its inputs
$logic_process -> Create_client($input_name, $input_email);





