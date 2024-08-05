<?php

$errorMSG = "";

// Sanitize and validate input
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = sanitize_input($_POST["name"]);
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errorMSG .= "Invalid email format ";
} else {
    $email = sanitize_input($_POST["email"]);
}


// MESSAGE
if (empty($_POST["message"])) {
    $errorMSG .= "Message is required ";
} else {
    $message = sanitize_input($_POST["message"]);
}

// If there are no errors, output success message
if ($errorMSG == "") {
    echo "Form submitted successfully!";
} else {
    echo $errorMSG;
}

?>
