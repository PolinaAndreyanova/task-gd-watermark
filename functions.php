<?php
function renameFile(string $name): string
{
    $newName = pathinfo($name);
    return $newName["filename"] . "_timestamp." . $newName["extension"];
}

function isImage(string $type): bool
{
    return in_array($type, ["image/gif", "image/jpeg", "image/png"]);
}

function isGif(string $type): bool
{
    return $type === "image/gif";
}

function convertToJpg(string $type, string $name): string
{
    $basename = pathinfo($name, PATHINFO_FILENAME);

    if ($type === "image/gif") {
        $im = imagecreatefromgif("uploads/$name");
        imagejpeg($im, "uploadsJpg/$basename.jpg");
    } else if ($type === "image/png") {
        $im = imagecreatefrompng("uploads/$name");
        imagejpeg($im, "uploadsJpg/$basename.jpg");
    } else {
        copy("uploads/$name", "uploadsJpg/$name");
    }

    return $basename . ".jpg";
}

function addWatermark(string $name): void
{
    $im = imagecreatefromjpeg("uploadsJpg/$name");
    $w = imagecreatefromjpeg("watermark.jpg");

    $widthW = imagesx($w);
    $heightW = imagesy($w);

    imagecopymerge($im, $w, imagesx($im) - $widthW, imagesy($im) - $heightW, 0, 0, $widthW, $heightW, 70);

    imagejpeg($im, "uploadsJpg/$name");
}

function convertToWebp(string $type, string $name): string
{
    $basename = pathinfo($name, PATHINFO_FILENAME);

    if ($type === "image/png") {
        $im = imagecreatefrompng("uploads/$name");
    } else {
        $im = imagecreatefromjpeg("uploads/$name");
    }

    imagewebp($im, "uploadsWebp/$basename.webp");

    return $basename . ".webp";
}

function resizeWebpImage(string $name): void
{
    $im = imagecreatefromwebp("uploadsWebp/$name");

    $width = imagesx($im);
    $height = imagesy($im);

    if ($width >= $height) {
        $k = $width / 300;
    } else {
        $k = $height / 300;
    }

    $newWidth = intval($width / $k);
    $newHeight = intval($height / $k);

    $newIm = imagecreatetruecolor($newWidth, $newHeight);
    
    imagecopyresampled($newIm, $im, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    imagewebp($newIm, "uploadsWebp/$name");
}