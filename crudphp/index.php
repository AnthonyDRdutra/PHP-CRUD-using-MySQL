<?php
include "Include\CRUD_logic.php";
$list = new \Include\CRUD_logic();
?>


<h1>Listagem de Usuários</h1>
<table border ='1'>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ações</th>
    </tr>
    <?php foreach($list->Read_list() as $usuario):?>
        <tr>
            <td><?=$usuario['id'];?></td>
            <td><?=$usuario['nome'];?></td>
            <td><?=$usuario['email'];?></td>
            <td>
                <a href="Include/Update.php?id=<?=$usuario['id'];?>">[Editar]</a>
                <a href="Include/Delete.php?id=<?=$usuario['id'];?>">[Excluir]</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="Include/clientsignupUI.php">Cadastrar Usuário</a>
