<?php
require('auth_native.php');
require('register_native.php');
?>
<html>
    <head>
        <title>Social Registration</title>
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
        <h1>Social Sign in and Registration</h1>
        <hr>
        <div class="content">
            
            <p>
                Either sign in with an existing account or register a new one. 
            </p>
            
            <div id="janrainEngageEmbed"></div>
            <br/>
            <form method="post" action="index.php">
                <div><input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName ?>"></div>
                <div><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?>"></div>
                <div><input type="text" name="displayName" placeholder="Display Name" value="<?php echo $displayName ?>"></div>
                <div><input type="text" name="email" placeholder="Email address" value="<?php echo $emailAddress ?>"></div>
                <div><input type="hidden" name="token" value="<?php echo $token ?>"></div>
                <input type="submit" value="Register">
            </form>

            <?php
            if (isset($api_response)) {
                if (!empty($accessToken)) {
                    echo "<h2>Your access token is $accessToken</h2>";
                }
                echo "<h3>$api_call Response:</h3>";
                echo '<pre>';
                echo json_encode($api_response, JSON_PRETTY_PRINT);
                echo '</pre>';
            }
            ?>
        </div>
    </body>
</html>