<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/project.loc/">
    <link rel="stylesheet" href="css/style.css" >
    <?php if (isset($title)): ?>
    <title><?= $title ?></title>
    <?php endif ?>
    <?php if (isset($description)): ?>
    <meta name="description" content="<?= $description ?>">
    <?php endif ?>
</head>
<body class="body">
    <header class="header">
      <h1 class="header-header">Сайт мебели</h1>
      <nav class="header-nav">
        <a href="products/all">Продукты</a>
        <a href="categories/all">Категории</a>
        <a href="articles/all">Статьи</a>
      </nav>
      <br>
      <div class="header-account">
        <?= !empty($user) ? 'Привет, '.$user->getNickname().' '.'<a href="users/logout">Выход</a>' : '<a href="users/login">Войти</a> <a href="users/register">Регистрация</a>' ?>
      </div>
      </header>
    <main class="main">
        <?= $content ?>
    </main>
    <footer class="footer">
      <div class="footer-elem">
        +7 (123) 456 78 90
      </div>
    <div class="footer-elem">
      mail@mail.com
    </div>
    <div class="footer-elem">
      Коржев Андрей ИВ1К-22
    </div>
    </footer>
</body>
</html> 