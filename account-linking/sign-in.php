<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');
session_start();

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Authenticate user with a Traditional Account
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'form' => 'signInForm',
        'signInEmailAddress' => $_POST['email'],
        'currentPassword' => $_POST['password']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.'/oauth/auth_native_traditional');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);

    // Write access token to session data as it is required for linking and
    // unlinking social accounts.
    $_SESSION['access_token'] = $api_response->access_token;
    session_write_close();
    header('Location: index.php');
    die();
}

?>
<html>
    <head>
        <title>Account Linking</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Account Linking</h1>
        <hr>
        <div class="content">
            <p>
                You must be signed in to link additional accounts:
            </p>
            <form method="post" action="sign-in.php">
                <div><input type="text" name="email" placeholder="Email address"></div>
                <div><input type="password" name="password" placeholder="Password"></div>
                <input type="submit" value="Sign In">
            </form>
        </div>
    </body>
</html>