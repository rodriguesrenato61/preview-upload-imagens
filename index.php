<?php

	session_start();
	
	if(isset($_SESSION['result'])){
	
		unset($_SESSION['result']);
		
	}

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Upload Imagens</title>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/modal.css">
	</head>
	<body>
		
		<div class="modal-fundo" id="modal-fundo">
        </div> <!-- class modal-fundo -->
		<div class="modal-meio" id="modal-meio">
            <div class="modal-erro" id="modal-erro">
                <div class="modal-head modal-head">
                    <h2>ERRO <span id="fechar-modal">x</span></h2>
                   
                </div> <!-- class modal-head -->
                <div class="modal-body" id="modal-body">
                    Conteúdo da modal
                </div> <!-- class modal-body -->
            </div> <!-- class modal-user-delete -->
		</div> <!-- class modal-meio -->
		
		<div class="container">
			<div class="form-container">
				<div class="btn-upload">
					<label class="lb-upload" for="files">
						Upload
					</label>
				</div> <!-- class btn-upload -->
				<div id="quant-arquivos">Selecione 10 imagens no máximo!</div>
				<input type="file" id="files" name="files[]" multiple />
				<button id="btn-enviar" class="btn-enviar">Enviar</button>
			</div> <!-- class form-container -->
			<div class="preview" id="preview">
				
			</div> <!-- class preview -->
		</div>
		<script type="text/javascript" src="js/scripts.js"></script>
	</body>
</html>
