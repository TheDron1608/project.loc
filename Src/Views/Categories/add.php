<h1>Создание новой категории</h1>

<?php if (!empty($error)): ?>
    <div style="background-color: red"><?= $error ?></div>
<?php endif; ?>

<form action="categories/add" method="POST">
    <label>Название категории <input type="text" name="title" value="<?= $_POST['title'] ?? '' ?>" size="50"></label><br>
    <label>Описание категории <textarea name="description" rows="10" cols="80"><?= $_POST['description'] ?? '' ?></textarea></label><br>
    <input type="submit" value="Создать">
</form>