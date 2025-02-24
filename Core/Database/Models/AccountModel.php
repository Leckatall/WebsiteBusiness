<?php

namespace Core\Database\Models;

use Core\Session;

class AccountModel extends Model
{
    protected string $table = 'Accounts';

    public function register($email, $password, $privilege_level)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->query('INSERT INTO Accounts 
                    (Email, Password, PrivilegeLvl, Status) VALUES
                    (:Email, :Password, :PrivilegeLvl, :Status)', [
                        "Email" => $email,
                        "Password" => $password,
                        "PrivilegeLvl" => $privilege_level,
                        "Status" => 0
        ]);
    }

    public function accountExists($email): bool
    {
        return (bool) $this->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
    }
    public function login($email, $password)
    {
        $account = $this->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
        if (!$account) {
            return false;
        }
        if (password_hash($password, PASSWORD_DEFAULT) != $account["Password"]) {
            return false;
        }
        return $account;
    }

    public function getPendingStudents()
    {
        return $this->query('SELECT Id, Email FROM Accounts WHERE Status = 0 AND PrivilegeLvl = 1;')->fetchAll();
    }

    public function getPendingTeachers()
    {
        return $this->query('SELECT Id, Email FROM Accounts WHERE Status = 0 AND PrivilegeLvl = 2;')->fetchAll();
    }
    public function approveAccount($accountId)
    {
        $this->query('UPDATE Accounts SET Status = 1 WHERE Id = :id', ["id" => $accountId]);
    }
}