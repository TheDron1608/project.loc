<?php

namespace Src\Controllers;

use Src\Models\Categories\Category;
use Src\Models\Products\Product;
use Src\Exceptions\InvalidArgumentException;
use Src\Exceptions\UnauthorizedException;

class CategoriesController extends Controller 
{
    public function all()
    {
        $categories = Category::findAll();

        $this->view->renderHtml('Categories/all.php', ['categories' => $categories]);

    }
    public function view(int $productId)
    {
        $category = Category::getById($productId);
        $products = Product::findAllByColumn('category_id', $category->getId()) ?? [];

        if($category === null){
            throw new NotFoundException();
        }

        $this->view->setVar('title', "Просмотр категории ".$category->getTitle());
        $this->view->setVar('description', $category->getDescription());

        $this->view->renderHtml('Categories/view.php', ['category' => $category, 'products' => $products]);
    }

    public function edit(int $categoryId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $category = Category::getById($categoryId);
        if($category === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }

        if (!empty($_POST)) {
            try {
                $newCategory = $category->updateFromArray($_POST);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Categories/edit.php',['error' => $e->getMessage()]);
            }
            
            header('Location: /project.loc/categories/'.$newCategory->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Редактировать категорию ".$category->getTitle());
        $this->view->setVar('description', "Редактирование доступно лишь авторизированным пользователям");
        
        $this->view->renderHtml('categories/edit.php', ['category' => $category]);
    }

    public function delete(int $categoryId)
    {
        $category = Category::getById($categoryId);
        if($category === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }
        if (Product::hasAnyByColumn('category_id', $categoryId)) {
            $this->view->renderHtml('Errors/500.php',['error' => 'Невозможно удалить категорию с привязанными продуктами'],500);
            return;
        }
        $category->delete();
        header("Location: /project.loc/categories/all");
    }
    
    public function add():void{
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $newCategory = Category::createFromArray($_POST, $this->user);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Categories/add.php', ['error' => $e->getMessage()]);
            }

            header('Location: /project.loc/categories/'.$newCategory->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Добавить новую категорию ");
        $this->view->setVar('description', "Добавление доступно лишь авторизированным пользователям");

        $this->view->renderHtml('categories/add.php');
    }
    
    protected function GetTitle(): string {
        return "Каталог категорий лофт мебели";
    }

    protected function GetDescription(): string {
        return "Более 100 категорий доступны для просмотра с фотографиями мебели";
    }
}