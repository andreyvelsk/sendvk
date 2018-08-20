<?php
// VK API-Урок загрузка фото в альбом группы через PHP и CURL
// Только STANDALONE TOKEN
$token = file_get_contents('token');

$group_id = '169890865';
$album_id = '255650521';
$v = '5.62'; //версия vk api
$image_path = 'house.jpg';
$caption_initial = 'test';
$caption = str_replace ( ' ', '%20', $caption_initial);

$cfile = curl_file_create($image_path,'image/jpeg', $image_path);
$post_data = array("file1" => $cfile);

// получаем урл для загрузки
//$url = file_get_contents("https://api.vk.com/method/photos.getUploadServer?album_id=".$album_id."&group_id=".$group_id."&v=".$v."&access_token=".$token);
$url = file_get_contents("https://api.vk.com/method/photos.getMarketUploadServer?group_id=".$group_id."&main_photo=1&crop_x=0&crop_y=0&crop_width=450&v=".$v."&access_token=".$token);

$url = json_decode($url)->response->upload_url;
//print_r($url);

// отправка post картинки
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$result = json_decode(curl_exec($ch),true);

curl_close($ch);
print_r($result);
echo "<br>------------------<br>";


$safe = file_get_contents("https://api.vk.com/method/photos.saveMarketPhoto?server=".$result['server']."&photo=".$result['photo']."&hash=".$result['hash']."&crop_data=".$result['crop_data']."&crop_hash=".$result['crop_hash']."&group_id=".$group_id."&v=".$v."&access_token=".$token);
		
		echo "<br>";
		print_r("saveMarketPhoto");
		echo "<br>";
		print_r($safe);
		$safe = json_decode($safe)->response;
		$main_photo_id = $safe[0]->id;



		echo "<br>";
		print_r("---------------------------------------------------------");
		echo "<br>";
?>
