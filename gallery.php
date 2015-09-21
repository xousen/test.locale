<?php
	session_start();
	include "query.php";
	
	// перевірка обраного сортування
	if(isset($_POST['sort']))
	{
		if ($_POST['sort']!=NULL)
		$_SESSION['sort']=$_POST['sort'];	
	}
	
	// виведення кнопок сортування
	function sorted()
	{
		// пошук входження
		$pos = strpos($_SESSION['sort'], 'date');
	
		// сортування за датами
		if ($pos===false)
		{
			// виведення звичайної кнопки сортування за датами
			?>
			<button class="btn btn-link" id="date_sort" name="sort" value="date_up">
				<span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
			</button>
			<?
			
			// перевірка сортування за розміром
			if ($_SESSION['sort']=='size_up')
			{
				?>
				<button class="btn btn-link btn-lg" id="size_sort" name="sort" value="size_down">
					<span class="glyphicon glyphicon-sort-by-order-alt" aria-hidden="true"></span>
				</button>
				<?
			}
			else
			{	
				?>
				<button class="btn btn-link btn-lg" id="size_sort" name="sort" value="size_up">
					<span class="glyphicon glyphicon-sort-by-order" aria-hidden="true"></span>
				</button>
				<?
			}
		}
		else
		{
			// перевірка обраного сортування для дати
			if ($_SESSION['sort']=='date_up')
			{
				?>
				<button class="btn btn-link btn-lg" id="date_sort" name="sort" value="date_down">
					<span class="glyphicon glyphicon-sort-by-attributes-alt" aria-hidden="true"></span>
				</button>
				<?
			}
			else
			{
				?>
				<button class="btn btn-link btn-lg" id="date_sort" name="sort" value="date_up">
					<span class="glyphicon glyphicon-sort-by-attributes" aria-hidden="true"></span>
				</button>
				<?
			}
			
			// виведення звичайної кнопки сортування за розміром
			?>
			<button class="btn btn-link" id="size_sort" name="sort" value="size_up">
				<span class="glyphicon glyphicon-sort-by-order" aria-hidden="true"></span>
			</button>
			<?
		}
	}
	
	// виведення зображень галереї
	function output($sort)
	{
		// переглядаємо тип сортування
		if ($sort=="size_up")
		$images=dataBase("SELECT * FROM images ORDER by size ASC");
		else if ($sort=="size_down")
		$images=dataBase("SELECT * FROM images ORDER by size DESC");
		else if ($sort=="date_up")
		$images=dataBase("SELECT * FROM images ORDER by date_upload ASC");
		else if ($sort=="date_down")
		$images=dataBase("SELECT * FROM images ORDER by date_upload DESC");
		else
		$images=dataBase("SELECT * FROM images ORDER by id ASC");
		
		?>
		<script type='text/javascript' src='unitegallery/js/jquery-11.0.min.js'></script>	
		<script type='text/javascript' src='unitegallery/js/unitegallery.min.js'></script>	
		<script type='text/javascript' src='unitegallery/themes/tiles/ug-theme-tiles.js'></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
				jQuery("#gallery").unitegallery({
					tile_border_color:"#7a7a7a",
					tile_outline_color:"#8B8B8B",
					tile_enable_shadow:true,
					tile_shadow_color:"#8B8B8B",
					tile_overlay_opacity:0.3,
					tile_show_link_icon:true,
					tile_image_effect_type:"sepia",
					tile_image_effect_reverse:true,
					tile_enable_textpanel:true,
					lightbox_textpanel_title_color:"e5e5e5",
					tiles_col_width:230,
					tiles_space_between_cols:20				
				});

			});
		</script>
		
		<div id="gallery" style="display:none;">
		<?	
			// відповідно до типу сортування виводимо всі зображення
			foreach($images as $one)
			{
				?>
				<a href="<?php echo 'management.php?image='.$one['name'];?>">
					<img alt="<?php echo $one['date_upload'].' '.$one['comment'];?>"
					src="<?php echo 'images/thumbs/'.$one['name'];?>"
					data-image="<?php echo 'images/big/'.$one['name'];?>"
					data-description="<?php echo $one['date_upload'].' '.$one['comment'];?>"
					style="display:none">
				</a>
				<?
			}
		?>
		</div>
		<?
	}
	
	sorted();
	output($_SESSION['sort']);
?>