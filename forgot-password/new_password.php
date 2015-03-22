<?php
require('../config.php');

if (!empty($_GET['code'])) {

    // The 'code' is appended to the 'password_recover_url' Capture setting in
    // the email sent to the user. It is an Authorization Code which can be
    // exchanged for an access token using the /oauth/token API call.

    $api_call = '/oauth/token';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'client_secret' => JANRAIN_LOGIN_CLIENT_SECRET,
        'redirect_uri' => PASSWORD_RECOVER_URL,
        'grant_type' => 'authorization_code',
        'code' => $_GET['code']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);

    // Store the access token in a variable so that it can be added to the
    // change password form as a hidden form element.

    if ($api_response->stat == "ok") {
        $access_token = $api_response->access_token;
    }

} elseif (!empty($_POST['access_token']) && !empty($_POST['new_password'])) {

    // Use the /oauth/update_profile_native API call to submit a new password
    // using the 'changePasswordFormNoAuth' (Note: this is the default form
    // name in the standard configuration).

    $api_call = '/oauth/update_profile_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'access_token' => $_POST['access_token'],
        'locale' => 'en-US',
        'form' => 'changePasswordFormNoAuth',
        'newPassword' => $_POST['new_password'],
        'newPasswordConfirm' => $_POST['confirm_password']
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
                Enter a new password below. <a href="index.php">Click here</a>
                if you need to get a new authorization code.
            </p>
            <form method="post" action="new_password.php">
                <input type="hidden" name="access_token" value="<?php if (isset($access_token)) echo $access_token ?>">
                <div><input type="password" name="new_password" placeholder="Password"></div>
                <div><input type="password" name="confirm_password" placeholder="Confirm Password"></div>
                <input type="submit" value="Change Password">
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