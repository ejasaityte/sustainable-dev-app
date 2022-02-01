<?php
$url = "https://api.mapbox.com/geocoding/v5/mapbox.places/56.4647174282653,-2.96930793466534.json?access_token=pk.eyJ1IjoiZXVhbmRvY2tpbmciLCJhIjoiY2t5dmt1aTZvMXpqMTJxcHR2eTF2Z21zOCJ9.yZNbnAG0QP59OzGsTYFX1A";

$curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 29,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_0_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

    $responsen = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    $responsen = json_decode($responsen, true);

    foreach ($responsen as $eventn)
    {
        echo '<strong>Address:</strong><p>'.$eventn['features'].'</p>';
    }
?>