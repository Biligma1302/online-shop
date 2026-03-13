<?php
class UserController
{  // регистрация
    public function getRegistrate()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
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

            require_once '../Model/User.php';
            $userModel = new User();

            $result = $userModel->getByEmail($email);
            print_r($result);

            if ($result) {
                echo "Email уже занят";
            } else {

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хешируем пароль перед сохранением

             $userModel->insertInto($name, $email, $hashedPassword);

            }
        }
        require_once '../Views/registration_form.php';
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['logged_in'])) {
            header("Location: /catalog");
            exit();
        }
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            require_once '../Model/User.php';
            $userModel = new User();

           $user = $userModel->getByUsername($username);

            if ($user === false) {
                $errors['username'] = 'Неверное имя пользователя или пароль';
            } else {
                $passwordDb = $user['password'];

                if (password_verify($password, $passwordDb)) {

                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    header("Location: /catalog");
                    exit();
                    #setcookie('user_id', $user['id']);
                } else {
                    $errors['username'] = 'Неверное имя пользователя или пароль';
                }
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
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            require_once '../Model/User.php';
            $userModel = new User();

           $user = $userModel->getByID($user_id);

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
    if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

    if (!isset($_SESSION['user_id'])) {
        header( "Location: /login");
        exit;
    }
    $errors = $this->editProfileValidate($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $user_id = $_SESSION['user_id'];

        require_once '../Model/User.php';
        $userModel = new User();

        $user = $userModel->getbyId($user_id);

        if ($user['name'] !== $name) {
            $userModel-> updateNameById($name, $user_id);
        }

        if ($user['email'] !== $email) {
           $userModel-> updateEmailById($email, $user_id);
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

                require_once '../Model/User.php';
                $userModel = new User();
                $user = $userModel->getByEmail($email);

                $user_id = $_SESSION['user_id'];
                if ($user['id'] !== $user_id) {
                    $errors['email'] = "Этот email уже зарегистрирован";
                }
            }
        }
        return $errors;
    }
}