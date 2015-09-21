<?php
	// робота з базою даних
	include "query.php";
	
	class Image 
	{
		// атрибути:
		var $name;
		var $date_upload;
		var $size;
		var $comment;
		
		// методи:
		// повернення коментаря до зображення
		function GetComment()
		{
			echo $this->comment;
		}
		
		// зміна коментаря до зображення
		function SetComment($comment) 
		{
			$this->comment = $comment;
		}
		
		// заповнення всіх атрибутів
		function SetAttribute($name, $date_upload, $size, $comment) 
		{
			$this->name = $name;
			$this->date_upload = $date_upload;
			$this->size = $size;
			$this->comment = $comment;
		}
		
		// зчитування всіх атрибутів
		function GetAttribute() 
		{
			$info[0] = $this->name;
			$info[1] = $this->date_upload;
			$info[2] = $this->size;
			$info[3] = $this->comment;
			
			return $info;
		}
		
		// додання інформації в базу даних
		function AddDatabase()
		{
            $sql = mysql_query("INSERT INTO images (id, name, date_upload, size, comment) VALUES (NULL, '{$this->name}', '{$this->date_upload}', '{$this->size}', '{$this->comment}');");
		}
		
		// зчитування інформації з бази даних
		function ReadDatabase()
		{
			$sql = database("SELECT date_upload, size, comment FROM images WHERE name='{$this->name}';");
			$this->SetAttribute($this->name, $sql[0]['date_upload'], $sql[0]['size'], $sql[0]['comment']);
		}
		
		// видалення зображення з папки
		function DeleteImage()
		{
			// видалення великого зображення
			unlink('images/big/'.$this->name);
			// видалення маленького зображення
			unlink('images/thumbs/'.$this->name);		
			// видалення з бази даних
			$sql = mysql_query("DELETE FROM images WHERE name='{$this->name}';");	
		}
		
		// оновлення коментаря в базі даних
		function UpdateСomment() 
		{
			$sql = mysql_query("UPDATE images SET comment='{$this->comment}' WHERE name='{$this->name}';");	
		}		
	}
?>