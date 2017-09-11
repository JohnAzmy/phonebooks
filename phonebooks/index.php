<?php include_once "../include/header.php"; 

// include database and object files
include_once '../include/conn.php';
include_once '../models/phonebook_model.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
$phonebook = new Phonebook_Model($db);

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 10;
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
$total_rows = $phonebook->countAll();
// calculate total pages
$total_pages = ceil($total_rows / $records_per_page);

// query items
$stmt = $phonebook->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
?>
<script type="text/javascript">
    function clickEditOnFly(divId){
        
        $('#divAjax'+divId).toggle();
    }
    
    function editAjax(id)
    {
        if($('#number'+id).val() == '')
        {
            $('#divMsg'+id).html('not valid!');
            return false;
        }else if(!$.isNumeric($('#number'+id).val())) {
            $('#divMsg'+id).html('not valid!');
            return false;
        }
        var num = $('#number'+id).val();
        $.ajax({
                url: "../phonebooks/ajax_phonebooks.php",
                type: "POST",
                data: {"id":id, "number":num, "type":3},
                success: function(data)
                {
                    if(data == "1"){
                        $('#divNumber'+id).html(num+'');
                        $('#divMsg'+id).html('edited!');
                    }else if(data == "2"){
                        $('#divMsg'+id).html('already exist!');
                    }else{
                        $('#divMsg'+id).html('error happened!');
                    }
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
            <td><div id="divNumber<?php echo($id)?>"><?php echo $number ?></div><div id="divMsg<?php echo($id)?>"></div>
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
<?php if($num>0) {?>
<ul class="pagination">
    <?php if($page>1){?>
        <li><a href='?page=<?php if($page>1)echo($page-1); ?>' title='Go to the first page.'>Previous</a></li>
    <?php } ?>
    <?php if($page < $total_pages){?>
        <li><a href='?page=<?php echo($page+1)?>' title='Go to the first page.'>Next</a></li>
    <?php } ?>
</ul>
<?php } ?>

<?php include_once "../include/footer.php"; ?>