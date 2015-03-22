<html>
    <head>
        <title>Social Authentication</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
        <!--jQuery used for ajax token post-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!--Social authentication and token handling-->
        <script>
        //Initial social authentication and settings
        //To configure the social settings in the Janrain dashaboard to generate this code,
        //see developers portal: http://developers.janrain.com/how-to/social-login/deploy-social-login/
        (function() {
            if (typeof window.janrain !== 'object') window.janrain = {};
            if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};

            /* _______________ can edit below this line _______________ */

            janrain.settings.tokenAction='event';
            janrain.settings.tokenUrl = 'http://localhost';
            janrain.settings.type = 'embed';
            janrain.settings.appId = 'jfhdhnphmnoonffnahjn';
            janrain.settings.appUrl = 'https://janrain-se-demo.rpxnow.com';
            janrain.settings.providers = ["google","facebook"];
            janrain.settings.language = 'en';
            janrain.settings.linkClass = 'janrainEngage';

            /* _______________ can edit above this line _______________ */

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
              e.src = 'https://rpxnow.com/js/lib/janrain-se-demo/engage.js';
            } else {
              e.src = 'http://widget-cdn.rpxnow.com/js/lib/janrain-se-demo/engage.js';
            }

            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(e, s);

        })();

        //The token is handed back to the client side and posted to the social-api script
        var janrainWidgetOnload = function () {
            janrain.events.onProviderLoginToken.addHandler(function (data) {
                if(typeof data.token != "undefined"){
                    if (console && typeof console != "undefined"){
                        var var_token = data.token;
                        $.ajax({
                            url: 'social-api.php',
                            type: 'GET',
                             data: { var_token: var_token },
                             success: function(data) {
                                 $('#result').html(data);
                             }
                         });
                    }
                    document.getElementById("socialAuthentication").style.display='none';
                }else{
                    console.log("Invalid Data Retrieved");
                }
            }); 
        }
        </script>
    </head>
    <body>
        
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Social Sign-In</h1>
        <hr>
        <div id="socialAuthentication">
            <div id="janrainEngageEmbed"></div>
        </div>
        <div class="content">

            <h3>/oauth/auth_native Response:</h3>
            <div id="result"></div>
        </div>
    </body>
</html>