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
echo "<a href='?path='>Racine</a>";
foreach(explode("/",$path) as $subPath)
{
    $cPath .= "/$subPath";
    $cPath = trim($cPath, "/");
    echo " / <a href='?path=$cPath'>$subPath</a>";
}
?>

<?php
    if(isset($_POST['build']))
    {
        foreach($_POST['files'] as $fileSelected)
        {
            echo "$fileSelected build";
            echo $_GET['path'];
        }
    }

    if(isset($_POST['move']))
    {
        
        if(array_key_exists("rename", $_POST))
        {
            foreach($_POST['files'] as $fileSelected)
            {
                $name = $_POST['rename'];
                $Location = "$rootModel$path/$name";
                rename($fileSelected, $Location);
            }
            
        }
        
    }

    if(isset($_POST['delete']))
    {
        foreach($_POST['files'] as $fileSelected)
        {
            unlink($fileSelected);
        }
    }
?>

<form method="POST" action="">
    <table>
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Name</th>
                <th></th>
                <th></th>
                <th></th>
                <th><input type="submit" name="build" value="Build" /></th>
                <th><input type="submit" name="move" value="Move" /></th>
                <th><input type="submit" name="delete" value="Delete" /></th>
            </tr>
        </thead>
        <tbody>
            
                <?php foreach ($dirIte as $file) : ?>
                    <?php if ($file->isDot()) continue; ?>

                    <tr>
                        <td><input type="checkbox" name="files[]" id="<?= $file->getBasename('.json') ?>" value="<?= $file->getRealPath() ?>"></td>
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
            <th><input type="submit" name="build" value="Build" /></th>
            <th><input type="submit" name="move" value="Move" /></th>
            <th><input type="submit" name="delete" value="Delete" /></th>
        </tfoot>
    </table>
    <input name="rename" type="text" />
</form>


<form method="POST" action="?path=<?=$path?>">
    <input name="name" type="text" />
    <input type="submit" name="type" value="folder" />
    <input type="submit" name="type" value="file" />
</form>