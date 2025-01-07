<?php
$_API_KEY = 'a57295b3530c33e04b7340cb5bb103fe';
$_NGROK_URL='https://a7d3-14-97-132-58.ngrok-free.app';
$shop= $_GET['shop'];
$scopes= 'read_products,write_products,read_orders,write_orders';
$redirect_uri = $_NGROK_URL . '/loader/token.php';
$nonce= bin2hex( random_bytes( 12 ) );
$access_mode = 'per-user';

$oauth_url = 'https://' . $shop . '/admin/oauth/authorize?client_id=' . $_API_KEY
    . '&scope=' . $scopes
    . '&redirect_uri=' . urlencode($redirect_uri)
    . '&state=' . $nonce
    . '&grant_options[]=' . $access_mode;

echo $shop;


header("Location: " . $oauth_url);
exit();

// https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}

