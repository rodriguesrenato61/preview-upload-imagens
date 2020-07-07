<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Resultado</title>
	</head>
	<body>
		
		<?php
		
			session_start();
			
			if(isset($_SESSION['result'])){
			
				$result = $_SESSION['result'];
				
				if($result['success']){
					
					echo("<a href='index.php'>Cadastrar mais imagens</a>");
					
					echo("<h1>Imagens cadastradas com sucesso!</h1>");
					echo("<h2>{$result['msg']}</h2>");
					
				}else{
					
					echo("<a href='index.php'>Tentar novamente!</a>");
					echo("<h1>{$result['msg']}</h1>");
				
					if($result['errors']){
						
						echo("<h2><ul>");
					
						foreach($result['errors'] as $error){
						
							echo("<li>{$error}</li>");
							
						}
						
						echo("</ul></h2>");
						
					}
					
					
				}
					
			}else{
				
			
				header("Location: index.php");
				
			}
		
		?>
		
	</body>
</html>


