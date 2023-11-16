# PHP_CRUD_using_MySQL
Simple CRUD setup for MySQL , Object Oriented and using PDO

<h3 align="left">Tecnologies:</h3>
<p align="left"> <a href="https://www.mysql.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="60" height="60"/> </a> <a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="60" height="60"/> </a> </p>

  This is an basic CRUD (create, read, update, and delete) program, for studing porpuses, in a intentent to be modular and simple. 
  
  This code is able to post data, create, delete, and modify data on the database, with the follwing structure `GUI -> Process code CALL function inside CRUD_logic -> output`

 <h3 align="left">How to setup:</h3

You need to create and database on MySQL and Use MySQL workbench to create a new table for this project, i defined in our main class this string and constant:
````
 class CRUD_logic
  {

    private string $pdo_setup = ("mysql:dbname=sqlcrud;host=localhost:3306");

    private const login = [
        'default_username' => "root",
        'default_password' => "1234"
        ];
````
Wich i will use as default setup in all PDOS, example:
```
$pdo  = new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);
```

<h3 align="left">Posting, reading, editing and excluding data:</h3

Using PDO most of our processe will be done using `input_filter`, `query`, `rowCount`, `prepare` and others. (PDO documentation: https://www.php.net/manual/en/book.pdo.php)

Example Using the `Create_client()` function:
```
 public function Create_client($input_name, $input_email): void
```
````
//if the inputs are approved
        if ($input_name && $input_email) {

            //pdo setup
            $pdo = new PDO($this->pdo_setup,self::login['default_username'],self::login['default_password']);

            //find if already exist any data with the same values
            $sql = $pdo -> prepare("SELECT * FROM usuario WHERE (nome, email) = (:nome , :email)");
            $sql -> bindValue(':email', $input_email);
            $sql -> bindValue(':nome', $input_name);
            $sql -> execute();

//check if  exist any equal data already there
            if($sql -> rowCount() === 0) {
                //post data to the sql on the defined postfields ( nome , email )
                $sql = $pdo->prepare("INSERT INTO usuario(nome, email) VALUES (:nome, :email)");
                $sql -> bindValue(':nome', $input_name);
                $sql -> bindValue(':email', $input_email);
                $sql -> execute();

                //and we sent the user to the index again
                header("Location: http://localhost/crudphp/");
            }else{
                //if it has any equal data,return the user to the sign up page
                header("Location: http://localhost/crudphp/forms/cadastrousuario/clientsignupUI.php");
            }
````
As for input processing, data post or update, we use scripts on the middle of this process like on `Update.php`:
```
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
```
our current code read 4 elements on the row, and edit for, if you want more you just need to make some tweaks, making sure that the data names are the same as in data base, for example on the `Read_list()` function and the `index.php`.
Original, just add a new field, on the headers:
```
<h1>Listagem de Usuários</h1>
<table border ='1'>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>NEWFIELD</th>
        <th>Ações</th>
    </tr>
```
```
<?php foreach($list->Read_list() as $usuario):?>
        <tr>
            <td><?=$usuario['id'];?></td>
            <td><?=$usuario['nome'];?></td>
            <td><?=$usuario['email'];?></td>
            <td><?=$usuario['NEWFIELD'];?></td>
            <td>
                <a href="Include/Update.php?id=<?=$usuario['id'];?>">[Editar]</a>
                <a href="Include/Delete.php?id=<?=$usuario['id'];?>">[Excluir]</a>
            </td>
        </tr>
    <?php endforeach; ?>
```
before
![sample 2](https://github.com/AnthonyDRdutra/PHP-CRUD-using-MySQL/assets/97138694/9b2b959c-0f2a-40d9-ae91-576f9f38d4a4)

after
![sample](https://github.com/AnthonyDRdutra/PHP-CRUD-using-MySQL/assets/97138694/9b18511b-e9aa-45ad-9287-37d37e4168d4)
(dont mind the bugged position, i forgot to put in the correct order).

If your new field name, correspond to any one in the database, it will work just fine.  



