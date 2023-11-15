<?php

namespace Include;

use http\Params;
use PDO;

class CRUD_logic
{
    private string $pdo_setup = ("mysql:dbname=sqlcrud;host=localhost:3306");

    private const login = [
        'default_username' => "root",
        'default_password' => "1234"
        ];

    public function Read_list (): array
    {
        $listArray = [];

        //pdo setup
        $pdo  = new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);

        //declare that i want the list of elements
        $sql = $pdo -> query("SELECT * FROM usuario");

        //check if there are more than 0 rows
        if ($sql -> rowCount() > 0){
            $listArray = $sql -> fetchAll(PDO::FETCH_ASSOC);
        }
        return $listArray;
    }

    public function apply_changes($id, $input_name, $input_email): void
    {
//        $this ->Update_client($id);

        if ($id && $input_name && $input_email){

            $pdo  = new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);

            $sql = $pdo->prepare("UPDATE usuario SET nome  = :nome,  email = :email WHERE id = :id");

            $sql -> bindValue(':id', $id);
            $sql -> bindValue(':nome', $input_name);
            $sql -> bindValue(':email', $input_email);

            $sql -> execute();
            header("Location: http://localhost/crudphp/");
        }

    }

    public function Create_client($input_name, $input_email): void
    {
        //if the inputs are approved
        if ($input_name && $input_email) {

            //pdo setup
            $pdo = new PDO($this->pdo_setup,self::login['default_username'],self::login['default_password']);

            //find if already exist any data with the same values
            $sql = $pdo -> prepare("SELECT * FROM usuario WHERE (nome, email) = (:nome , :email)");
            $sql -> bindValue(':email', $input_email);
            $sql -> bindValue(':nome', $input_name);
            $sql -> execute();

            //check if
            if($sql -> rowCount() === 0) {
                //post data to the sql on the defined postfields ( nome , email )
                $sql = $pdo->prepare("INSERT INTO usuario(nome, email) VALUES (:nome, :email)");
                $sql -> bindValue(':nome', $input_name);
                $sql -> bindValue(':email', $input_email);
                $sql -> execute();

                header("Location: http://localhost/crudphp/");
            }else{
                //if it has any
                header("Location: http://localhost/crudphp/forms/cadastrousuario/clientsignupUI.php");
            }

        }else{
            //else, return it to client sign up page
            header("Location: http://localhost/crudphp/forms/cadastrousuario/clientsignupUI.php");
        }
    }

    public function Update_client($id): array
    {
        // pdo setup
        $pdo = new PDO($this->pdo_setup, self::login['default_username'], self::login['default_password']);

        $usuario = [];

        // declare that I want the list of elements
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE id = :id ");
        $sql->bindValue(':id', $id);
        $sql->execute();

        // Check if a user was found
        if ($sql->rowCount() > 0) {
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $usuario;
    }

    public function Delete_client ($id): void {
        if ($id){
            $pdo = new PDO($this->pdo_setup,self::login['default_username'],self::login['default_password']);
            $sql = $pdo ->prepare("DELETE FROM usuario WHERE id = :id");
            $sql -> bindValue(':id', $id);
            $sql -> execute();
        }
        header("Location: http://localhost/crudphp/");
    }
}