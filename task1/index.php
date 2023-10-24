<?php
$folderPath = 'datafiles/';
$pattern = '/^[A-Za-z0-9]+\.txt$/';
$fileNames = [];

$files = scandir($folderPath);

foreach ($files as $file) {
    $filePath = $folderPath . $file;

    if (is_file($filePath) && preg_match($pattern, $file)) {
        $fileNames[] = $file;
    }
}

sort($fileNames);

foreach ($fileNames as $fileName) {
    echo $fileName . "<br>";
}
?>