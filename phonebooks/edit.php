<?php include_once "../include/header.php"; 

// include database and object files
include_once '../include/conn.php';
include_once '../models/phonebook_model.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

$phonebook = new Phonebook_Model($db);
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$phonebook->id = $id;
$phonebook->get_item();

?>
<script>
    function isValid()
    {
        var isValid=1;
        var errorMsg = "";
        if($('#name').val() == '')
        {
            errorMsg += "Please enter name!<br/>";
            isValid=0;
        }
        if($('#number').val() == '')
        {
            errorMsg += "Please enter number!";
            isValid=0;
        }else if(!$.isNumeric($('#number').val()))
        {
            errorMsg += "Please enter a valid number!";
            isValid=0;
        }
        
        if(isValid == 0)
        {
            $('#errors').html(errorMsg);
            return false;
        }
        
        return true;
    }
    
    function clickSubmit()
    {
        if(!isValid()){
            return false;
        }
        
        var id = $('#id').val();
        var name = $('#name').val();
        var number = $('#number').val();
        var isactive = $('#chkActive').is(':checked')?1:0;
        $.ajax({
                url: "../phonebooks/ajax_phonebooks.php",
                type: "POST",
                data: {"id":id, "name":name, "number":number,"isactive":isactive},
                success: function(data)
                {
                    if(data == "1"){
                        $('#errors').html('data updated successfully.');
                    }else if(data == "2"){
                        $('#errors').html('The name or number already exist!');
                    }else if(data == "0"){
                        $('#errors').html('error in data, please try again!');
                    }
                }
            });
            
        return true;
    }
</script>
<h2>Edit item</h2>
<form id="form1" name="form1" action="" method="post">
<table>
    <div id="errors" name="errors" class="error"></div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" size="50" value="<?php echo $phonebook->name;?>" class="form-control" />
    </div>
    <div class="form-group">
        <label for="number">Number: </label> 
        <input type="text" class="form-control" id="number" name="number" value="<?php echo $phonebook->number;?>" class="form-control" />
    </div>
    <div class="form-group">
        <label for="txtDescAr">Active: </label>
        <input type="checkbox" name="chkActive" id="chkActive" value="1" <?php if($phonebook->isactive == 1){echo"checked";}?>>
    </div>
    <tr>
        <td><input type="hidden" id="id" name="id" value="<?php echo $phonebook->id;?>"></td>
        <td><input type="button" name="submit1" onclick="clickSubmit()" value="Update" /></td>
    </tr>
</table>    
</form>
<?php include_once "../include/footer.php"; ?>
