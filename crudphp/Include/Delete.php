<?php
include "CRUD_logic.php";

$delete = new \Include\CRUD_logic();
$id = filter_input(INPUT_GET, 'id');
$delete ->Delete_client($id);