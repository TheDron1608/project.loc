<a href="categories/<?= $category->getId() ?>/edit">Редактировать</a>
<a href="categories/<?= $category->getId() ?>/delete">Удалить</a>

<h1><?= $category->getTitle() ?></h1>
<p><?= $category->getDescription() ?></p>
<hr>
<h2>Продукты категории: </h2>
<?php foreach($products as $product): ?>
    <h2><a href="products/<?= $product->getId() ?>"><?= $product->getTitle() ?></a></h2>
    <small>категория: <?= $product->getCategory()->getTitle() ?></small><br>
    Цена: <?= $product->getPrice() ?>

    <p>Описание: <?= $product->getContent() ?></p>
    <img src="img/products/<?= $product->getImg() ?>" alt="Изображение продукта">
    <hr>
<?php endforeach;?>