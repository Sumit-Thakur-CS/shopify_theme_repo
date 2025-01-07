<?php

include_once ('includes/mysql_connect.php');


$api_key = 'a57295b3530c33e04b7340cb5bb103fe';
$secret_key = '65cd1a9e7cb9ffd7f4af62d8df122e73';
$parameters = $_GET;
$shop_url = $parameters['shop'];
$hmac = $parameters['hmac'];

// Remove the 'hmac' parameter from the list
$parameters = array_diff_key($parameters, ['hmac' => '']);
ksort($parameters);

// Generate the new HMAC and compare with the provided one
$new_hmac = hash_hmac('sha256', http_build_query($parameters), $secret_key);

if (hash_equals($hmac, $new_hmac)) {
    // Define the endpoint for the access token
    $access_token_endpoint = 'https://' . $shop_url . '/admin/oauth/access_token';

    // Prepare data for the access token request
    $var = [
        "client_id" => $api_key,
        "client_secret" => $secret_key,
        "code" => $parameters['code']
    ];

    // Initialize cURL session
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $access_token_endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);  // Set to true to send a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($var));
    
    // Disable SSL certificate verification (only for development)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    

    // Close the cURL session
    curl_close($ch);

    // Check for cURL errors
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        // Decode the JSON response into an associative array
        $response = json_decode($response, true);

        // Check if the response contains an access token
        if (isset($response['access_token'])) {
            echo 'Access Token: ' . $response['access_token'];


            $query = "INSERT INTO shops (shop_url, access_token,install_date) VALUES ('" . $shop_url ."','" . $response['access_token'] ."',Now()) ON DUPLICATE KEY UPDATE access_token='" .  $response['access_token']  ."'";

            if($mysql->query($query))
            {
                header("Location: https://" . $shop_url . '/admin/apps');
                
                exit();
            }




        } else {
            echo 'Error: No access token received. Response: ';
            print_r($response);
        }
    }
} else {
    echo 'HMAC validation failed.';
}
?>
