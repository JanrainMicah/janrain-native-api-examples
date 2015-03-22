<?php 
    //Grab the token
    $token = $_GET['var_token'];

    $api_call = '/oauth/auth_native';
    $captureUrl = 'https://janrain-se-demo.eval.janraincapture.com';
    $params = array(
        'client_id' => 'q2qt9q3xv28zap6r6u8ys4j7p5dt6qtd',
        'redirect_uri' => 'http://localhost/',
        'flow' => 'nvidia_poc_demo',
        'flow_version' => 'a034c36b-0644-4b61-a8bb-ad83ff9c5dca',
        'locale' => 'en-US',
        'response_type' => 'token',
        'token' => $token,
        'thin_registration' => 'false'
    );
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $captureUrl.$api_call);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    $api_response = json_decode(curl_exec($curl));
    curl_close($curl);
    
    //Logic to handle three different scenarios with social authentication
    if ($api_response->{'code'} == 310){
        //If email does not exist
        echo 'That email does not exist. This demo is social sign-in only.';
        echo '<br/>';
        echo '<pre>';
        echo json_encode($api_response, JSON_PRETTY_PRINT);
        echo '</pre>';
        
    } else if ($api_response->{'code'} == 380){
        //If merge needs to occur 
        echo 'That email exists, but with a different provider. This demo is social sign-in only.';
        echo '<br/>';
        echo '<pre>';
        echo json_encode($api_response, JSON_PRETTY_PRINT);
        echo '</pre>';
    } else {
        //If user exists, hand back access token
        $accessToken = $api_response->{'access_token'};
        echo 'Your access token is '. $accessToken; 
        echo '<br/>';
        echo '<pre>';
        echo json_encode($api_response, JSON_PRETTY_PRINT);
        echo '</pre>';
    }

?>