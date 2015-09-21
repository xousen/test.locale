<?
	session_start();
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Редагування</title>
		
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery.js"></script>
		
		<!-- обмеження кількості символів на коментування -->
		<script>
			$(document).ready(function(){   
				$('#comment').keyup(function(){
					var $this = $(this);
					if($this.val().length > 200)
					$this.val($this.val().substr(0, 200));           
				});
			});
		</script>		
	</head>
	<body> 
	
		<form class="form-horizontal">
			<div id="all">
				<?php
					include "management_function.php";
				?>
			</div>
		</form>
	
		<script type="text/javascript">
			$(document).ready(function(){
			
				$('body').on('click','#delete',function(){
					$.ajax({
						type: "POST",  
						url: "management_function.php",  
						data: "delete=ok",  
						cache: false,  
						success: function(html){  
							$("#all").html(html);  
						}
					});  
					return false;  
				});

				$('body').on('click','#save',function(){
					$.ajax({
						type: "POST",  
						url: "management_function.php",  
						data: "save=ok"
							+"&comment="+$("#comment").val(),  
						cache: false,  
						success: function(html){  
							$("#all").html(html);  
						}  
					});  
					return false;  
				});
				
			});
		</script>
	</body>
</html>