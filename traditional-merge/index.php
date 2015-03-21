<?php
require('../config.php');

if (!empty($_POST['token'])) {

    // The 'token' parameter is the "Engage Token" from Janrain Social Login.
    // Assuming there is already a user record with the same email address as
    // the email addressed returned by the provider, a call to
    // /oauth/auth_native will fail with error code 380. This will setup a
    // state in which Janrain is expecting a merge_token to be passed into a
    // call authenticating the existing traditional account.

    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'code',
        'redirect_uri' => 'https://localhost',
        'thin_registration' => 'true',
        'token' => $_POST['token']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.'/oauth/auth_native');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);

    // The 380 error code indicates a user with this email address already
    // exists and the "capture" existing_provider indicates that the existint
    // record is a Traditional account.

    if ($api_response->stat == "error" && $api_response->code == 380
        && $api_response->existing_provider = "capture") {
        header("Location: merge.php?merge_token=".$_POST['token']);
        die();
    }
}

?>
<html>
    <head>
        <title>Traditional Merge</title>
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
        <h1>Traditional Merge</h1>
        <hr>
        <div class="content">
            <p>
                Sign in with a social provider which returns the same email
                address as your existing traditional account. (<a
                href="../traditional-registration/">Click here</a> if you have not
                yet created a traditional account).
            </p>
            <div id="janrainEngageEmbed"></div>
            <h3>/oauth/auth_native Response:</h3>
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