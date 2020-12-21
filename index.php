<?php
  $servername = "localhost";
  $username = "colocimmo";
  $password = "GNbTcmds{p2^04-";
  $dbname = "colocimmo";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  // }
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
    var_dump(count($res));
    for ($j=0; $j < count($res); $j++) { 
      $day = "";
      $annonce_id = $res[$j]->id;
      $annonce_url = $res[$j]->SEOUrl;
      $source = "IMMOWEB";
      $annonce_type = $res[$j]->property->type;
      $annonce_status = $res[$j]->transaction->type;
      $colocation_word = "";
      $student_word = "";
      $worker_word = "";
      $ok_accepte_word = "";
      $colocation_regulars_result = "";
      $prix = $res[$j]->transaction->rental->monthlyRentalPrice;
      $charges_locatives = $res[$j]->transaction->rental->monthlyRentalCosts;
      $caution = "";
      $location = $res[$j]->property->location->address->postalCode." ".$res[$j]->property->location->address->locality;
      $cp = $res[$j]->property->location->address->postalCode;

      $city = $res[$j]->property->location->address->locality;
      $geolocation = $res[$j]->property->location->geoPoint->latitude." ".$res[$j]->property->location->geoPoint->longitude;
      $address = $res[$j]->property->location->address->street." ".$res[$j]->property->location->address->number." ".$res[$j]->property->location->address->postalCode." ".$res[$j]->property->location->address->locality;

      $title = $res[$j]->property->title;
      $description = $res[$j]->property->description;
      $agency = "";
      $agence_id = ($res[$j]->customers)[0]->id;
      $is_student = "";
      $habitable_surface = $res[$j]->property->LivingDescription->netHabitableSurface;
      $garage = 0;
      $tel = (($res[$j]->customers)[0]->contactInfo)[0]->mobile;
      $mail = (($res[$j]->customers)[0]->contactInfo)[0]->email;
      $nb_chambres = $res[$j]->property->bedroom->count;
      $nb_sdb = $res[$j]->property->bathroom->count;
      $nb_wc = $res[$j]->property->toilet->count;
      $nb_facades = $res[$j]->property->building->facadeCount;
      $orientation = "";
      $additional_details = "{}";
      $featured_img = $res[$j]->media->pictures->baseUrl;
      $features = "{}";
      $is_closed = 0;
      $seller_type = "professional";
      $hidden_location = 0;
      $available_at = $res[$j]->transaction->availabilityDate;
      $createdOn = $res[$j]->publication->creationDate;
      $updatedOn = $res[$j]->publication->lastModificationDate;
      $last_update = $res[$j]->publication->lastModificationDate;

      $sql = "INSERT INTO annonces_3 (`day`, `annonce_id`, `annonce_url`, `source`, `annonce_type`, `annonce_status`, `colocation_word`, `student_word`, `worker_word`, `ok_accepte_word`, `colocation_regulars_result`, `prix`, `charges_locatives`, `caution`, `location`, `cp`, `city`, `geolocation`, `address`, `title`, `description`, `agency`, `agence_id`, `is_student`, `habitable_surface`, `garage`, `tel`, `mail`, `nb_chambres`, `nb_sdb`, `nb_wc`, `nb_facades`, `orientation`, `additional_details`, `featured_img`, `features`, `is_closed`, `seller_type`, `hidden_location`, `available_at`, `createdOn`, `updatedOn`, `last_update`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sisssssssssiisssssssssississiiiissssisissss", $day, $annonce_id, $annonce_url, $source, $annonce_type, $annonce_status, $colocation_word, $student_word, $worker_word, $ok_accepte_word, $colocation_regulars_result, $prix, $charges_locatives, $caution, $location, $cp, $city, $geolocation, $address, $title, $description, $agency, $agence_id, $is_student, $habitable_surface, $garage, $tel, $mail, $nb_chambres, $nb_sdb, $nb_wc, $nb_facades, $orientation, $additional_details, $featured_img, $features, $is_closed, $seller_type, $hidden_location, $available_at, $createdOn, $updatedOn, $last_update);
      $stmt->execute();
      $stmt->close();
    }
  } 
?>