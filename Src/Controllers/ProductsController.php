<?php 

namespace Src\Controllers;

use Src\Views\View;
use Src\Models\Products\Product;
use Src\Models\Categories\Category;

class ProductsController extends Controller {
    public function all()
    {
        $products = Product::findAll();

        $this->view->renderHtml('Products/all.php', ['products' => $products]);

    }

    public function view(int $productId)
    {
        $product = Product::getById($productId);
        if($product === null){
            throw new NotFoundException();
        }

        $this->view->setVar('title', "Просмотр ".$product->getTitle());
        $this->view->setVar('description', $product->getContent());


        $this->view->renderHtml('Products/view.php', ['product' => $product]);
    }

    public function edit(int $productId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $product = Product::getById($productId);
        if($product === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }

        if (!empty($_POST)) {
            try {
                $newProduct = $product->updateFromArray($_POST);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Products/edit.php',['error' => $e->getMessage()]);
            }
            
            header('Location: /project.loc/products/'.$newProduct->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Редактировать ".$product->getTitle());
        $this->view->setVar('description', "Редактирование доступно лишь авторизированным пользователям");
        
        $this->view->renderHtml('products/edit.php', ['product' => $product]);
    }

    public function delete(int $productId)
    {
        $product = Product::getById($productId);
        if($product === null){
            $this->view->renderHtml('Errors/404.php',[],404);
            return;
        }
        if (Product::hasAnyByColumn('product_id', $productId)) {
            $this->view->renderHtml('Errors/500.php',['error' => 'Невозможно удалить категорию с привязанными продуктами'],500);
            return;
        }
        $product->delete();
        header("Location: /project.loc/products/all");
    }
    
    public function add():void{
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        $categories = Category::findAll() ?? [];

        if (!empty($_POST)) {
            try {
                $newProduct = Product::createFromArray($_POST, $this->user);
            }
            catch (InvalidArgumentException $e) {
                $this->view->renderHtml('Products/add.php', ['error' => $e->getMessage()]);
            }

            header('Location: /project.loc/products/'.$newProduct->getId(), true, 302);
            exit();
        }

        $this->view->setVar('title', "Добавить новый продукт");
        $this->view->setVar('description', "Добавление доступно лишь авторизированным пользователям");

        $this->view->renderHtml('Products/add.php', ['categories' => $categories]);
    }

    protected function GetTitle(): string {
        return "Качественная лофт мебель";
    }

    protected function GetDescription(): string {
        return "Доступно более 2000 видов мебели с фотографиями и подробным описанием";
    }
}