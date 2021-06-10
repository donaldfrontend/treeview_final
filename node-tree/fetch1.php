<?php

include('database_connection.php');


$parent_category_id = 0;

$query = "SELECT * FROM tbl_category";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll(); 

$output = array();

foreach($result as $row)
{   

    /* get_node_data work recursevly and
     will make N-Level data in array format and store them under $data variable*/
    $data = get_node_data($parent_category_id, $connect);
}


// array_value fct will only return array value and convert into json string using JSON encode fct
echo json_encode(array_values($data));


//this function will return a level node of parent category
function  get_node_data($parent_category_id, $connect)
{
$query = "SELECT * FROM tbl_category WHERE parent_category_id = '".$parent_category_id"'";

$statement = $connect->prepare($query);

$statement->execute();

//fetch qeury result and store hem is $result
$result = $statement->fetchAll();

//we store data for treeview
$output = array();


//we fetch data from $result variable
foreach($result as $row)
{
    $sub_array = array();
    $sub_array['text'] = $row['category_name'];
    $sub_array['nodes'] = array_values(get_node_data($row['category_id'], $connect));
   
    //we store data from sub_array into $output variable
    $output = $sub_array; 
}

//we return the final outup of this funt

return $output;

}


?>