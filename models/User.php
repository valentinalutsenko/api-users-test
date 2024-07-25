<?php
require_once 'Base.php';
class User extends Base
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public $query_get_user = 'SELECT * FROM users where id = :id ';
    public $query_get_users = 'SELECT * FROM users';

    //Creating user
    public function create(): bool
    {
        $query = 'INSERT INTO users (name, email, password, created_at) VALUES (:name, :email, :password, :created_at)';

        //Preparing statement
        $stmt = $this->conn->prepare($query);

        //Binding data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':$created_at', $this->created_at);

        if($stmt->execute()){
            return true;
        }else{
            //Print if something goes wrong
            printf('Error: %s\n', $stmt->error);
            return false;
        }
    }

    //Update user
    public function update(): bool
    {
        $query = 'UPDATE users SET name = :name, email = :email, updated_at = :updated_at WHERE id = :id';

        //Preparing statement
        $stmt = $this->conn->prepare($query);

        //Binding data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':updated_at', $this->updated_at);


        if($stmt->execute()){
            return true;
        }else{
            //Print if something goes wrong
            printf('Error: %s\n', $stmt->error);
            return false;
        }
    }
    //Deleting the user
    public function delete(): bool
    {
        $query = 'DELETE FROM users WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }else{
            //Print if something goes wrong
            printf('Error: %s\n', $stmt->error);
            return false;
        }
    }

    public function emailExists(): bool
    {
        $query = "SELECT id, name, password FROM users WHERE email = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row["id"];
            $this->name = $row["name"];
            $this->password = $row["password"];
            return true;
        }
        return false;
    }
}