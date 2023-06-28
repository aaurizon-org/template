<?php

$rootModel = "./Model";
$path = $_GET['path']??'';

if(isset($_REQUEST['name']) AND $_REQUEST['type'] === 'folder')
{
    mkdir("$rootModel/$path/{$_REQUEST['name']}");
}

if(isset($_REQUEST['name']) AND $_REQUEST['type'] === 'file')
{
    file_put_contents("$rootModel/$path/{$_REQUEST['name']}.json", json_encode([
        "id" => null,
        "name" => $_REQUEST['name'],
        "data" =>[],
        "attrs" =>[],
        "indexes" =>[]       

    ],JSON_PRETTY_PRINT));
}

$dirIte = new DirectoryIterator($rootModel."/$path");

/** @var \DirectoryIterator $file */
?>

<?php
$cPath = "";
echo "<a href='?path=/'>Racine</a>";
foreach(explode("/",$path) as $subPath)
{
    $cPath .= "/$subPath";
    $cPath = trim($cPath, "/");
    echo " / <a href='?path=$cPath'>$subPath</a>";
}
?>


<table>
    <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>Name</th>
            <th>Build</th>
            <th>Move</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dirIte as $file) : ?>
            <?php if ($file->isDot()) continue; ?>
            <tr>
                <td><input type="checkbox" id="<?= $file->getBasename('.json') ?>"></td>
                <td><label for="<?= $file->getBasename('.json') ?>"><?php if ($file->getBasename('.json') == '.json'): echo '/'; ?></label></td>
                <?php else: echo ($file->isDir() ? "<a href=\"?path=$path/{$file->getFilename()}\">" . $file->getBasename('.json')  . '</a>' : $file->getBasename('.json')); ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Build</th>
        <th>Move</th>
        <th>Delete</th>
    </tfoot>
</table>


<form method="POST" action="?path=<?=$path?>">
<input name="name" type="text" />
<input type="submit" name="type" value="folder" />
<input type="submit" name="type" value="file" />

</form>