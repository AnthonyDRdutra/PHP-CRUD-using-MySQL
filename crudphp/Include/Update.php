<?php
include "CRUD_logic.php";

$update = new \Include\CRUD_logic();

$id = filter_input(INPUT_GET, 'id');

//we declare usuario as an variable to be read as an array
//if we dont do it, update will be read as a boolean 
$usuario = $update->Update_client($id);

//thats our graphic interface
?>

<h1>Editar Usuário</h1>
<form method="post" action="applychanges.php">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?? ''; ?>"/>
    <label>
        Nome: <input type="text" name="nome" value="<?= $usuario['nome'] ?? ''; ?>"/>
    </label>
    <label>
        E-mail: <input type="email" name="email" value="<?= $usuario['email'] ?? ''; ?>"/>
    </label>
    <input type="submit" value="Atualizar"/>
</form>
