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
            return true;
        }else{
            return false;
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
            return true;
        }else{
            return false;
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
 
        // posted values
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->number=htmlspecialchars(strip_tags($this->number));
        $this->updatedate = date('Y-m-d H:i:s');
 
        // bind values 
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":number", $this->number);
        $stmt->bindParam(":updatedate", $this->updatedate);
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
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
    
    
}
?>