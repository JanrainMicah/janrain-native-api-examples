<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');
if (!empty($_POST['token'])) {
    // This demo is social sign in only. User must have an existing account using the same
    //social provider. There is some logic that handles different scenarios. 
    $api_call = '/oauth/auth_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'thin_registration' => 'true',
        'token' => $_POST['token']
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);
    
    //Logic to handle three different scenarios with social authentication
    if ($api_response->{'code'} == 310){
        //If email does not exist
        $userResponse = 'That email does not exist. This demo is social sign-in only.';
    } else if ($api_response->{'code'} == 380){
        //If merge needs to occur 
        $userResponse = 'That email exists, but with a different provider. This demo is social sign-in only.';
    } else if ($api_response->{'stat'} == 'ok'){
        //If user exists, hand back access token
        $accessToken = $api_response->{'access_token'};
        $userResponse = 'Your access token is '. $accessToken; 
    } else {
        echo '';
    }
}
?>
<html>
    <head>
        <title>Social Sign In</title>
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
        <h1>Social Sign In</h1>
        <hr>
        <div class="content">
            <p>
                For this demo, you must already have an existing social account. 
                Sign in with a social provider that you have used previously (<a
                href="../social-registration/">Click here</a> if you have not
                yet created a social account).
            </p>
            <div id="janrainEngageEmbed"></div>
            <br/>

            <?php
            if (isset($api_response)) {
                echo "<h2>$userResponse</h2>";
                echo "<h3>$api_call Response:</h3>";
                echo '<pre>';
                echo json_encode($api_response, JSON_PRETTY_PRINT);
                echo '</pre>';
            }
            ?>
        </div>
    </body>
</html>