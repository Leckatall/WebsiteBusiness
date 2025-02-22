<?php


namespace Core;

class AccountManager
{
    public static function register($user)
    {
        $db = App::run(Database::class);
        if (count($db->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $user['email']])->fetchAll()) > 0) {
            // Email already in use
            return false;
        }
        // TODO: Hash passwords
        $db->query('INSERT INTO Accounts (Email, Password, PrivilegeLvl, Status) VALUES
                                                                 (:Email, :Password, :PrivilegeLvl, :Status)', [
            "Email" => $user['email'],
            "Password" => $user['password'],
            "PrivilegeLvl" => $user['privilegeLevel'],
            "Status" => 0
        ]);

    }

    public static function login($email, $password)
    {
        $db = App::run(Database::class);
        $account = $db->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
        if (!$account) {
            return false;
        }
        // TODO: Unhash passwords
        if ($password != $account["Password"]) {
            return false;
        }
        $_SESSION['user_id'] = $account['Id'];

        session_regenerate_id(true);
    }
}
