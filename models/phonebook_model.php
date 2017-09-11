<?php
class Phonebook_Model{
 
    // database connection and table name
    private $conn;
    private $table_name = "phonebook";
 
    // object properties
    public $id;
    public $name;
    public $number;
    public $isactive;
    public $adddate;
    public $updatedate;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                id, name, number, adddate, updatedate
            FROM
                " . $this->table_name . "
            ORDER BY
                name ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }
    
    // used for paging items
    public function countAll(){

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    
    function get_item(){

        $query = "SELECT
                    name, number, isactive, adddate, updatedate
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->number = $row['number'];
        $this->isactive = $row['isactive'];
        $this->adddate = $row['adddate'];
        $this->updatedate = $row['updatedate'];
    }

    // create item
    function create(){
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, number=:number, isactive=:isactive, adddate=:adddate";
 
        // ** check if exist
        $phonebook_class = new Phonebook_Model($this->conn);
        $num_name_exist = $phonebook_class->is_exist($this->name,"");    // is name exist
        $num_number_exist = $phonebook_class->is_exist("", $this->number);  // is number exist
        if($num_name_exist >0 || $num_number_exist>0)
        {
            return 2;  //name or number already exist!
        }
        //******
        
        $stmt = $this->conn->prepare($query);
        
        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->isactive=htmlspecialchars(strip_tags($this->isactive));
        $this->adddate = date('Y-m-d H:i:s');
 
        // bind values 
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":isactive", $this->isactive);
        $stmt->bindParam(":adddate", $this->adddate);
 
        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }
 
    }
    
    // edit item
    function update(){
        if(!isset($this->id))
            return false;
        
         //write query
        $query = "Update
                    " . $this->table_name . "
                SET
                    name=:name, number=:number, isactive=:isactive, updatedate=:updatedate WHERE id=:id";
 
        $stmt = $this->conn->prepare($query);
 
        // ** check if exist
        $phonebook_class = new Phonebook_Model($this->conn);
        $num_name_exist = $phonebook_class->is_exist($this->name,"",$this->id);    // is name exist
        $num_number_exist = $phonebook_class->is_exist("", $this->number, $this->id);  // is number exist
        if($num_name_exist >0 || $num_number_exist>0)
        {
            return 2;  //name or number already exist!
        }
        //******
        
        // posted values
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->isactive=htmlspecialchars(strip_tags($this->isactive));
        $this->updatedate = date('Y-m-d H:i:s');
 
        // bind values 
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":isactive", $this->isactive);
        $stmt->bindParam(":updatedate", $this->updatedate);
 
        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }
 
    }
    
    // edit book number
    function update_number(){
        if(!isset($this->id))
            return false;
        
         //write query
        $query = "Update
                    " . $this->table_name . "
                SET
                    number=:number, updatedate=:updatedate WHERE id=:id";
 
        $stmt = $this->conn->prepare($query);
        
        // ** check if exist
        $phonebook_class = new Phonebook_Model($this->conn);
        $num_number_exist = $phonebook_class->is_exist("", $this->number, $this->id);  // is number exist
        if($num_number_exist>0)
        {
           return 2;  //name or number already exist!
        }
        //******
        //
        // posted values
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->updatedate = date('Y-m-d H:i:s');
 
        // bind values 
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":updatedate", $this->updatedate);
 
        if($stmt->execute()){
            return 1;
        }else{
            return 0;
        }
 
    }
    
    // delete the item
    function delete(){
        
        if(!isset($this->id))
            return false;
        
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    // check if the item exist
    function is_exist($name, $number, $id=0){
        
        if(empty($name) && empty($number))
            return 0;
        
        $query = "SELECT name, number
                FROM
                    " . $this->table_name . "
                WHERE ";
            if(!empty($name)) {
                $query .= "name=:name ";
            }else if(!empty($number)){
                $query .= "number=:number ";
            }
            if($id != 0)
            {
                $query .= "AND id!=:id ";
            }
        $stmt = $this->conn->prepare( $query );
        
        //clear variables
        $name=htmlspecialchars(strip_tags($name));
        $number=htmlspecialchars(strip_tags($number));
        $id = htmlspecialchars(strip_tags($id));
        
        //bind parameters
        if(!empty($name)) {
            $stmt->bindParam(":name", $name);
        }else if(!empty($number)){
            $stmt->bindParam(":number", $number);
        }
        if($id != 0){
            $stmt->bindParam(":id", $id);
        }
        
        $stmt->execute();
        $num = $stmt->rowCount();
        return $num;
        
    }
    
    
}
?>