<?php
require(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php');

//After the auth_native API is called and the user does not exist, the register_native
//call will create the user record
if (!empty($_POST['email']) && !empty($_POST['token'])) {
    $api_call = '/oauth/register_native';
    $params = array(
        'client_id' => JANRAIN_LOGIN_CLIENT_ID,
        'locale' => 'en-US',
        'response_type' => 'token',
        'redirect_uri' => 'https://localhost',
        'form' => 'socialRegistrationForm',
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'displayName' => $_POST['displayName'],
        'emailAddress' => $_POST['email'],
        'token' => $_POST['token']
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, JANRAIN_CAPTURE_URL.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $api_response = json_decode(curl_exec($curl));
    $accessToken = $api_response->{'access_token'};
    curl_close($curl);
}
?>