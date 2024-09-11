<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

    // Insert the data into the database
    $sql = "INSERT INTO users (firstname, email, password) VALUES ('$firstname', '$email', '$password')";
    mysqli_query($conn, $sql);

    // Send an email to the user
    $to = $email;
    $subject = 'Registration successful';
    $message = 'Thank you for registering!';
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}
?>
