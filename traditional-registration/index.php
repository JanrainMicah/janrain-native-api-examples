<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $api_call = '/oauth/register_native_traditional';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'form' => 'registrationForm',
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'displayName' => $_POST['displayName'],
        'emailAddress' => $_POST['email'],
        'newPassword' => $_POST['password'],
        'newPasswordConfirm' => $_POST['passwordConfirm']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);
}

?>
<html>
    <head>
        <title>Traditional Registration</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Traditional Registration</h1>
        <hr>
        <div class="content">

            <form method="post" action="index.php">
                <div><input type="text" name="firstName" placeholder="First Name"></div>
                <div><input type="text" name="lastName" placeholder="Last Name"></div>
                <div><input type="text" name="displayName" placeholder="Display Name"></div>
                <div><input type="text" name="email" placeholder="Email address"></div>
                <div><input type="password" name="password" placeholder="Password"></div>
                <div><input type="password" name="passwordConfirm" placeholder="Confirm Password"></div>
                <input type="submit" value="Register">
            </form>

            <?php
            if (isset($api_response)) {
                echo "<h3>$api_call Response:</h3>";
                echo '<pre>';
                echo json_encode($api_response, JSON_PRETTY_PRINT);
                echo '</pre>';
            }
            ?>
        </div>
    </body>
</html>