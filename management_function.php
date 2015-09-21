<?php
	session_start();
	
	if($_GET['image']!==NULL)
	$_SESSION['image']=$_GET['image'];
		
	// клас зображення
	include "image_class.php";
	// новий екземпляр класу
	$object = new Image;
	// заповнюємо ім'я
	$object->name=$_SESSION['image'];
	// зчитуємо з бази і заповнюємо атрибути
	$object->ReadDatabase();
		
	// якщо натиснуто зберегти зміни
	if (isset($_POST['save']))
	{
		// оновити коментар
		$object->SetComment($_POST['comment']);
		$object->UpdateСomment();
	}
		
	// якщо натиснуто видалити зображення
	if (isset($_POST['delete']))
	{
		// метод видалення зображення
		$object->DeleteImage();
		// перенаправлення на головну сторінку
		echo "Інформацію було видалено - відбудеться перехід на головну сторінку (через 15 секунд)";
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="15;URL=/index.php">';
	}
	else
	{
		// виведення
		?>
			<div class="row">
				<div class="col-xs-1 col-md-4 col-md-offset-1">
					<br>
					<div class="form-group">
						<div class="col-sm-12">
							<textarea class="form-control" rows="5" name="comment" id="comment" placeholder="<?php echo $object->GetComment();?>"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-default" id="save">Зберегти зміни</button>
						</div>
					</div>
				</div>
						
				<div class="col-xs-1 col-md-5 col-md-offset-1">
					<br>
					<p>
						<img src="<?php echo 'images/thumbs/'.$_SESSION['image'];?>">
					</p>
						
					<div class="form-group">
						<div class="col-sm-12">
							<button type="submit" class="btn btn-default" id="delete">Видалити зображення</button>
						</div>
					</div>
				</div>
			</div>
		<?
	}
?>