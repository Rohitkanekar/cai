<?php
$payload = [
    "name" => "Rohit Kanekar",
    "phone" => "9029999120",
    "email" => "kanekarrohit26@gmail.com",
    "subject" => "Testing",
    "message" => "This is a backend test."
];
$ch = curl_init("http://localhost/cai/api/contact.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$response = curl_exec($ch);
curl_close($ch);
echo $response;