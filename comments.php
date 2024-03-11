<?php
 
$db_connection_status = mysqli_connect("localhost", "root", "", "ewebsitedb");
 
if ($db_connection_status === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}
 
$connection = $db_connection_status;
 
//GET Request for getting the data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // SQL query to select all data from the comments table
        $sql_query = "SELECT * FROM comments";
       
        // Execute the query
        $result = mysqli_query($connection, $sql_query);
       
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Array to store the rows
            $comments = array();
           
            // Fetch rows and add them to the comments array
            while ($row = mysqli_fetch_assoc($result)) {
                $comments[] = $row;
            }
           
            // Output the data as JSON
            echo json_encode($comments);
        } else {
            // No rows found
            echo "No records found";
        }
    }
 
    // Step 2: Handle POST request to insert data
  else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $product = $_POST['product'];
    $users = $_POST['users'];
    $rating = $_POST['rating'];
    $images = $_POST['images'];
    $text = $_POST['text'];
     
    // SQL query to insert data into the comments table
    $sql_query = "INSERT INTO comments (product, users, rating,images,text)
            VALUES ('$product', '$users', '$rating','$images','$text')";
   
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
    $comment_id = $data['comment_id'];
    $product = $_POST['product'];
    $users = $_POST['users'];
    $rating = $_POST['rating'];
    $images = $_POST['images'];
    $text = $_POST['text'];
   
    // SQL query to update data in the comments table
    $sql_query = "UPDATE comments
            SET product ='$product', 
             users='$users',  rating='$rating' ,  images='$images', 
             text ='$text'
            WHERE cart_id='$comment_id'";
   
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
    $cart_id = $data['comment_id'];
   
    // SQL query to delete data from the user table based on id
    $sql_query = "DELETE FROM comments WHERE product_id='$comment_id'";
   
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