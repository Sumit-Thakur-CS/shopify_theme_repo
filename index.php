<?php
 echo "<a href='https://a7d3-14-97-132-58.ngrok-free.app/loader/script.php'>Script Page</a>";
include_once("includes/mysql_connect.php");
$parameters = $_GET;

$query = "SELECT * FROM shops WHERE shop_url='" . $parameters['shop'] . "' LIMIT 1";
$result = $mysql->query($query);

if($result->num_rows < 1){
    header("Location: install.php?shop=" . $_GET['shop']);
    exit();

}

$store_data = $result->fetch_assoc();


// $storeDomain = $store_data['shop_url'];
// $accessToken = $store_data['access_token'];
// $url = "https://{$storeDomain}/admin/api/2023-10/products.json";
// $ch = curl_init();
// curl_setopt_array($ch, [
//     CURLOPT_URL => $url,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification (not recommended for production)
//     CURLOPT_HTTPHEADER => [
//         "X-Shopify-Access-Token: {$accessToken}",
//         "Content-Type: application/json"
//     ]
// ]);
// $response = curl_exec($ch);
// if (curl_errno($ch)) {
//     echo 'cURL Error: ' . curl_error($ch);
//     curl_close($ch);
//     exit;
// }

// curl_close($ch);
// $products = json_decode($response, true);
// if (isset($products['products']) && !empty($products['products'])) {
//     echo "<h1>Shopify Products</h1>";
//     echo "<div class='products'>";

//     foreach ($products['products'] as $product) {
//         echo "<div class='product'>";
//         echo "<h2>" . htmlspecialchars($product['title']) . "</h2>";

//         // Display product image if available
//         if (!empty($product['images'])) {
//             echo "<img src='" . htmlspecialchars($product['images'][0]['src']) . "' alt='" . htmlspecialchars($product['title']) . "' style='max-width:200px;'/>";
//         }

    
//         if (!empty($product['variants'])) {
//             echo "<p>Price: $" . htmlspecialchars($product['variants'][0]['price']) . "</p>";
//         }

//         echo "</div>";
//     }

//     echo "</div>";
// } else {
//     echo "<p>No products found.</p>";
// }
// curl_close($ch);











?>