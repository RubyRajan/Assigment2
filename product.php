<?php
 
$db_connection_status = mysqli_connect("localhost", "root", "", "ewebsitedb");
 
if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}
 
$connection = $db_connection_status;
 
//GET Request for getting the data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // SQL query to select all data from the product table
        $sql_query = "SELECT * FROM product";
       
        // Execute the query
        $result = mysqli_query($connection, $sql_query);
       
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Array to store the rows
            $product = array();
           
            // Fetch rows and add them to the product array
            while ($row = mysqli_fetch_assoc($result)) {
                $product[] = $row;
            }
           
            // Output the data as JSON
            echo json_encode($product);
        } else {
            // No rows found
            echo "No records found";
        }
    }
 
    // Step 2: Handle POST request to insert data
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $description = $_POST['description'];
    $image = $_POST['image'];
    $pricing = $_POST['pricing'];
    $shipping_cost = $_POST['shipping_cost'];
    $product_name = $_POST['product_name'];
   
    // SQL query to insert data into the product table
    $sql_query = "INSERT INTO product (description, image, pricing, shipping_cost, product_name)
            VALUES ('$description', '$image', '$pricing', '$shipping_cost','$product_name')";
   
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
    $product_id = $data['product_id'];
    $description = $data['description'];
    $image = $data['image'];
    $shipping_cost = $data['shipping_cost'];
    $product_name = $data['product_name'];
   
    // SQL query to update data in the product table
    $sql_query = "UPDATE product
            SET description ='$description',  image='$image',
             shipping_cost='$shipping_cost', product_name='$product_name'
            WHERE product_id='$product_id'";
   
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
    $product_id = $data['product_id'];
   
    // SQL query to delete data from the user table based on username
    $sql_query = "DELETE FROM product WHERE product_id='$product_id'";
   
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