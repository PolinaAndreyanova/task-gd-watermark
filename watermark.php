<?php
include_once("functions.php");

$arUploadFileInfo = $_FILES["file"];
$uploadFileName = renameFile($arUploadFileInfo["name"]);
$uploadFileType = $arUploadFileInfo["type"];

$isImage = isImage($uploadFileType);

if ($isImage) {
    move_uploaded_file($arUploadFileInfo["tmp_name"], "uploads/" . $uploadFileName);

    $uploadFileJpg = convertToJpg($uploadFileType, $uploadFileName);
    
    addWatermark($uploadFileJpg);

    $isGif = isGif($uploadFileType);
    
    if (!$isGif) {
        $uploadFileWebp = convertToWebp($uploadFileType, $uploadFileName);
        resizeWebpImage($uploadFileWebp);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./index.css" />
    <title>Картинка</title>
</head>

<body class="content">
    <?php if ($isImage) { ?>
        <img class="content__img" src="uploadsJpg/<?= $uploadFileJpg ?>" alt="Картинка" />
        <a class="content__link" href="uploadsJpg/<?= $uploadFileJpg ?>" target="_blank">Ссылка на JPG</a>

        <?php if ($isGif) { ?>
            <p class="content__error">Для данного расширения перевод в формат WEBP невозможен</p>
        <?php } else { ?>
            <a class="content__link" href="uploadsWebp/<?= $uploadFileWebp ?>" target="_blank">Ссылка на WEBP</a>
        <?php } ?> 
    <?php } else { ?>
        <p class="content__error">Вы загрузили не изображение!</p>
    <?php } ?> 
</body>

</html>