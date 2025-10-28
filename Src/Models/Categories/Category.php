<?php

namespace Src\Models\Categories;

use Src\Models\ActiveRecordEntity;
use Src\Exceptions\InvalidArgumentException;
use Src\Exceptions\UnauthorizedException;

class Category extends ActiveRecordEntity {
    protected $title;
    protected $description;

    public function getTitle(): string {
        return $this->title;
    }
    public function setTitle(string $value): void {
        $this->title = $value;
    }
    public function getDescription(): string {
        return $this->description;
    }
    public function setDescription(string $value): void {
        $this->description = $value;
    }
    public static function getTableName(): string
    {
        return 'categories';
    }

    public static function createFromArray (array $fields): Category {
        if(empty($fields['title'])){
            throw new InvalidArgumentException('Не передано название категории');
        }
        if(empty($fields['description'])){
            throw new InvalidArgumentException('Не передан текст категории');
        }
        $category = new Category();
        $category->setTitle($fields['title']);
        $category->setDescription($fields['description']);

        $category->save();

        return $category;
    }

    public function updateFromArray (array $fields): Category {
        if(empty($fields['title'])){
            throw new InvalidArgumentException('Не передано название категории');
        }
        if(empty($fields['description'])){
            throw new InvalidArgumentException('Не передан текст категории');
        }

        $this->setTitle($fields['title']);
        $this->setDescription($fields['description']);

        $this->save();

        return $this;
    }
}