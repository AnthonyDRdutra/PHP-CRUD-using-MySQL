<?php
include "CRUD_logic.php";

$update = new \Include\CRUD_logic();

$id = filter_input(INPUT_GET, 'id');
$usuario = $update->Update_client($id);

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