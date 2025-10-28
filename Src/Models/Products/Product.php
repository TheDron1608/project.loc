<?php

namespace Src\Models\Products;

use Src\Models\ActiveRecordEntity;
use Src\Models\Categories\Category;
use Src\Exceptions\InvalidArgumentException;
use Src\Exceptions\UnauthorizedException;

class Product extends ActiveRecordEntity {
    protected $categoryId;
    protected $title;
    protected $content;
    protected $price;
    protected $img;

    public function getCategoryId(): int {
        return $this->categoryId;
    }
    public function setCategoryId(int $value): void {
        $this->categoryId = $value;
    }
    public function getTitle(): string {
        return $this->title;
    }
    public function setTitle(string $value): void {
        $this->title = $value;
    }
    public function getContent(): string {
        return $this->content;
    }
    public function setContent(string $value): void {
        $this->content = $value;
    }
    public function getPrice(): float {
        return $this->price;
    }
    public function setPrice(string $value): void {
        $this->price = $value;
    }
    public function getImg(): string {
        return $this->img;
    }
    public function setImg(string $value): void {
        $this->img = $value;
    }
    public function getCategory(): Category {
        return Category::getById($this->categoryId);
    }
    public function setCategory(Category $value): void {
        $this->vategoryId = $value->getId();
    }
    public static function getTableName(): string
    {
        return 'products';
    }

    public static function createFromArray (array $fields): Product {
        if(empty($fields['categoryId'])){
            throw new InvalidArgumentException('Не передана категория продукта');
        }
        if(empty($fields['title'])){
            throw new InvalidArgumentException('Не передано название продукта');
        }
        if(empty($fields['content'])){
            throw new InvalidArgumentException('Не передан текст категории');
        }
        if(empty($fields['price'])){
            throw new InvalidArgumentException('Не передана цена продукта');
        }
        if (is_nan($fields['price'])) {
            throw new InvalidArgumentException('Цена должна быть числом');
        }
        if (floatval($fields['price']) < 0) {
            throw new InvalidArgumentException('Цена не может быть отрицательным');
        }
        if ($fields['img'] != "" && substr($fields['img'], -4) != '.png' && substr($fields['img'], -4) != '.jpg') {
            throw new InvalidArgumentException('Можно загрузить изоражения только в формате .png или .jpg');
        }
        
        $product = new Product();
        $product->setCategoryId(intval($fields['categoryId']));
        $product->setTitle($fields['title']);
        $product->setContent($fields['content']);
        $product->setPrice(floatval($fields['price']));
        $product->setImg($fields['img'] ?? 'no-image.png');

        if ($fields['img'] != "") {
            move_uploaded_file($fields['img']['tmp_name'], '/project.loc/img/');
        }

        $product->save();

        return $product;
    }

    public function updateFromArray (array $fields): Product {
        if(empty($fields['categoryId'])){
            throw new InvalidArgumentException('Не передана категория продукта');
        }
        if(empty($fields['title'])){
            throw new InvalidArgumentException('Не передано название продукта');
        }
        if(empty($fields['content'])){
            throw new InvalidArgumentException('Не передан текст категории');
        }
        if(empty($fields['price'])){
            throw new InvalidArgumentException('Не передана цена продукта');
        }
        if (is_nan($fields['price'])) {
            throw new InvalidArgumentException('Цена должна быть числом');
        }
        if (floatval($fields['price']) < 0) {
            throw new InvalidArgumentException('Цена не может быть отрицательным');
        }
        if ($fields['img'] != "" && substr($fields['img'], -4) != '.png' && substr($fields['img'], -4) != '.jpg') {
            throw new InvalidArgumentException('Можно загрузить изоражения только в формате .png или .jpg');
        }

        $this->setCategoryId($fields['categoryId']);
        $this->setTitle($fields['title']);
        $this->setContent($fields['content']);
        $this->setPrice($fields['price']);
        $this->setImg($fields['img'] ?? 'no-image.png');

        if ($fields['img'] != "") {
            move_uploaded_file($fields['img']['tmp_name'], '/project.loc/img/');
        }

        $this->save();

        return $this;
    }
}