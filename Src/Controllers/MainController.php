<?php

namespace Src\Controllers;
use Src\Views\View;

class MainController extends Controller
{

    public function main()
    {
        $this->view->renderHtml('Main/main.php');
    }

    public function sayHello(string $name){
        $content = 'Привет, '.$name;
        include __DIR__.'/../Views/Layouts/default.php';
    }

    protected function GetTitle(): string {
        return "Качественная и недорогая лофт мебель";
    }

    protected function GetDescription(): string {
        return "Официальный каталог дизайнерской мебели в стиле лофт. Мебель для кухни и спальни. [Цена от 1500 до 25000]";
    }
}