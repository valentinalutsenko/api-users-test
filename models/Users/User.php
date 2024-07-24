<?php

class User extends Base
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;
    public $update_at;

    public $query_get_users = 'SELECT * FROM users where id=:id ';

    //Creating user
    public function create(): bool
    {
        $query = 'INSERT INTO users (name, email, password, created_at ) VALUES (:name, :email, :password, :created_at)';

        //Preparing statement
        $stmt = $this->conn->prepare($query);

        //Binding data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':created_at', $this->created_at);

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
        $query = 'UPDATE users SET name = :name, email = :email, password = :password, update_at = :update_at WHERE id = :id';

        //Preparing statement
        $stmt = $this->conn->prepare($query);

        //Binding data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':update_at', $this->update_at);

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
}