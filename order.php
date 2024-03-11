<?php
 
$db_connection_status = mysqli_connect("localhost", "root", "", "ewebsitedb");
 
if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}
 
$connection = $db_connection_status;
 
//GET Request for getting the data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // SQL query to select all data from the order table
        $sql_query = "SELECT * FROM `order`";
       
        // Execute the query
        $result = mysqli_query($connection, $sql_query);
       
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Array to store the rows
            $order = array();
           
            // Fetch rows and add them to the order array
            while ($row = mysqli_fetch_assoc($result)) {
                $order[] = $row;
            }
           
            // Output the data as JSON
            echo json_encode($order);
        } else {
            // No rows found
            echo "No records found";
        }
    }
 
    // Step 2: Handle POST request to insert data
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $recording_of_a_sale = $_POST['recording_of_a_sale'];
    
   
    // SQL query to insert data into the order table
    $sql_query = "INSERT INTO `order` (recording_of_a_sale)
            VALUES ('$recording_of_a_sale')";
   
    // Execute the query
    if (mysqli_query($connection, $sql_query)) {
        // Insertion successful
        echo "Record inserted successfully";
    } else {
        // Insertion failed
        echo "Error: " . $sql_query . "<br>" . mysqli_error($connection);
    }
}
    // update the data into the database
    else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Parse JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
   
    // Extract data
    $order_id = $data['order_id'];
    $recording_of_a_sale = $data['recording_of_a_sale'];
   
    // SQL query to update data in the order table
    $sql_query = "UPDATE `order`
            SET recording_of_a_sale ='$recording_of_a_sale'  
            WHERE order_id='$order_id'";
   
    // Execute the query
    if (mysqli_query($connection, $sql_query)) {
        // Update successful
        echo "Record updated successfully";
    } else {
        // Update failed
        echo "Error: " . $sql_query . "<br>" . mysqli_error($connection);
    }
}
 
 
//DELETE request to delete data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
   
    // Extract username
    $order_id = $data['order_id'];
   
    // SQL query to delete data from the user table based on username
    $sql_query = "DELETE FROM `order` WHERE order_id='$order_id'";
   
    // Execute the query
    if (mysqli_query($connection, $sql_query)) {
        // Deletion successful
        echo "Record deleted successfully";
    } else {
        // Deletion failed
        echo "Error: " . $sql_query . "<br>" . mysqli_error($connection);
    }
}
 
// Close the connection
mysqli_close($connection);
?>