<?php
	// функція завантаження зображення
	function upload_image()
	{
		if($_FILES["filename"]["size"]==0)
		{
			echo ("Будь ласка, оберіть файл");
			exit;
		}
		
		// перевірка розміру файлу (можна накласти обмеження в php.ini)
		if($_FILES["filename"]["size"]>1024*1*1024)
		{
			echo ("Розмір файлу перевищує один мегабайт");
			exit;
		}
			
		// перевірка відповідності типу файлу
		if($_FILES["filename"]["type"]!="image/jpg" && $_FILES["filename"]["type"]!="image/jpeg" && $_FILES["filename"]["type"]!="image/png")
		{
			echo ("На жаль, формат файлу ".$_FILES["filename"]["type"]." не підтримується");
			exit;
		}
			
		// перевірка завантаження файлу
		if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
		{
			// якщо файл завантажений успішно - переміщаємо в кінцеву директорію	
     		$image_name = "images/thumbs/".$_FILES["filename"]["name"];
     		$image_name_view = $_FILES["filename"]["name"];
     		$image_name_big = "images/big/".$_FILES["filename"]["name"];
     				
     		move_uploaded_file($_FILES["filename"]["tmp_name"], "images/thumbs/".$_FILES["filename"]["name"]);
     						
     		// копіювання
     		$file = "images/thumbs/".$_FILES["filename"]["name"];
			$newfile = "images/big/".$_FILES["filename"]["name"];		
     		if (!copy($file, $newfile)) 
     		{
				echo 'не вдалося скопіювати'.$file.'...\n';
			}
						
     		////////////////////////////////////////////////////////////////////////////////
     		$file_name = "images/thumbs/".$_FILES["filename"]["name"];
     		switch($_FILES['filename']['type']) 
			{ 
				// узнаем тип картинки 
				case "image/jpeg": $im = imagecreatefromjpeg($file_name); break; 
				case "image/png": $im = imagecreatefrompng($file_name); break; 
				case "image/jpg": $im = imagecreatefromjpeg($file_name); break;		
			} 
			
			list($w,$h) = getimagesize($file_name); // берем высоту и ширину 
			if($w<$h && ($w/$h)<0.75)
			{
				$koe=$w/200; // вычисляем коэффициент 200 это ширина которая должна быть
				$new_h=ceil($h/$koe); // с помощью коэффициента вычисляем высоту
				$im1 = imagecreatetruecolor(200, $new_h); // создаем картинку
				imagecopyresampled($im1,$im,0,0,0,0,200,$new_h,imagesx($im),imagesy($im)); 
			}
			else if ($w>$h && ($h/$w)<0.75)
			{
				$koe=$w/700; // вычисляем коэффициент 200 это ширина которая должна быть
				$new_h=ceil($h/$koe); // с помощью коэффициента вычисляем высоту
				$im1 = imagecreatetruecolor(700, $new_h); // создаем картинку
				imagecopyresampled($im1,$im,0,0,0,0,700,$new_h,imagesx($im),imagesy($im)); 			
			}
			else
			{
				$koe=$w/300; // вычисляем коэффициент 200 это ширина которая должна быть
				$new_h=ceil($h/$koe); // с помощью коэффициента вычисляем высоту
				$im1 = imagecreatetruecolor(300, $new_h); // создаем картинку
				imagecopyresampled($im1,$im,0,0,0,0,300,$new_h,imagesx($im),imagesy($im)); 
			}
			imageconvolution($im1, array( // улучшаем четкость
			array(-1,-1,-1), 
			array(-1,16,-1), 
			array(-1,-1,-1)), 8, 0); 
			imagejpeg($im1, $file_name, 100); // переводим в jpg
			imagedestroy($im); 
			imagedestroy($im1);
			/////////////////////////////////////////////////////////////////////////////
					
			echo "Зображення успішно додане";
			
			?>
			<div class="container-fluid">
				<a href="upload.html">Додати ще...<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
			</div>
	
			<div class="container-fluid">
				<a href="index.php">До галереї<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
			</div>
			<?
						
			// клас зображення
			include "image_class.php";
			// новий екземпляр класу
			$object = new Image;
			// поточний час
			$today = date("y-m-d");
			// заповнити параметри об'єкта
			$object->SetAttribute($_FILES["filename"]["name"], $today, $_FILES["filename"]["size"], $_POST['comment']);
			// додати в базу
			$object->AddDatabase();
		}
		else 
		{
			echo("Помилка завантаження файлу");
		}
	}

	// завантаження зображення
	upload_image();
?>
