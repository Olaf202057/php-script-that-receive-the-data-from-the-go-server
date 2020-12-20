<?php
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'localhost:4000/getMaxPage',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      'prefix: T'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);

  for($i = 0; $i < intval($response); $i++) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'localhost:4000/currentPageData',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'pageNumber='.$i,
      CURLOPT_HTTPHEADER => array(
        'prefix: T',
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $res = json_decode($response);
    var_dump($res);
  } 
?>