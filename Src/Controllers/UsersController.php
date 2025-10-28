<?php
namespace Src\Controllers;
use Src\Exceptions\InvalidArgumentException;
use Src\Views\View;
use Src\Models\Users\User;
use Src\Models\Users\UsersAuthService;

class UsersController extends Controller
{

    public function signUp()
    {
        if(!empty($_POST)){
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Users/signUp.php',['error'=>$e->getMessage()]);
                return;
            }
            if($user instanceof User){
                $this->view->renderHtml('Users/signUpSuccess.php');
                return;
            }
        }

        $this->view->setVar('title', "Создать новый продукт");
        $this->view->setVar('description', "Регистрация бесплатна, получите больше возможностей на нашем сайте");

        $this->view->renderHtml('Users/signUp.php');

    }
    public function login()
    {
        if(!empty($_POST)){
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /project.loc');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Users/login.php',['error'=>$e->getMessage()]);
                return;
            }
            
        }

        $this->view->setVar('title', "Лофт мебель: войти в аккаунт");
        $this->view->setVar('description', "Если у вас нету аккаунта, вы можете бесплатно зарегестрироваться на нашем сайте");
    
        $this->view->renderHtml('Users/login.php');
    }
    public function logout()
    {
        setcookie('token', '', -1, '/', '', false, true);
        header('Location: /project.loc');
        exit();
    }

    protected function GetTitle(): string {
        return "Управление аккаунтом";
    }

    protected function GetDescription(): string {
        return "Регистрация бесплатна, получите больше возможностей на нашем сайте";
    }
}
