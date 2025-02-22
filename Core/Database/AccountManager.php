<?php


namespace Core\Database;

use Core\App;
use Core\Validator;

class AccountManager
{
    public static function register($user): array
    {
        $errors = [];
        $email_errs = Validator::email_errors($user['email']);
        if ($email_errs) {
            $errors['email'] = $email_errs;
        }
        $password_errs = Validator::password_errors($user['password']);
        if ($password_errs) {
            $errors['password'] = $password_errs;
        }
        if (!empty($errors)) {
            return $errors;
        }


        $db = App::run(Database::class);
        if (count($db->query('SELECT * FROM Accounts WHERE email = :Email',
                ["Email" => $user['email']])->fetchAll()) > 0) {
            // Email already in use
            $errors['email'] = "Email already exists.";
            return $errors;
        }
        // TODO: Hash passwords
        $db->query('INSERT INTO Accounts 
    (Email, Password, PrivilegeLvl, Status) VALUES
    (:Email, :Password, :PrivilegeLvl, :Status)', [
            "Email" => $user['email'],
            "Password" => $user['password'],
            "PrivilegeLvl" => $user['privilegeLevel'],
            "Status" => 0
        ]);
        static::login($user['email'], $user['password']);
        return [];
    }

    public static function login($email, $password): string
    {
        $db = App::run(Database::class);
        $account = $db->query('SELECT * FROM Accounts WHERE email = :Email', ["Email" => $email])->fetch();
        if (!$account) {
            return "Email not found";
        }
        // TODO: Unhash passwords
        if ($password != $account["Password"]) {
            return "Incorrect password";
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $account['Id'];
        $_SESSION['privilege_level'] = $account['PrivilegeLvl'];

        return "";
    }

    public static function logout(): void{
        session_unset();
    }


}
