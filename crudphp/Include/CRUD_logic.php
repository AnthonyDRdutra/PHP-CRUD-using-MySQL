<?php

namespace Include;

use http\Params;
use PDO;

class CRUD_logic
{
    //default PDO param
    private string $pdo_setup = ("mysql:dbname=sqlcrud;host=localhost:3306");

    //login setup
    private const login = [
        'default_username' => "root",
        'default_password' => "1234"
        ];

    //CLient List data is sent as an array
    public function Read_list (): array
    {
        $listArray = [];

        //pdo setup
        $pdo  = new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);

        //declare that i want the list of elements
        $sql = $pdo -> query("SELECT * FROM usuario");

        //check if there are more than 0 rows
        if ($sql -> rowCount() > 0){
            //fetch all rows that are present on 'usuario' database, and fetch only the assoc data
            $listArray = $sql -> fetchAll(PDO::FETCH_ASSOC);
        }
        //return List array
        return $listArray;
    }

    //function that post changes done in (Update_client, ln.60)
    public function apply_changes($id, $input_name, $input_email): void
    {
        //if the variables existis
        if ($id && $input_name && $input_email){
            //default pdo setup
            $pdo  = new PDO($this -> pdo_setup, self::login['default_username'], self::login['default_password']);

            //we prepare the PDO, in this case, we are posting the data we got
            $sql = $pdo->prepare("UPDATE usuario SET nome  = :nome,  email = :email WHERE id = :id");
            //we apply the data we got from the variables on their respective slot on the row
            $sql -> bindValue(':id', $id);
            $sql -> bindValue(':nome', $input_name);
            $sql -> bindValue(':email', $input_email);
            //and we execute it
            $sql -> execute();
            //sending the user to the index page again
            header("Location: http://localhost/crudphp/");
        }

    }

    //function that add a new client on the database
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

        }else{
            //else, return it to client sign up page
            header("Location: http://localhost/crudphp/forms/cadastrousuario/clientsignupUI.php");
        }
    }

    //function that update the data of an client
    public function Update_client($id): array
    {
        // pdo setup
        $pdo = new PDO($this->pdo_setup, self::login['default_username'], self::login['default_password']);
        //array that will return our data
        $usuario = [];

        // declare that I want the list of elements
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE id = :id ");
        //we bind the data
        $sql->bindValue(':id', $id);
        $sql->execute();

        // Check if a user was found
        if ($sql->rowCount() > 0) {
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
        }
        //return it to be used on 'applychanges.php'
        return $usuario;
    }
    //function that deletes an row in the database
    public function Delete_client ($id): void {
        //we check if the data existis 
        if ($id){
            //if so, we start our default setup
            $pdo = new PDO($this->pdo_setup,self::login['default_username'],self::login['default_password']);
            // with 'DELETE FROM usuario', we are defining that we will delete data from the table 'usuario'
            //but only in the 'id' fields where are equal to the 'id' field we selected
            $sql = $pdo ->prepare("DELETE FROM usuario WHERE id = :id");
            $sql -> bindValue(':id', $id);
            $sql -> execute();
        }
        //and again to the index page
        header("Location: http://localhost/crudphp/");
    }
}
