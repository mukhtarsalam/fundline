<?php

session_start();
require_once("includes/functions.php");
require_once("includes/db_cons.php");
$errors = [];
$username = "";
$name = "";
$email = "";
$contact = "";
$password = "";
$password1 = "";
$password2 = "";

// connect to database
$db = mysqli_connect($servername, $db_user, $db_password, $database);
//registration
if (isset($_POST['register'])) {
    //receive all input value from
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $password1 = mysqli_real_escape_string($db, $_POST['password1']);
    $password2 = mysqli_real_escape_string($db, $_POST['password2']);
    $txref = "rave" . uniqid();
    $role = "user";

    //form validation
    //by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        array_push($errors, "Username is required!");
    }
    if (empty($name)) {
        array_push($errors, "Full Name is required!");
    }
    if (empty($email)) {
        array_push($errors, "email is required!");
    }
    if (empty($contact)) {
        array_push($errors, "Phone Number is required!");
    }

    if (empty($password1)) {
        array_push($errors, "Password is required!");
    }

    if ($password1 != $password2) {
        array_push($errors, "The two passwords do not match!");
    }
    //first check the database to make sure a user does not alredy exist with the same username or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }
    if (count($errors) == 0) {
        //encrypt the password before saving into database
        $password = md5($password1);
        $query = "INSERT INTO `users` (`id`, `username`, `name`, `email`, `contact`, `txref`, `password`, `role`)
                  VALUES (NULL, '{$username}', '{$name}', '{$email}', '{$contact}', '{$txref}', '{$password}', '{$role}')";
        if (mysqli_query($db, $query)) {
            $curl = curl_init();

            $customer_email = $_POST['email'];
            $amount = 2000;
            $currency = "NGN";
            $PBFPubKey = "FLWPUBK-0b278a109cecdfc33d50941e88cd1d2d-X";
            $redirect_url = "http://localhost/wecon/status.php"; //Set your own redirect URL


            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $amount,
                    'customer_email' => $customer_email,
                    'currency' => $currency,
                    'txref' => $txref,
                    'PBFPubKey' => $PBFPubKey,
                    'redirect_url' => $redirect_url,
                ]),
                CURLOPT_HTTPHEADER => [
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            if ($err) {
                //there was an error contacting the rave API
                die('Curl returned error:' . $err);
            }
            $transaction = json_decode($response);

            if (!$transaction->data && !$transaction->data->link) {
                // there was an error from the API
                print_r('API returned error: ' . $transaction->message);
            }
            // redirect to page so user can pay
            header('Location: ' . $transaction->data->link);
        }
    }
}
if (isset($_GET['token'])) {
    $_SESSION['token'] = mysqli_real_escape_string($db, $_GET['token']);
}

//Login
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $status = 1;

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND (password='$password' AND status='$status')";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            $user = mysqli_fetch_array($results);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['contact'] = $user['contact'];
            $_SESSION['email'] = $user['email'];
            redirect_to("dashboard.php");
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    // ensure that the user exists on our system
    $query = "SELECT email FROM users WHERE email='$email'";
    $results = mysqli_query($db, $query);

    if (empty($email)) {
        array_push($errors, "Your email is required");
    } else if (mysqli_num_rows($results) <= 0) {
        array_push($errors, "Sorry, no user exists on our system with that email");
    }
    // generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
        // store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
        $results = mysqli_query($db, $sql);

        // Send email to user with the token in a link they can click on
        $to = $email;
        $subject = "Reset your password on examplesite.com";
        $msg = "Hi there, click on this <a href=\"localhost/peakvest/new_pass.php?token=" . $token . "\">link</a> to reset your password on our site";
        $msg = wordwrap($msg, 70);
        $headers = "From: info@examplesite.com";
        mail($to, $subject, $msg, $headers);
        header('location: pending.php?email=' . $email);
    }
}

// ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

    // Grab to token that came from the email link
    $token = $_SESSION['token'];
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password do not match");
    if (count($errors) == 0) {
        // select email address of user from the password_reset table 
        $sql = "SELECT email FROM password_resets WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        if ($email) {
            $new_pass = md5($new_pass);
            $sql = "UPDATE users SET password='$new_pass' WHERE email='$email'";
            $results = mysqli_query($db, $sql);
            header('location: login.php');
        }
    }
}
