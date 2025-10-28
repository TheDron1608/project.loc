<h1>Изменение категории</h1>
<?php if (!empty($error)): ?>
    <div style="background-color: red"><?= $error ?></div>
<?php endif; ?>

<form action="categories/<?= $category->getId(); ?>/edit" method="POST">
    <label>Название категории <input type="text" name="title" value="<?= $_POST['title'] ?? $category->getTitle() ?>" size="50"></label><br>
    <label>Описание категории <textarea name="description" rows="10" cols="80" value=<?= $_POST['description'] ?? $category->getDescription() ?> ></textarea></label><br>
    <input type="submit" value="Изменить">
</form>