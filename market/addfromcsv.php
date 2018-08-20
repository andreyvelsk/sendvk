<?php
require 'addtomarket.php';

$startrow = file_get_contents('number');
$endrow = lines("Primer_tovara.csv");
$localimagepath = '/home/andrey/www/tinashop/wp-content/uploads/2018/brit/';

for($i=$startrow; $i<=$endrow; $i++){
	echo $i."<br><br>";
	addFromCsvRow($i);
	$f=fopen('number','w');
	fwrite($f,$i);
	fclose($f);
}

	function addFromCsvRow($startrow){

		global $localimagepath;

		if (($handle = fopen("Primer_tovara.csv", "r")) !== FALSE) {

			$row = 1;
			$good = new stdClass;

		    while (($data = fgetcsv($handle, 10000000, ",")) !== FALSE) {

		    	if ($row == $startrow){
			        $num = count($data);

			        $good->art = $data[2];
			        $good->name = $data[3];
			        $good->cat = $data[25];
			        $good->price = $data[24];
			        $good->description = $data[8];
			        $good->images = explode(',',$data[28]);


			        $good->total = "Артикул: ".$good->art."<br>".$good->cat."<br>".$good->description;
					$good->total = str_replace('<br>', "%0A", $good->total);

					$good->images[0] = $image_path1 = $localimagepath.basename($good->images[0]); 
					print_r ($good->images[0]);
						//echo "<br>-----------------------------------------<br>";

					$market_item_id = addToMarket($good->images[0], $good->name, $good->total, $good->price);
					//addToWall($market_item_id);

			        break;
			    }
			    $row++;
		    }
		    fclose($handle);

		}
	}
function lines($file) 
{ 
    // в начале ищем сам файл. Может быть, путь к нему был некорректно указан 
    if(!file_exists($file))exit("Файл не найден"); 
     
    // рассмотрим файл как массив
    $file_arr = file($file); 
     
    // подсчитываем количество строк в массиве 
    $lines = count($file_arr); 
     
    // вывод результата работы функции 
    return $lines; 
}
?>