<?php
/**
 * Created by PhpStorm.
 * User: ismael trascastro
 * Date: 21/12/13
 * Time: 22:43
 */

namespace application\models;

use xen\Adapter;
use xen\Model;

class UsersModel extends Model
{
    public function add($email, $password)
    {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $query = $this->_db->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->execute();
    }

    public function all()
    {
        $sql = "SELECT * FROM users";
        $query = $this->_db->prepare($sql);
        $query->execute();

        $users = array();

        while ($row = $query->fetch(Adapter::FETCH_ASSOC))
        {
            $users[] = new UserModel($row['id'], $row['email'], $row['password']);
        }

        return $users;
    }

    public function remove($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $query = $this->_db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $this->_db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();

        $row = $query->fetch(Adapter::FETCH_ASSOC);

        $user = new UserModel($row['id'], $row['email'], $row['password']);

        return $user;
    }

    public function update($id, $email, $password)
    {
        $sql = "UPDATE users SET email = :email, password = :password WHERE id = :id";
        $query = $this->_db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->execute();
    }
}