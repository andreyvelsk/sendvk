<?php
// VK API-Урок загрузка фото в альбом группы через PHP и CURL
// Только STANDALONE TOKEN
$token = file_get_contents('token');

$group_id = '169890865';
$album_id = '255650521';
$v = '5.62'; //версия vk api
$image_path = 'test.jpg';
$caption_initial = 'caption';
$caption = str_replace ( ' ', '%20', $caption_initial);
$cfile = curl_file_create($image_path,'image/jpeg',$image_path);
$post_data = array("file1" => $cfile);

// получаем урл для загрузки
$url = file_get_contents("https://api.vk.com/method/photos.getUploadServer?album_id=".$album_id."&group_id=".$group_id."&v=".$v."&access_token=".$token);
print_r ($url);
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

echo "<br>";
echo "---------------------------------------------------";
echo "<br>";

// сохраняем
$safe = file_get_contents("https://api.vk.com/method/photos.save?server=".$result['server']."&photos_list=".$result['photos_list']."&album_id=".$result['aid']."&hash=".$result['hash']."&group_id=".$group_id."&caption=".$caption."&v=".$v."&access_token=".$token);
$safe = json_decode($safe,true);
print_r($safe);
// итог
/*делаем этот файл как обработчик, загружаем картинку на сервер после этого передаем название картинки файлу и загружаем в альбом группы далее после успешной загрузки можно будет сразу же делать например wall.post урок есть несколько видео назад напрямую после загрузки уже есть готовый id изображения для wall.post :) спасибо за просмотр надеюсь, что помог ставь лайк делись и подписывайся! будет еще много годноты*/


?>
