<?php
/*
//VK API - Урок photos.get как получить все фотографии из альбома пользователя и группы через php
$query = file_get_contents("https://api.vk.com/method/photos.get?owner_id=-127877857&album_id=235179327&access_token=a7dd87f52f8912527e816be47eb615e670b8bcc3e2e2c689bdc669cd542d5ebeda648892de08cb89f7a94&v=5.62");
$result = json_decode($query,true);
//print_r($result);
//8 фото, все верно это тот альбом который нам нужен


foreach($result['response']['items'] as $photos){
    echo "<img src='".$photos['photo_604']."'><br>";
    echo "".$photos['text']."<br>";
}

// так же можно вывести фсе фото из альбома группы. Нужно указать id группы с дефисом -
//-138754934 и так же альбом группы
// надеюсь помог. 
// Ставьте лайки подписывайтесь и прочее 

*/

send(4872702, 136983378);

function send($owner_id , $album_id) {
    $url = 'https://api.vk.com/method/photos.get';
    $params = array(
      'owner_id' => $owner_id,    // Кому отправляем
      'album_id' => $album_id,   // Что отправляем
      'count' => 100,
      'access_token' => 'token',  
      'v' => '5.62',
    );

    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
          'method'  => 'POST',
          'header'  => 'Content-type: application/x-www-form-urlencoded',
          'content' => http_build_query($params)
        )
    )));

    $json = json_decode( $result, true);
    foreach($json['response']['items'] as $photos){
    echo "<img src='".$photos['photo_604']."'><br>";
    echo "".$photos['text']."<br>";
}

	}

?>