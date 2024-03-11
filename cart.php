<?php
 
$db_connection_status = mysqli_connect("localhost", "root", "", "ewebsitedb");
 
if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}
 
$connection = $db_connection_status;
 
//GET Request for getting the data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // SQL query to select all data from the cart table
        $sql_query = "SELECT * FROM cart";
       
        // Execute the query
        $result = mysqli_query($connection, $sql_query);
       
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Array to store the rows
            $cart = array();
           
            // Fetch rows and add them to the cart array
            while ($row = mysqli_fetch_assoc($result)) {
                $cart[] = $row;
            }
           
            // Output the data as JSON
            echo json_encode($cart);
        } else {
            // No rows found
            echo "No records found";
        }
    }
 
    // Step 2: Handle POST request to insert data
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $user = $_POST['user'];
     
    // SQL query to insert data into the cart table
    $sql_query = "INSERT INTO cart (products, quantities, user)
            VALUES ('$products', '$quantities', '$user')";
   
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
    $cart_id = $data['cart_id'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $user = $_POST['user'];
   
    // SQL query to update data in the cart table
    $sql_query = "UPDATE cart
            SET products ='$products', 
             quantities='$quantities'
            WHERE cart_id='$cart_id'";
   
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
    $cart_id = $data['cart_id'];
   
    // SQL query to delete data from the user table based on username
    $sql_query = "DELETE FROM cart WHERE product_id='$cart_id'";
   
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