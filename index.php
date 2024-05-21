<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./index.css" />
    <title>Форма</title>
</head>

<body class="content">
    <form class="content__form" method="post" enctype="multipart/form-data" action="watermark.php" target="_blank">
        <h1 class="content__header">Загрузите картинку</h1>

        <input class="content__input" type="file" name="file" value="" accept=".png, .jpg, .jpeg, .gif" placeholder="Файл" required />

        <button class="content__button" type="submit" name="download">Загрузить</button>
    </form>
</body>

</html>