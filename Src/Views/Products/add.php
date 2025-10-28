<h1>Создание новой категории</h1>

<?php if (!empty($error)): ?>
    <div style="background-color: red"><?= $error ?></div>
<?php endif; ?>

<form action="products/add" method="POST">
    <label>Название продукта <input type="text" name="title" value="<?= $_POST['title'] ?? '' ?>" size="50"></label><br>
    <label>Описание продутка <textarea name="content" rows="10" cols="80"><?= $_POST['content'] ?? '' ?></textarea></label><br>
    <label>Цена продукта <input type="number" name="price" value="<?= $_POST['price'] ?? '' ?>" size="50"></label><br>
    <label>Категория <select name="categoryId">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId() ?>"><?= $category->getTitle() ?></option>
        <?php endforeach ?>
    </select></label><br>
    <label>Изображение продукта <input type="file" name="img" value="<?= $_POST['img'] ?? '' ?>" size="50"></label><br>
    <input type="submit" value="Создать">
</form>