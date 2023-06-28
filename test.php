<?php 

$json = file_get_contents("Model/AccountProfile.json");
 
$parsedJson = json_decode($json,true);
// var_dump($parsedJson);

$dataAtrributs= $parsedJson['attrs'];
$dataIndex = $parsedJson['indexes'];
// var_dump($dataIndex);


?>

<?php 

// if(isset($_POST['editName']) AND (isset($_POST['key']) ))
// {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['editName']))
        {
            $value = $_POST['name'];
            $parsedJson['name'] = $value;
        }

        if (((isset($_POST['editData'])) AND (isset($_POST['key']))) OR ((isset($_POST['addData'])) AND (isset($_POST['key']))))
        {
            $key = $_POST['key'];
            $value = $_POST['data'];
            $parsedJson['data'][$key] = $value;
        }

        
        ///////////////////// GESTION ATTRIBUT /////////////////////////////////
        if (((isset($_POST['editAttrName']))) OR ((isset($_POST['editAttrData']))) OR (isset($_POST['addAttrData'])))
        {
            $key1 = $_POST['key1'];
            $key2 = $_POST['key2'];
            $value = $_POST['value'];
            $key = 'attrs';

            if(isset($_POST['key3'])){
                $key3 = $_POST['key3'];
                $parsedJson[$key][$key1][$key2][$key3] = $value;
            }else{
                $parsedJson[$key][$key1][$key2] = $value;
            }
        }
        if ((isset($_POST['deleteAttrs'])) AND (isset($_POST['value'])) AND (isset($_POST['key'])))
        {
            $key = "indexes";
            $key1 = $_POST['key'];
            $key2 = "attrs";
            $key3 = $_POST['value'];

            unset($parsedJson[$key][$key1][$key2][$key3]);
        }

        //////////////////////////  GESTION INDEX /////////////////////////////////
        if((isset($_POST['editIndexName'])) OR ((isset($_POST['editIndexData']))) OR (isset($_POST['addIndexData'])))
        {
            $key1=$_POST['key1'];
            $key2=$_POST['key2'];
            $value=$_POST['value'];
            $key = 'indexes';


            if(isset($_POST['key3'])){
                $key3 = $_POST['key3'];
                $parsedJson[$key][$key1][$key2][$key3] = $value;
            }else{
                $parsedJson[$key][$key1][$key2] = $value;
            }
        }

        if((isset($_POST['editIndexUnique'])))
        {
            $key1=$_POST['key1'];
            $key2=$_POST['key2'];


            // si la checkbox n'est pas checker
            if(isset($_POST['value']))
            {
                $value=TRUE;
            }
            else
            {
                $value=FALSE;
            }
            
            $parsedJson['indexes'][$key1][$key2] = $value;
        }

        

        $newJsonString = json_encode($parsedJson,JSON_PRETTY_PRINT);
        file_put_contents('Model/AccountProfile.json', $newJsonString);

    }
        

?>


<html>

<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>


<!-- ///////////////////////////////////////////// STEVEN //////////////////////////////////////// -->
<?php 


$dataArray = $parsedJson;
$dataData = $dataArray['data'];
?>

<div>
        <input type="text" placeholder="ID">
        <input type="text"  value="<?= $dataArray['id']; ?>">
        <br>

        <form id="editName" action="" method="POST">
            <input type="text" placeholder="NAME">
            <input type="text" name="name" value="<?= $dataArray['name']; ?>">
            <input type="submit" name="editName" value="EDIT">
        </form>
