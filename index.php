<?php 

$json = file_get_contents("Model/Account.json");
 
$parsedJson = json_decode($json,true);
// var_dump($parsedJson);

$dataArray = $parsedJson;
$dataData = $dataArray['data'];
$dataAttrs = $dataArray['attrs'];
// $dataIndex = $parsedJson['indexes'];
// var_dump($dataIndex);

// var_dump($dataAttrs);
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Projet 2</title>
  <link rel="stylesheet" href="style.css">
  <script src="script.js"></script>
</head>
<body>
    <main>
        <div>
            <form action="">
                <!-- *4 -->
                <?php foreach ($dataArray as $valueArray): var_dump($valueArray);?>
                <input type="text" placeholder="ID">
                <input type="text" placeholder="123456789" value="<?= $valueArray['id']; ?>">
                <br>
                <input type="text" placeholder="NAME">
                <input type="text" placeholder="Account" value="<?= $valueArray['name']; ?>">
                <input type="submit" value="EDIT">
                <?php endforeach; ?>
            </form>
        </div>
        <br>
        <div>
            <form action="">
                <!-- *6 -->
                <?php foreach ($dataData as $valuesData): ?>
                <input type="text" placeholder="table">
                <input type="text" placeholder="Account" value="<?= $valuesData['table']; ?>">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="class">
                <input type="text" placeholder="Account"  value="<?= $valuesData['class']; ?>">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" value="<?= $dataData['name'] ?>">
                <input type="text">
                <input type="submit" value="ADD">
                <?php endforeach; ?>
            </form>
        </div>
        <br><br>
        <div>
            <form action="">
                id_account
                <br>
                <input type="text" placeholder="ID">
                <input type="text" placeholder="123456789">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="NAME">
                <input type="text" placeholder="Account">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="TYPE">
                
                <select name="" id="">
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                </select>
                <input type="submit" value="EDIT">
                <br><br>
                <input type="text" placeholder="table">
                <input type="text" placeholder="Account">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="class">
                <input type="text" placeholder="Account">
                <input type="submit" value="EDIT">
                <br>
                <input type="text">
                <input type="text">
                <input type="submit" value="ADD">
                <br>
                username
                <br>
                password
                <br>
            </form>
        </div>
        <br><br>
        <div>
            <form action="">
                <h3>Indexes</h3>
                PRIMARY
                <br>
                <input type="text" placeholder="ID">
                <input type="text" placeholder="132456789">
                <br>
                <input type="text" placeholder="NAME">
                <input type="text" placeholder="PRIMARY">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="UNIQUE">
                <input type="checkbox">
                <input type="submit" value="EDIT">
            </form>
        </div>
        <br><br>
        <div>
            <form action="">
            <input type="text" placeholder="table">
                <input type="text" placeholder="Account">
                <input type="submit" value="EDIT">
                <br>
                <input type="text" placeholder="class">
                <input type="text" placeholder="Account">
                <input type="submit" value="EDIT">
                <br>
                <input type="text">
                <input type="text">
                <input type="submit" value="ADD">
            </form>     
        </div>
        <br><br>
        <div>
            <form action="">
                <input type="text" placeholder="id_account">
                <input type="submit" value="UP">
                <input type="submit" value="DOWN">
                <input type="submit" value="DELETE">
                <br>
                <select name="" id="">
                    <option value=""></option>
                    <option value=""></option>
                    <option value=""></option>
                </select>
                <input type="submit" value="ADD">

                
            </form>
        </div>
    </main>
</body>