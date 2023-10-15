<?php
$api_key = "";
$request_url = "https://api.openai.com/v1/images/generations";
$content = $_GET['content'];

$data = array(
    "prompt" => "$content",
    "n" => 1,
    "size" => "1024x1024"
);

$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Bearer " . $api_key
));
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Błąd cURL: ' . curl_error($ch);
} else {
    // Przetwarzaj odpowiedź
    $decoded_response = json_decode($response, true);

    if (isset($decoded_response['data'][0]['url'])) {
        echo "<img src='" . $decoded_response['data'][0]['url'] . "'>";
    } else {
        echo "Brak linku do obrazu w odpowiedzi." . $response;
    }
}

curl_close($ch);
?>
