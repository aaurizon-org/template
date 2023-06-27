<?php 

$json = file_get_contents("Model/AccountProfile.json");
 
$parsedJson = json_decode($json,true);
// var_dump($parsedJson);

$dataAtrributs= $parsedJson['attrs'];
$dataIndex = $parsedJson['indexes'];
// var_dump($dataIndex);
?>

<?php 
    if(isset($_POST['editName']) AND (isset($_POST['key']) ))
    {
        $key = $_POST['key'];
        $value = $_POST['value'];

        $parsedJson['attrs']['account_id'][$key] = $value;
        $newJsonString = json_encode($parsedJson,JSON_PRETTY_PRINT);
        file_put_contents('Model/AccountProfile.json', $newJsonString);
    }
?>


<html>


<!-- ///////////////////////////////////////////// STEVEN //////////////////////////////////////// -->
<?php 


$dataArray = $parsedJson;
$dataData = $dataArray['data'];
?>

<div>
    <form action="">
        <input type="text" placeholder="ID">
        <input type="text"  value="<?= $dataArray['id']; ?>">
        <br>
        <input type="text" placeholder="NAME">
        <input type="text"  value="<?= $dataArray['name']; ?>">
        <input type="submit" value="EDIT">
    </form>
</div>
<br>
<div>
    <form action="">
        <?php foreach ($dataData as $key => $valuesData): ?>
            <input type="text" value="<?= $key ?>">
            <input type="text"  value=" <?= $valuesData ?>">
            <input type="submit" value="EDIT">
            <br>
        <?php endforeach;?>
        <input type="text" value="">
        <input type="text"  value="">
        <input type="submit" value="ADD">
    </form>
</div>
<br><br>
        
<!-- //////////////////////////////////////// MAT /////////////////////////////////////////////////////  -->
<h1> Attributs</h1>

<?php  foreach($dataAtrributs as  $key => $monJson):?>
    <details>
        <summary style="background-color: grey;"><?= $key ?></summary>
        <div style="width: 100%; display: flex; flex-direction:column;padding:20px 0px; padding-left:60px; ">
            <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                <input type="text" value="ID" style ="margin-right:20px;">
                <input type="text" value="<?= $monJson['id'] ?>">
            </div>
            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <form id="editName" action="" method="POST">
                    <input type="text" name="key" value="name" style="margin-right:20px;">
                    <input type="text" name="value" value="<?= $monJson['name'] ?>">
                    <input type="submit" name ="editName" value="EDIT">
                </form>
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>DATA</summary>
                    <?php  foreach($monJson['data'] as  $key2 => $data): ?>
                        <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                            <input type="text" value="<?= $key2 ?>" style ="margin-right:20px;">
                            <input type="text" value="<?= $data ?>">
                            <input type="button" value="EDIT">
                        </div>
                   <?php endforeach;?>
                   <input type="text" value="" style ="margin-right:20px;">
                   <input type="text" value="" style ="margin-right:20px;">
                   <input type="button" value="ADD">

                </details>
            </div>
        </div>
    </details>

 <?php endforeach;?>


<h1> INDEX</h1>

<?php foreach($dataIndex as  $key => $monJson):?>
    <details>
        <summary style="background-color: grey;"><?= $key ?></summary>
        <div style="width: 100%; display: flex; flex-direction:column;padding:20px 0px; padding-left:60px; ">
            <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                <input type="text" value="ID" style ="margin-right:20px;">
                <input type="text" value="<?= $monJson['id'] ?>">
            </div>
            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <input type="text" value="Name" style="margin-right:20px;">
                <input type="text" value="<?= $monJson['name'] ?>">
                <input type="button" value="EDIT">
            </div>
            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <input type="text" value="Unique">
                <input type="checkbox" value="value="<?= $monJson['unique'] ?>>
                <input type="button" value="EDIT">
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>DATA</summary>
                    <?php  foreach($monJson['data'] as  $key2 => $data): ?>
                        <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                            <input type="text" value="<?= $key2?>" style ="margin-right:20px;">
                            <input type="text" value="<?= $data ?>">
                            <input type="button" value="EDIT">
                        </div>
                   <?php endforeach;?>
                   <input type="text" value="" style ="margin-right:20px;">
                   <input type="text" value="" style ="margin-right:20px;">
                   <input type="button" value="ADD">

                </details>
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>ATTRIBUTES</summary>
                    <?php  foreach($monJson['attrs'] as  $key3 => $attr):?>
                    <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                        <input type="text" value="<?= $key3?>" style ="margin-right:20px;">
                        <input type="text" value="<?= $attr ?>">
                        <input type="button" value="UP">
                        <input type="button" value="DOWN">
                        <input type="button" value="DELETE">
                    </div>
                   <?php endforeach;?>
                </details>
            </div>
        </div>
    </details>

 <?php endforeach; ?>


</html>
