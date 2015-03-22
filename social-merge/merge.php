<?php
require('../config.example.php');

if (!empty($_GET['merge_token']) && !empty($_POST['token'])) {

    // The social authentication for the original social account
    // is passed to the /oauth/auth_native call much like a typical
    // social sign in, however, the merge_token is also passed to the call which will
    // link the social provider account to the existing social account.
    $api_call = '/oauth/auth_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'merge_token' => $_GET['merge_token'],
        'token' => $_POST['token']
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
        <title>Social Merge</title>
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
        <h1>Social Merge</h1>
        <hr>
        <div class="content">
            <p>
                There is an existing account with this email address. If you would like to 
                merge them, please authenticate with the original social account:
            </p>
            <div id="janrainEngageEmbed"></div>

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