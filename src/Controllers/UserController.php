<?php
namespace Controllers;
use DTO\AuthDTO;
use DTO\RegisterUserDTO;
use DTO\UpdateProfileDTO;
use Model\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\UserService;

class UserController extends Controller
{
    protected User $userModel;
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
        $this->userService = new UserService();
    }


    public function getRegistrateForm()
    {
        if ($this->authService->check()) {
            header ("Location: /catalog");
        }
        require_once '../Views/registration_form.php';
    }
    public function registrate(RegistrationRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {

            $dto = new RegisterUserDTO(
                $request->getName(),
                $request->getEmail(),
                $request->getPsw());

          $this->userService->registerUser($dto);
        }
        require_once '../Views/login_form.php';
    }


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

    public function login(LoginRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {

            $dto = new AuthDTO($request->getUsername(), $request->getPassword());
            $result = $this->authService->auth($dto);
            if ($result) {
                header("Location: /catalog");
                exit();

            } else {
                $errors['username'] = 'Неверное имя пользователя или пароль';
                }
            }
        require_once '../Views/login_form.php';
    }


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


public function getEditProfile()

{
    $user = $this->authService->getCurrentUser();
    require_once '../Views/edit_profile_form.php';
}

    public function editProfile(EditProfileRequest $request)
{
    if (!$this->authService->check()) {
        header( "Location: /login");
        exit;
    }
    $errors = $request->validate();
    if (empty($errors)) {

        $userByEmail = $this->userModel->getByEmail($request->getEmail());

        $user = $this->authService->getCurrentUser();
        if ($userByEmail != null && $userByEmail->getId() !== $user->getId()) {
            $errors['email'] = "Этот email уже зарегистрирован";
    }

    if (empty($errors)) {

        $dto = new UpdateProfileDTO($user, $request->getName(), $request->getEmail());

      $this->userService->updateProfile($dto);

        header("Location: /profile");
        exit;
    }
    require_once '../Views/edit_profile_form.php';
}
}

    public function logout() {
       $this->authService->logout();
        header("Location: /login");
        exit();
    }
}


