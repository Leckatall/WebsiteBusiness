<?php

namespace Core\Controllers;

use Core\Models\AccountModel;
use Core\Session;
use Core\Validator;

class AccountController extends BaseController
{
    public function index()
    {
        $accounts = (new AccountModel)->getAll();
        load_view('accounts/index.view.php',
            ['heading' => 'Courses',
                'accounts' => $accounts]);
    }

    public function getIndex()
    {
        header('Content-Type: application/json');
        $accounts = (new AccountModel)->getAll();
        if (!$accounts) {
            echo json_encode(["data" => [], "error" => "No courses found"]);
        } else {
            echo json_encode(["data" => $accounts]);
        }
    }

    public function show(int $id)
    {
        $account = (new AccountModel)->getById($id);

        load_view("accounts/show.view.php", [
            "heading" => "Your Account",
            "account" => $account
        ]);
    }

    public function showMyAccount()
    {
        $this->show(Session::getId());
    }

    public function register(): void
    {
        load_view('accounts/register.view.php',
            ['heading' => "Register", 'errors' => Session::get('registration_errors')]);
    }

    public function store(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $privilegeLevel = $_POST['privilegeLevel'];

        $errors = [];
        $email_errs = Validator::email_errors($email);
        if ($email_errs) {
            $errors['email'] = $email_errs;
        }
        $password_errs = Validator::password_errors($password);
        if ($password_errs) {
            $errors['password'] = $password_errs;
        }
        if (!empty($errors)) {
            Session::flash('registration_errors', $errors);
            redirect('/register');
        }

        $account_model = new AccountModel;
        if ($account_model->accountExists($email)) {
            // Email already in use
            Session::flash('registration_errors', ['email' => "Email already exists."]);
            redirect('/register');
        }

        $account_model->register($email, $password, $privilegeLevel);
        if ($errors) {
            // failed validation
            Session::flash('registration_errors', $errors);
            redirect('/register');
        }

        $account_model->login($email, $password);

        redirect("/account?id={$_SESSION['user']['id']}");
    }

    public function edit(int $id): void
    {

    }

    public function update(int $id): void
    {
        function approve($account_id): bool
        {
            return (new AccountModel)->approveAccount($account_id, $_SESSION['user']['id']);
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $action = $data['action'] ?? '';
        if ($action == 'approve') {
            if(approve($id)){
                echo json_encode(["success" => true]);
            }else{
                echo json_encode(["error" => "failed to approve account"]);
                $this->abort(500);
            }
            exit();
        }

        redirect('/accounts');
    }

    public function destroy(int $id): void
    {

    }

    public function login_page(): void
    {
        load_view('accounts/login.view.php',
            ['heading' => "Login", 'error' => Session::get('login_error', [])]);
    }

    public function login(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $account_model = new AccountModel;
        if (!$account_model->accountExists($email)) {
            Session::flash('login_error', 'Email not found');
            redirect('/login');
        }

        $account = $account_model->login($email, $password);
        if (!$account) {
            Session::flash('login_error', 'Incorrect password');
            redirect('/login');
        }

        redirect("/accounts/{$account['id']}");
    }

    public function logout(): void
    {
        Session::logout();
        redirect("/");

    }
}