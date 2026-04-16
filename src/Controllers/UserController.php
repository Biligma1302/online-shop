<?php
namespace Controllers;
use Model\User;
class UserController extends Controller
{
    protected User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();

    }


    // регистрация
    public function getRegistrate()
    {
        if ($this->authService->check()) {
            header ("Location: /catalog");
        }
        require_once '../Views/registration_form.php';
    }
    public function registrate()
    {
        $errors = $this->validate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-repeat'];

            $result = $this->userModel->getByEmail($email);

            if ($result) {
                echo "Email уже занят";
            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хешируем пароль перед сохранением

             $this->userModel->insertInto($name, $email, $hashedPassword);

            }
        }
        require_once '../Views/login_form.php';
    }

   private function validate(array $data): array
    {
        $errors = [];

        if (isset($data ['name'])) {
            $name = $data['name'];

            if (strlen($name) < 5) {
                $errors['name'] = 'Имя должно содержать минимум 5 символов';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($data['email'])) {
            $email = $data['email'];

            if (strlen($email) < 5) {
                $errors['email'] = 'email указан некорректно';
            }
            if (strpos($email, '@') === false) {
                $errors['email'] = 'email должен иметь символ @';
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];

            if (strlen($password) < 5) {
                $errors['psw'] = 'Пароль должен содержать минимум 6 символов';
            }

            if ($password !== ($data['psw-repeat'])) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['psw'] = 'пароль должен быть заполнен';
        }
        return $errors;
    }

    // логин

    public function getLogin()
    {
        $this->authService->check();

        if (isset($_SESSION['logged_in'])) {
            header("Location: /catalog");
            exit();
        } else {
            require_once '../Views/login_form.php';
        }
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = $this->authService->auth($username, $password);
            if ($result) {
                header("Location: /catalog");
                exit();

            } else {
                $errors['username'] = 'Неверное имя пользователя или пароль';
                }
            }
        require_once '../Views/login_form.php';

    }
    function validateLogin(array $data): array
    {
        $errors = [];

        if (!isset($data['username'])) {
            $errors['username'] = 'Поле Username обязательно для заполнения!';
        }
        if (!isset($data['password'])) {
            $errors['password'] = 'Поле Password обязательно для заполнения!';
        }
        return $errors;
    }

    //выдача профиля

    public function getDisplayProfile()
    {
        require_once '../Views/profile.php';
    }
    public function displayProfile()
    {

        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

           $user = $this->userModel->getByID($user->getId());

            require_once '../Views/profile.php';
        } else {
            header("Location: /login");
            exit();
        }
    }


//редактирование профиля
public function getEditProfile()
{
    require_once '../Views/edit_profile_form.php';
}

    public function editProfile()
{
    if (!$this->authService->check()) {
        header( "Location: /login");
        exit;
    }
    $errors = $this->editProfileValidate($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $user = $this->authService->getCurrentUser();;


        $user = $this->userModel->getbyId($user->getid());

        if ($user['name'] !== $name) {
            $this->userModel-> updateNameById($name, $user->getId());
        }

        if ($user['email'] !== $email) {
           $this->userModel-> updateEmailById($email, $user->getId());
        }
        header("Location: /profile");
        exit;
    }

    require_once '../Views/edit_profile_form.php';
}

    function editProfileValidate(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 5) {
                $errors['name'] = 'Имя не может содержать меньше 5 символов';
            }
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 5) {
                $errors['email'] = "Email не может содержать меньше 5 сиволов";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректный email";
            } else {



                $user = $this->userModel->getByEmail($email);

                $user = $this->authService->getCurrentUser();;
                if ($user->getId() !== $user) {
                    $errors['email'] = "Этот email уже зарегистрирован";
                }
            }
        }
        return $errors;
    }
    public function logout() {
       $this->authService->logout();
        header("Location: /login");
        exit();
    }
}