<?php

namespace Src\Controllers;

use Src\Exceptions\NotFoundException;
use Src\Exceptions\UnauthorizedException;
use Src\Exceptions\InvalidArgumentException;
use Src\Views\View;
use Src\Models\Articles\Article;
use Src\Models\Users\User;
use Src\Models\Users\UsersAuthService;


class ArticlesController extends Controller
{

    public function all()
    {
        $articles = Article::findAll();

        $this->view->renderHtml('Articles/all.php', ['articles' => $articles]);

    }
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article === null){
            throw new NotFoundException();
        }

        $this->view->setVar('title', "Просмотр отзыва №".$articleId);
        $this->view->setVar('description', $article->getName());

        $this->view->renderHtml('Articles/view.php', ['article' => $article]);
    }

    public function edit(int $articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $article = Article::getById($articleId);
        if($article === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }

        if (!empty($_POST)) {
            try {
                $newArticle = $article->updateFromArray($_POST);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Articles/edit.php',['error' => $e->getMessage()]);
            }
            
            header('Location: /project.loc/articles/'.$newArticle->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Редактирование отзыва №".$articleId);
        $this->view->setVar('description', "Редактирование отзывов доступно лишь авторизированным пользователям");
        
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function delete(int $articleId)
    {
        $article = Article::getById($articleId);
        if($article === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }
        $article->delete();
        header("Location: /project.loc/articles/all");
    }
    
    public function add():void{
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $newArticle = Article::createFromArray($_POST, $this->user);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Articles/add.php', ['error' => $e->getMessage()]);
            }

            header('Location: /project.loc/articles/'.$newArticle->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Добавить новый отзыв");
        $this->view->setVar('description', "Добавлять отзывы могут лишь авторизированные пользователи");

        $this->view->renderHtml('articles/add.php');
    }

    protected function GetTitle(): string {
        return "Отзывы покупателей лофт мебели";
    }

    protected function GetDescription(): string {
        return "Доступно 1580 отзывов. 95% положительных отзывов";
    }
}