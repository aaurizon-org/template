<?php

$rootModel = "./Model";
$path = $_GET['path'] ?? '';

if (isset($_REQUEST['name']) and $_REQUEST['type'] === 'folder') {
    mkdir("$rootModel/$path/{$_REQUEST['name']}");
}

if (isset($_REQUEST['name']) and $_REQUEST['type'] === 'file') {
    file_put_contents("$rootModel/$path/{$_REQUEST['name']}.json", json_encode([
        "id" => null,
        "name" => $_REQUEST['name'],
        "data" => [],
        "attrs" => [],
        "indexes" => []

    ], JSON_PRETTY_PRINT));
}

$dirIte = new DirectoryIterator($rootModel . "/$path");

/** @var \DirectoryIterator $file */
?>

<?php
$cPath = "";
echo "<a href='?path='>Racine</a>";
foreach (explode("/", $path) as $subPath) {
    $cPath .= "/$subPath";
    $cPath = trim($cPath, "/");
    echo " / <a href='?path=/$cPath'>$subPath</a>";
}
?>

<?php
if (isset($_POST['build'])) {
    foreach ($_POST['files'] as $fileSelected) {
        echo "$fileSelected build";
        echo $_GET['path'];
    }
}

if (isset($_POST['move'])) {

    if (array_key_exists("rename", $_POST)) {
        foreach ($_POST['files'] as $fileSelected) {
            $name = $_POST['rename'];
            $Location = "$rootModel$path/$name";



            rename($fileSelected, $Location . DIRECTORY_SEPARATOR . basename($fileSelected));
        }
    }
}

if (isset($_POST['delete'])) {
    foreach ($_POST['files'] as $fileSelected) {
        unlink($fileSelected);
    }
}
?>

<form method="POST" action="">
    <table>
        <thead>
            <tr>
                <th><input type="checkbox" onchange=" document.querySelectorAll('.changeme').forEach(el => el.checked = this.checked) " ></th>
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
                    <td><input class="<?=($file->getBasename('.json') == '.json') ? '' : 'changeme'?>" type="checkbox" name="files[]" id="<?= $file->getBasename('.json') ?>" value="<?= $file->getRealPath() ?>"></td>
                    <td><label for="<?= $file->getBasename('.json') ?>"><?php if ($file->getBasename('.json') == '.json') : echo '/'; ?></label></td>
                <?php else : echo ($file->isDir() ? "<a href=\"?path=$path/{$file->getFilename()}\">" . $file->getBasename('.json')  . '</a>' : $file->getBasename('.json')); ?>
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


    <select name="rename">
        <?php
function get_relative_path($base_path, $dest_path) {
    // Normalize paths
    $base_path = realpath($base_path);
    $dest_path = realpath($dest_path);

    // Ensure they're both valid
    if ($base_path === false || $dest_path === false) {
        throw new Exception('Invalid path provided.');
    }

    // Explode paths into arrays
    $base_path_parts = explode(DIRECTORY_SEPARATOR, $base_path);
    $dest_path_parts = explode(DIRECTORY_SEPARATOR, $dest_path);

    // Find common base
    while(count($base_path_parts) && count($dest_path_parts) && ($base_path_parts[0] == $dest_path_parts[0])) {
        array_shift($base_path_parts);
        array_shift($dest_path_parts);
    }

    // Get relative path
    $relative_path_parts = array_merge(
        array_fill(0, count($base_path_parts), '..'),
        $dest_path_parts
    );

    // Return relative path
    return implode(DIRECTORY_SEPARATOR, $relative_path_parts);
}
        ?>
        <?php foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootModel)) as $dir) : if (!$dir->isDir() or $dir->getFilename() == '..') continue; ?>
            <option value="<?= get_relative_path($rootModel.$path, $dir->getRealpath()) ?>"><?= get_relative_path($rootModel.$path, $dir->getRealpath()) ?></option>
        <?php endforeach; ?>
    </select>


</form>


<form method="POST" action="?path=<?= $path ?>">
    <input name="name" type="text" />
    <input type="submit" name="type" value="folder" />
    <input type="submit" name="type" value="file" />
</form>