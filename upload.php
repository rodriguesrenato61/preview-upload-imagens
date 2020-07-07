<?php

	if(isset($_FILES['files'])){
		
		session_start();
		
		require_once("app/Arquivo.php");
		
		$arquivo = new Arquivo();
		
		$imagens = $_FILES['files'];
		
		$j = count($imagens['name']);
		
		//arrumando o array de arquivos para upload
		for($i = 0; $i < $j; $i++){
	
			$array_imagens[] = array(
				"name" => $imagens['name'][$i],
				"type" => $imagens['type'][$i],
				"tmp_name" => $imagens['tmp_name'][$i],
				"error" => $imagens['error'][$i],
				"size" => $imagens['size'][$i]
			);
		
		}
		
		$result = $arquivo->uploadMultiple($array_imagens);
		
		$_SESSION['result'] = $result;
		
		
	}else{
	
		$result = array(
			"success" => false,
			"msg" => "Nenhuma imagem enviada!"
		);
		
	}
	
	echo json_encode($result);

?>
