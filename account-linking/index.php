<?php
require('../config.php');

// A valid access token is required to link and unlink social profiles. If an
// access token is not found in the session vars, redirect to a sign-in page.
session_start();
if (empty($_SESSION['access_token'])) {
    header('Location: sign-in.php');
    die();
}

if (!empty($_POST['identifier'])) {

    // Unlink Google+ account

    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'access_token' => $_SESSION['access_token'],
        'identifier_to_remove' => $_POST['identifier']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.'/oauth/unlink_account_native');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);

} elseif (!empty($_POST['token'])) {

    // Link Google+ account

    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'redirect_uri' => 'https://localhost',
        'access_token' => $_SESSION['access_token'],
        'token' => $_POST['token']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.'/oauth/link_account_native');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);
}


// Get the user's profile and iterate over the "profiles" plural looking for
// Google+. If found, the "identifier" attribute is needed to unlink the
// account.
$params = array(
    'access_token' => $_SESSION['access_token'],
    'type_name' => 'user',
    'attributes' => '["profiles.domain","profiles.identifier"]'
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.'/entity');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

$response = json_decode(curl_exec($curl));
curl_close($curl);

if ($response->stat == "error" && $response->code == 200) {
    // access token is expired
    unset($_SESSION['access_token']);
    header('Location: sign-in.php');
    die();
}
foreach ($response->result->profiles as $profile) {
    if ($profile->domain == "google.com") {
        $google_id = $profile->identifier;
    }
}


?>
<html>
    <head>
        <title>Account Linking</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <script>
        (function() {
            if (typeof window.janrain !== 'object') window.janrain = {};
            if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};

            janrain.settings.tokenUrl = window.location.href;

            function isReady() { janrain.ready = true; };
            if (document.addEventListener) {
              document.addEventListener("DOMContentLoaded", isReady, false);
            } else {
              window.attachEvent('onload', isReady);
            }

            var e = document.createElement('script');
            e.type = 'text/javascript';
            e.id = 'janrainAuthWidget';

            if (document.location.protocol === 'https:') {
              e.src = 'https://rpxnow.com/js/lib/maple/engage.js';
            } else {
              e.src = 'http://widget-cdn.rpxnow.com/js/lib/maple/engage.js';
            }

            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(e, s);
        })();
        </script>
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Account Linking</h1>
        <hr>
        <div class="content">
            <?php if (!isset($google_id)) { ?>
                <h3>Link Google+ Account</h3>
                <a href="#" onclick="janrain.engage.signin.triggerFlow('googleplus')">
                    <img src="http://cdn.quilt.janrain.com/2.2.17/icons/janrain-providers/24/googleplus.png">
                </a>
            <?php } else { ?>
                <h3>Unlink Google+ Account</h3>
                <form method="post" action="index.php">
                    <input type="hidden" name="identifier" value="<?php echo $google_id ?>">
                    <input type="image" src="http://cdn.quilt.janrain.com/2.2.17/icons/janrain-providers/24/googleplus.png">
                </form>
            <?php } ?>

            <h3>API Response:</h3>
            <?php
            if (isset($api_response)) {
                echo '<pre>';
                echo json_encode($api_response, JSON_PRETTY_PRINT);
                echo '</pre>';
            }
            ?>
        </div>
    </body>
</html>