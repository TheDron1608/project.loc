<h1>Изменение статьи</h1>
<?php if (!empty($error)): ?>
    <div style="background-color: red"><?= $error ?></div>
<?php endif; ?>

<form action="articles/<?= $article->getId(); ?>/edit" method="POST">
    <label>Название статьи <input type="text" name="name" value="<?= $_POST['name'] ?? $article->getName() ?>" size="50"></label><br>
    <label>Текст статьи <textarea name="text" rows="10" cols="80" value=<?= $_POST['text'] ?? $article->getText() ?> ></textarea></label><br>
    <input type="submit" value="Изменить">
</form>