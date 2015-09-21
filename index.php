<?php 
	session_start();
?>

<!DOCTYPE html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Галерея</title>

		<script type='text/javascript' src='unitegallery/js/jquery-11.0.min.js'></script>	
		<script type='text/javascript' src='unitegallery/js/unitegallery.min.js'></script>	
		<script type='text/javascript' src='unitegallery/themes/tiles/ug-theme-tiles.js'></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<link rel='stylesheet' href='unitegallery/css/unite-gallery.css' type='text/css' />	
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>

	<body>
		<form>		
			<div id="content">
				<?php 
				include "gallery.php";
				?>		
			</div>
		</form>
		
		<div id="add_image" class="container-fluid">
			<br>
			<a href="upload.html">Додати зображення <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
		</div>
		
		<script type="text/javascript">
			$(document).ready(function(){
			
			$('body').on('click','#date_sort',function(){
				$.ajax({
					type: "POST",  
					url: "gallery.php",  
					data: "sort="+$("#date_sort").val(),  
					cache: false,  
					success: function(html){  
						$("#content").html(html);  
					}
				});  
				return false;  
			});

			$('body').on('click','#size_sort',function(){
				$.ajax({
					type: "POST",  
					url: "gallery.php",  
					data: "sort="+$("#size_sort").val(),  
					cache: false,  
					success: function(html){  
						$("#content").html(html);  
					}  
				});  
				return false;  
			});
			
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
	</body>
</html>