<?php
include_once '../include/conn.php';
include_once '../models/phonebook_model.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

//new instance from the Model
$phonebook = new Phonebook_Model($db);

//Insert new item
if(!isset($_POST['id']) && isset($_POST['name'])) {
    $phonebook->name = $_POST['name'];
    $phonebook->number = $_POST['number'];
    $phonebook->isactive = ($_POST['isactive']==1)?1:0;
    
    $result = $phonebook->create();
    if($result){
        echo $result;
    }else{
        echo "0";
    }
    
}
//Edit record
else if(isset($_POST['id']) && isset($_POST['name']))
{
    $phonebook->id = $_POST['id'];
    $phonebook->name = $_POST['name'];
    $phonebook->number = $_POST['number'];
    $phonebook->isactive = ($_POST['isactive']==1)?1:0;
    
    $result = $phonebook->update();
    if($result){
        echo $result;
    }else{
        echo "0";
    }
}
//Edit number only
else if($_POST['type']==3){
    $phonebook->id = $_POST['id'];
    $phonebook->number = $_POST['number'];
    $result = $phonebook->update_number();
    if($result){
        echo $result;
    }else{
        echo "0";
    }
}
//Delete item
else if($_POST['type']==2){
    $phonebook->id = $_POST['id'];
    if($phonebook->delete()){
        echo "1";
    }else{
        echo "0";
    }
}
