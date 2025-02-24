<?php

namespace Core\Database\Models;

use Core\Session;

class AccountModel extends Model
{
    protected string $table = 'Accounts';

    public function __init_table(): void
    {
        $this->query("CREATE TABLE IF NOT EXISTS Accounts (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            email VARCHAR(255) UNIQUE NOT NULL,
                            password_hash VARCHAR(255) NOT NULL,
                            privilege_level INT NOT NULL,
                            approved BOOLEAN DEFAULT FALSE
                    );");
    }

    public function register($email, $password, $privilege_level)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $this->query('INSERT INTO Accounts 
                    (email, password_hash, privilege_level) VALUES
                    (:Email, :Password, :privilege_level)', [
            "Email" => $email,
            "Password" => $password_hash,
            "privilege_level" => $privilege_level,
        ]);

        return $this->lastInsertId();
    }

    public function accountExists($email): bool
    {
        return (bool)$this->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
    }

    public function login($email, $password)
    {
        $account = $this->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
        if (!$account) {
            return false;
        }
        if (!password_verify($password, $account["password_hash"])) {
            return false;
        }
        Session::login($account['id'], $account['privilege_level']);
        return $account;
    }

    public function getAccountsByLevel($privilege_level, $approved = true)
    {
        return $this->query('SELECT id, email FROM Accounts WHERE
                                  approved = :Approved AND 
                                  privilege_level = :Privilege_level;', [
            'Approved' => $approved,
            'Privilege_level' => $privilege_level
        ])->fetchAll();
    }

    public function getStudents($approved = true)
    {
        return $this->getAccountsByLevel(1, $approved);
    }

    public function getTeachers($approved = true)
    {
        return $this->getAccountsByLevel(2, $approved);
    }

    public function getAdmins($approved = true)
    {
        return $this->getAccountsByLevel(3, $approved);
    }

    /**
     * @param int $accountId
     * @param int $editorId
     * @return bool is the editor allowed to change the account
     */
    public function canEditAccount(int $accountId, int $editorId): bool
    {
        $editorAcc = $this->getById($editorId);
        if (!$editorAcc['approved']){
            return false;
        }
        if ($editorId == $accountId) {
            // Allowed to edit your own account
            return true;
        }

        $editor_lvl = $editorAcc['privilege_level'];
        // Admin can edit all accounts
        if ($editor_lvl == 3) {
            return true;
        }

        if ($editor_lvl == 2) {
            // Tutor editor
            $account_lvl = $this->getById($accountId)['privilege_level'];
            if ($account_lvl == 1) {
                // Student account edited so allowed
                return true;
            }
        }

        return false;
    }

    /**
     * @param $accountId int Pk of account to be approved
     * @param $editorId int Pk of account approving
     * @return bool
     */
    public function approveAccount(int $accountId, int $editorId): bool
    {
        if (!$this->canEditAccount($accountId, $editorId)) {
            return false;
        }

        $this->query('UPDATE Accounts SET approved = TRUE WHERE Id = :id', ["id" => $accountId]);
        return true;
    }

    public function deleteAccount($accountId, $editorId): bool
    {
        if (!$this->canEditAccount($accountId, $editorId)) {
            return false;
        }

        $this->deleteById($accountId);
        return true;
    }
}
