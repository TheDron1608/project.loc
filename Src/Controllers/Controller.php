<?php
namespace Src\Controllers;

use Src\Views\View;
use Src\Models\Users\User;
use Src\Models\Users\UsersAuthService;

abstract class Controller
{
    protected $view;
    protected $user;
    protected $layout = "default";
    public function __construct()
    {
        $this->view = new View($this->layout);
        $this->user = UsersAuthService::getUserByToken();
        $this->view->setVar('user', $this->user);
        $this->view->setVar('title', $this->GetTitle());
        $this->view->setVar('description', $this->GetDescription());
    }

    protected abstract function GetTitle(): string;
    protected abstract function GetDescription(): string;
}