</div>
<br>
<div>
    <h1> Data</h1>
        <?php foreach ($dataData as $key => $valuesData): ?>
            <form  action="" method="POST">
                <input type="text" name="key" value="<?= $key ?>">
                <input type="text" name="data" value="<?= $valuesData ?>">
                <input type="submit"  name="editData" value="EDIT">
            </form>
        <?php endforeach;?>
        <form id="addData" action="" method="POST">
            <input type="text" name="key" value="">
            <input type="text" name="data" value="">
            <input type="submit" name="addData" value="ADD">
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
                <form action="" method="POST">
                    <input type="hidden" name="key1" value="<?= $key ?>">
                    <input type="text" name="key2" value="name" style="margin-right:20px;">
                    <input type="text" name="value" value="<?= $monJson['name'] ?>">
                    <input type="submit" name ="editAttrName" value="EDIT">
                </form>
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>DATA</summary>
                    <?php  foreach($monJson['data'] as  $key2 => $data): ?>
                        <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                            <form action="" method="POST">
                                <input type="hidden" name="key1" value="<?= $key ?>">
                                <input type="hidden" name="key2" value="data">
                                <input type="text" name="key3" value="<?= $key2 ?>" style ="margin-right:20px;">
                                <input type="text" name="value" value="<?= $data ?>">
                                <input type="submit" name="editAttrData" value="EDIT">
                            </form>
                        </div>
                   <?php endforeach;?>
                   <form id="addAttrData" action="" method="POST">
                        <input type="hidden" name="key1" value="<?= $key ?>">
                        <input type="hidden" name="key2" value="data">
                        <input type="text" name="key3" value="" style ="margin-right:20px;">
                        <input type="text" name="value" value="" style ="margin-right:20px;">
                        <input type="submit" name="addAttrData" value="ADD">
                   </form>

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
            <form action="" method="POST">
                <input type="text" value="Name" style="margin-right:20px;">
                <input type="hidden" name="key1" value="<?= $key ?>">
                <input type="hidden" name="key2" value="name">
                <input type="text" name="value" value="<?= $monJson['name'] ?>">
                <input type="submit" name="editIndexName" value="EDIT">
            </form>
            </div>
            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <form action="" method="POST">
                    <input type="text" value="Unique">
                    <?php
                   if($monJson['unique'] == TRUE ){
                    $checked ='checked';
                   } else {
                    $checked ='';
                   }
                    ?>
                    <input type="hidden" name="key1" value="<?= $key ?>">
                    <input type="hidden" name="key2" value="unique">
                    <input type="checkbox" name="value" value=""   <?= $checked ?>>
                    <input type="submit" name="editIndexUnique" value="EDIT">
                </form>
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>DATA</summary>
                    <?php  foreach($monJson['data'] as  $key2 => $data): ?>
                        <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                            <form action="" method="POST">
                                <input type="hidden" name="key1" value="<?= $key ?>">
                                <input type="hidden" name="key2" value="data">
                                <input type="text" name="key3" value="<?= $key2 ?>" style ="margin-right:20px;">
                                <input type="text" name="value" value="<?= $data ?>">
                                <input type="submit" name="editIndexData" value="EDIT">
                            </form>
                        </div>
                   <?php endforeach;?>
                   <form id="addIndexData" action="" method="POST">
                        <input type="hidden" name="key1" value="<?= $key ?>">
                        <input type="hidden" name="key2" value="data">
                        <input type="text" name="key3" value="" style ="margin-right:20px;">
                        <input type="text" name="value" value="" style ="margin-right:20px;">
                        <input type="submit" name="addIndexData" value="ADD">
                   </form>

                </details>
            </div>

            <div style="display: flex;flex-direction: row; margin-bottom:20px;">
                <details>
                    <summary>ATTRIBUTES</summary>
                    <?php  foreach($monJson['attrs'] as  $key3 => $attr):?>
                    <div style="display: flex;flex-direction: row; height: 40px;margin-bottom:20px;">
                        <form action="" method="POST">
                            <input type="text" name="value" value="<?= $key3?>" style ="margin-right:20px;">
                            <input type="hidden" name="key" value="<?= $key ?>">
                            <input type="submit" value="UP">
                            <input type="submit" value="DOWN">
                            <input type="submit" name="deleteAttrs" value="DELETE">
                        </form>
                    </div>
                   <?php endforeach;?>
                   <div>     
                        <form action="" method="POST">
                            <select name="" id="">
                            <?php foreach($dataAtrributs as $key1 =>$attrs): ?>
                                <option value=""><?= $key3 ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" name="addAttrsInIndex" value="ADD">
                        </form>
                   </div>
                </details>
            </div>
        </div>
    </details>

 <?php endforeach; ?>


</html>
