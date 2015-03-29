<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');

if (!empty($_POST['email'])) {

    // The /oauth/forgot_password_native API call will send am email to the user
    // (assuming they exist in the database) with a link containing an
    // Authorization Code. The link in the email is determined by the
    // 'password_recover_url' Capture setting.

    $api_call = '/oauth/forgot_password_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'redirect_uri' => PASSWORD_RECOVER_URL,
        'locale' => 'en-US',
        'response_type' => 'code',
        'form' => 'forgotPasswordForm',
        'signInEmailAddress' => $_POST['email']
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
        <title>Forgot Password</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Forgot Password</h1>
        <hr>
        <div class="content">
            <p>
                Enter your email address to get a link to reset your password.
            </p>
            <form method="post" action="index.php">
                <div><input type="text" name="email" placeholder="Email address"></div>
                <input type="submit" value="Send Reset Password Email">
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