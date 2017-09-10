<?php include_once "../include/header.php"; 

// include database and object files
include_once '../include/conn.php';
include_once '../models/phonebook_model.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

$phonebook = new Phonebook_Model($db);
// query items
$stmt = $phonebook->readAll(0, 100);
$num = $stmt->rowCount();
?>
<script type="text/javascript">
    function clickEditOnFly(divId){
        $('#divAjax'+divId).show();
    }
    function editAjax(id)
    {
        var num = $('#number'+id).val();
        $.ajax({
                url: "../phonebooks/ajax_phonebooks.php",
                type: "POST",
                data: {"id":id, "number":num, "type":3},
                success: function(data)
                {
                    $('#divAjax'+id).html('edited!');
                }
            });
    }
    
    function deleteAjax(id)
    {
        if(confirm('Are you sure you want to delete?'))
        {
            $.ajax({
                    url: "../phonebooks/ajax_phonebooks.php",
                    type: "POST",
                    data: {"id":id, "type":2},
                    success: function(data)
                    {
                        $('#divInfo'+id).html('deleted!');
                    }
                });
        }
    }
</script>
<h2></h2>
 
<table border='1' class="table" cellpadding='4'>
    <tr>
        <td><strong>Title</strong></td>
        <td><strong>Content</strong></td>
        <td><strong>Date</strong></td>
        <td><strong>Action</strong></td>
    </tr>
<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);?>
        <tr>
            <td><?php echo $name ?></td>
            <td><?php echo $number ?>
                <div id="divAjax<?php echo($id)?>" style="display: none"> <input type="text" name="number<?php echo($id)?>" id="number<?php echo($id)?>" value="<?php echo $number; ?>" class="form-control input-sm">
                    <input type="button" name="button" onclick="editAjax(<?php echo $id ?>)" value="edit">
                </div>           
            </td>
            <td><?php echo $adddate ?></td>
            <td>
                <a href="javascript:;" onclick="clickEditOnFly(<?php echo($id)?>);" name="editOnFly<?php echo($id)?>">Edit Number AJAX</a> | 
                <a href="../phonebooks/edit.php?id=<?php echo $id ?>">Edit</a> | 
                <a href="javascript:;" onClick="deleteAjax(<?php echo($id)?>)">Delete</a>
                <div id="divInfo<?php echo($id)?>"></div>
            </td>
        </tr>
<?php } ?>
</table>

<?php include_once "../include/footer.php"; ?>