<?php
// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Check if the request method is POST
if ($method == 'POST') {
    // Get the request body as an object
    $data = json_decode(file_get_contents('php://input'));

    // Validate the data
    if (isset($data->name) && isset($data->email) && isset($data->password)) {
        // Connect to the database
        $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

        // Escape the data
        $name = mysqli_real_escape_string($conn, $data->name);
        $email = mysqli_real_escape_string($conn, $data->email);
        $password = mysqli_real_escape_string($conn, $data->password);

        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the data into the database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        $result = mysqli_query($conn, $sql);

        // Check the result
        if ($result) {
            // Success
            // Get the last inserted ID
            $id = mysqli_insert_id($conn);

            // Set the response header for the status code and content type
            header('HTTP/1.1 201 Created');
            header('Content-Type: application/json');

            // Set the response body as an object
            $response = array('id' => $id);
        } else {
            // Error
            // Get the error message
            $error = mysqli_error($conn);

            // Set the response header for the status code and content type
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');

            // Set the response body as an object
            $response = array('error' => $error);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        // Invalid data
        // Set the response header for the status code and content type
        header('HTTP/1.1 400 Bad Request');
        header('Content-Type: application/json');

        // Set the response body as an object
        $response = array('error' => 'Missing or invalid data');
    }

    // Send the response as a JSON string
    echo json_encode($response);
} else {
    // Unsupported method
    // Set the response header for the status code and content type
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');

    // Set the response body as an object
    $response = array('error' => 'Unsupported method');

    // Send the response as a JSON string
    echo json_encode($response);
}
?>
