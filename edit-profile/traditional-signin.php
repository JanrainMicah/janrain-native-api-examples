<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');

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
    $accessToken = $api_response->{'access_token'};
    curl_close($curl);

    //Logic to handle three different scenarios with social authentication
    if ($api_response->{'code'} == 310){
        //If email does not exist
        $userResponse = 'That email does not exist. This demo is social sign-in only.';
    } else if ($api_response->{'code'} == 380){
        //If merge needs to occur
        $userResponse = 'That email exists, but with a different provider. This demo is social sign-in only.';
    } else if ($api_response->{'stat'} = 'ok' && $accessToken){
        session_start();
        $_SESSION["token"] = $accessToken;
        header("Location: edit-profile.php");
        die();
    } else {

    }
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

            <form method="post" action="traditional-signin.php">
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