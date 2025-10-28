<a href="products/add">Добавить продукт</a>

<?php foreach($products as $product): ?>
    <h2><a href="products/<?= $product->getId() ?>"><?= $product->getTitle() ?></a></h2>
    <small>категория: <?= $product->getCategory()->getTitle() ?></small><br>
    Цена: <?= $product->getPrice() ?>

    <p>Описание: <?= $product->getContent() ?></p>
    <img src="img/products/<?= $product->getImg() ?>" alt="Изображение продукта">
    <hr>
<?php endforeach;?>