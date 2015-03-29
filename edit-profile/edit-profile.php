<?php
    session_start(); 
    $accessToken = $_SESSION["token"];
    require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');
    //Entity call retrieves the user information to pre-populate the Edit Profile fields
    $entity_api_call = '/entity';
    $entityParams = array(
        'type_name' => 'user',
        'access_token' => $accessToken
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$entity_api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($entityParams));
    $entity_response = json_decode(curl_exec($curl));

    $firstName = $entity_response->result->givenName;
    $lastName = $entity_response->result->familyName;
    $displayName = $entity_response->result->displayName;
    $email = $entity_response->result->email;
    curl_close($curl);

    //Save the Edit Profile form fields
    $entity_api_call = '/entity';
    $entityParams = array(
        'type_name' => 'user',
        'access_token' => $accessToken
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$entity_api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($entityParams));
    $entity_response = json_decode(curl_exec($curl));


    if (!empty($_POST['email']) && isset($_POST['submit'])) {
        $api_call = '/oauth/update_profile_native';
        $params = array(
            'client_id' => JANRAIN_LOGIN_CLIENT_ID,
            'locale' => 'en-US',
            'access_token' => $accessToken,
            'form' => 'editProfileForm',
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'displayName' => $_POST['displayName'],
            'emailAddress' => $_POST['email']
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
        <title>Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="../css/styles.css">
    </head>
    <body>
        <img src="../img/janrain-logo.png" class="logo">
        <h1>Edit Profile</h1>
        <hr>
        <div class="content">
            
            <form method="post" action="edit-profile.php">
                <div><input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName ?>"></div>
                <div><input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?>"></div>
                <div><input type="text" name="displayName" placeholder="Display Name" value="<?php echo $displayName ?>"></div>
                <div><input type="text" name="email" placeholder="Email address" value="<?php echo $email ?>"></div>
                <input type="submit" name="submit" value="Save">
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