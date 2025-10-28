<a href="categories/add">Добавить категорию</a>

<?php foreach($categories as $category): ?>
    <h2><a href="categories/<?= $category->getId() ?>"><?= $category->getTitle() ?></a></h2>
    <p><?= $category->getDescription() ?></p>
    <hr>
<?php endforeach; ?>