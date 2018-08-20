<?php 
	$client_id = '6635768';
	$scope = 'offline,market,photos,wall';
?>


<a href="https://oauth.vk.com/authorize?client_id=<?=$client_id;?>&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=<?=$scope;?>&response_type=token&v=5.80">Получить токен</a>