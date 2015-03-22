<?php 
    //API parameters
    $captureUrl = 'https://janrain-se-demo.eval.janraincapture.com/';
    $authNativeParams = array('client_id' => 'q2qt9q3xv28zap6r6u8ys4j7p5dt6qtd',
                               'redirect_uri' => 'http://localhost/',
                               'flow' => 'nvidia_poc_demo',
                               'locale' => 'en-US',
                               'response_type' => 'token',
                               'token' => $token,
                               'thin_registration' => 'false'
                               );

    //API Post function
    function callAPI($url, $data) {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $api_response = json_decode(curl_exec($curl));
        curl_close($curl);
        return $api_response;
    }

?>