<?php include_once "../include/header.php"; 

// include database and object files
include_once '../include/conn.php';
include_once '../models/phonebook_model.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

$phonebook = new Phonebook_Model($db);

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
        
        var name = $('#name').val();
        var number = $('#number').val();
        var isactive = $('#chkActive').val();
        $.ajax({
                url: "../phonebooks/ajax_phonebooks.php",
                type: "POST",
                data: {"name":name, "number":number,"isactive":isactive},
                success: function(data)
                {
                    if(data == "1"){
                        $('#errors').html('data inserted successfully.');
                        //$('#form1').clear();
                    }else if(data == "0")
                    {
                        $('#errors').html('error in data, please try again!');
                    }
                }
            });
            
        return true;
    }
</script>
<h2></h2>
<form id="form1" name="form1" action="" method="post">
<table>
    <div id="errors" name="errors" class="error"></div>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" size="50" value="" class="form-control" />
    </div>
    <div class="form-group">
        <label for="number">Number: </label> 
        <input type="text" class="form-control" id="number" name="number" value="" class="form-control" />
    </div>
    <div class="form-group">
        <label for="txtDescAr">Active: </label>
        <input type="checkbox" name="chkActive" id="chkActive" value="1">
    </div>
    <tr>
        <td></td>
        <td><input type="button" name="submit1" onclick="clickSubmit()" value="Create new item" /></td>
    </tr>
</table>    
</form>
<?php include_once "../include/footer.php"; ?>
