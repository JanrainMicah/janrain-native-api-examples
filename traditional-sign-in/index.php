<?php
require('../config.php');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $api_call = '/oauth/auth_native_traditional';
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
        <title>Traditional Sign In</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Traditional Sign In</h1>
        <hr>
        <div class="content">

            <form method="post" action="index.php">
                <div><input type="text" name="email" placeholder="Email address"></div>
                <div><input type="password" name="password" placeholder="Password"></div>
                <input type="submit" value="Sign In">
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