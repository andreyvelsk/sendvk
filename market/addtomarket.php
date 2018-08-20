<?php
// VK API-Урок загрузка фото в альбом группы через PHP и CURL
// Только STANDALONE TOKEN
$token = file_get_contents('token');

$group_id = '169890865';
$album_id = '255650521';
$v = '5.62'; //версия vk api

function addToMarket($image_path, $name_initial, $caption_initial, $price){

		global $token, $group_id, $v;

		$name = str_replace ( ' ', '%20', $name_initial);
		$caption = str_replace ( ' ', '%20', $caption_initial);
		
		$main_photo_id = addPhotoToMarket($image_path, 1, $image_path);

		$addmarket = file_get_contents("https://api.vk.com/method/market.add?owner_id=-".$group_id."&name=".$name."&description=".$caption."&category_id=1006&price=".$price."&main_photo_id=".$main_photo_id."&v=".$v."&access_token=".$token);
		
		echo "<br>";
		print_r("market.add");
		echo "<br>";
		print_r($addmarket);
		echo "<br>";
		print_r("---------------------------------------------------------");
		echo "<br>";

		$addmarket = json_decode($addmarket)->response;
		$market_item_id = $addmarket->market_item_id;

		return $market_item_id;
}

function addPhotoToMarket($image_path, $is_main){

		global $token, $group_id, $v;

		$cfile = curl_file_create($image_path,'image/jpeg', $image_path);
		$post_data = array("file1" => $cfile);

		// получаем урл для загрузки
		$url = file_get_contents("https://api.vk.com/method/photos.getMarketUploadServer?group_id=".$group_id."&main_photo=".$is_main."&crop_x=0&crop_y=0&v=".$v."&access_token=".$token);

		$url = json_decode($url)->response->upload_url;


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

		echo "<br>";
		print_r("Отправка post картинки");
		echo "<br>";
		print_r($result);

		echo "<br>";
		print_r("---------------------------------------------------------");
		echo "<br>";

		// сохраняем
		$safe = file_get_contents("https://api.vk.com/method/photos.saveMarketPhoto?server=".$result['server']."&photo=".$result['photo']."&hash=".$result['hash']."&crop_data=".$result['crop_data']."&crop_hash=".$result['crop_hash']."&group_id=".$group_id."&v=".$v."&access_token=".$token);
		
		echo "<br>";
		print_r("saveMarketPhoto");
		echo "<br>";
		print_r($safe);
		$safe = json_decode($safe)->response;
		$main_photo_id = $safe[0]->id;

		return $main_photo_id;

		echo "<br>";
		print_r("---------------------------------------------------------");
		echo "<br>";

}

function addToWall($market_item_id){

	global $token, $group_id, $v;

	$addtowall = file_get_contents("https://api.vk.com/method/wall.post?owner_id=-".$group_id."&from_group=1&attachments=market-".$group_id."_".$market_item_id."&v=".$v."&access_token=".$token);

	echo "<br>";
	print_r("wall.Post");
	echo "<br>";

	print_r($addtowall);

	return $addtowall;
	
}

?>
