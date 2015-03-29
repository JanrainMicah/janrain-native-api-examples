<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');

if (!empty($_POST['token'])) {
    // This demo is for social registration. The first call is to see whether an email exists and to
    //get the prereg_fields to fill the registration form.
    //The register_native call is then used to register the user.
    $api_call = '/oauth/auth_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'thin_registration' => 'false',
        'token' => $_POST['token'],
        'registration_form' => 'socialRegistrationForm'
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $token = $_POST['token'];
    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);

    //Logic to handle three different scenarios with social authentication
    if ($api_response->{'code'} == 310){
        //If email does not exist, initial registration and get the prereg_fields
        $firstName = $api_response->{'prereg_fields'}->{'firstName'};
        $lastName = $api_response->{'prereg_fields'}->{'lastName'};
        $displayName = $api_response->{'prereg_fields'}->{'displayName'};
        $emailAddress = $api_response->{'prereg_fields'}->{'emailAddress'};
    } else if ($api_response->{'code'} == 380){
        //If merge needs to occur
        $userResponse = 'That email exists, but with a different provider. This demo is social registration only.';
    } else if ($api_response->{'stat'} == 'ok'){
        //If user exists, hand back access token
        $accessToken = $api_response->{'access_token'};
        $userResponse = 'Your access token is '. $accessToken;
    } else {

    }
}
?>