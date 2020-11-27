<?php 
include "Database.php";

// -----Insert Data-----
 $obj = new Database();
 $obj->insert('stu_acc', array('name'=>'MH Hosen', 'age'=>27, 'class'=>16));
 echo "insert result is :";
 print_r($obj->getResult());

// -----Update Data-----
 $obj = new Database();
 $obj->update('stu_acc', array('name'=>'MH Manik Ahmed', 'age'=>22, 'class'=>15), "id = '7'");
 echo "update result is :";
 print_r($obj->getResult());

// -----Delete Data-----
 $obj = new Database();
 $obj->delete('stu_acc',"id='10'");
 echo "delete result is :";
 print_r($obj->getResult());


// -----Raw SQL Data-----
 $obj = new Database();
 $obj->sql("SELECT * FROM stu_acc");
 print_r($obj->getResult());

// -----Dynamic SQL Data-----
 $obj = new Database();
 $obj->select("stu_acc", "id, name", null, null, null, 2);
 print_r($obj->getResult());



?>