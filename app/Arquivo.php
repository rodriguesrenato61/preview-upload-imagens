<?php


	class Arquivo{
		
		private $pdo;
		
		public function __construct(){
		
			$host = "localhost";
			$dbname = "upload_imagens";
			$user = "root";
			$password = "d3s1p6g6";
		
			try{
				
				$this->pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
				
			}catch(Exception $e){
			
				echo("Erro ao conectar banco de dados: {$e->getMessage()}");
				
			}
			
		}
	
		//faz upload de uma imagem
		public function upload($file, $num){
			
			try{
		
				$arquivo = $file['name'];
		
				//pasta onde o arquivo será salvo
				
				$_UP['pasta'] = "imagens/";
				
				//tamanho máximo do arquivo
				$_UP['tamanho'] = 1024*1024*100; //5MB
				
				//extensões do arquivo
				$_UP['extensoes'] = array('png', 'jpeg', 'jpg', 'gif');
				
				//Renomeia
				$_UP['renomeia'] = true;
				
				//Array com os tipos de erros de upload de Php
				$_UP['erros'][0] = 'Não houve erro!';
				$_UP['erros'][1] = 'O arquivo no upload é maior queo limite do Php';
				$_UP['erros'][2] = 'O arquivo ultrapassa o limite especificado do HTML';
				$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
				$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
				
				if($file['error'] != 0){
					
					$retorno = array(
						"success" => false,
						"msg" => "Não foi possível fazer o upload da imagem!",
						"error" => "{$_UP['erros'][$file['error']]}"
					);
					
				}else{
					
					//faz a verificação da extensão do arquivo
					$nome_arquivo = explode('.', $file['name']);
					$extensao = $nome_arquivo[count($nome_arquivo) - 1];
					
					if(array_search($extensao, $_UP['extensoes']) === false){
						
						$retorno = array(
							"success" => false,
							"msg" => "Coloque a extensão correta!"
						);
						
					}else if($_UP['tamanho'] < $file['size']){
						
						$retorno = array(
							"success" => false,
							"msg" => "Tamanho da imagem maior que o pemitido!"
						);
						
					}else{
						
						if($_UP['renomeia'] == true){
							
							$nome_final = "IMG".time()."-{$num}.{$extensao}";
							
						}else{
							
							$nome_final = $file['name'].".".$extensao;
							
						}
						
						if(move_uploaded_file($file['tmp_name'], $_UP['pasta'].$nome_final)){
							
							$retorno = array(
								"success" => true,
								"msg" => "Upload realizado com sucesso!",
								"name" => $nome_final
							);
							
							
						}else{
							
							$retorno = array(
								"success" => false,
								"msg" => "Não foi possível fazer o upload da imagem!"
							);
							
						}
						
					}
					
				}
				
			}catch(Exception $e){
				
				$retorno = array(
					"success" => false,
					"msg" => "Não foi possível fazer o upload da imagem!",
					"error" => $e->getMessage()
				);
				
			}
			
			return $retorno;
		
		}
		
		//faz upload de múltiplas imagens
		public function uploadMultiple($imagens){
		
			$j = count($imagens);
			
			$count = 0;
			
			$errors = array();
			
			for($i = 0; $i < $j; $i++){
			
				$result = $this->upload($imagens[$i], $i);
				
				if($result['success']){
					
					$insertResult = $this->insert_image($result['name']);
					
					if($insertResult['success']){
					
						$count++;
						
					}else{
						
						$errors[] = $insertResult['error'];
						
					}
				
					
					
				}else{
					
					if($result['error']){
					
						$errors[] = $result['error'];
						
					}else{
						
						$errors[] = $result['msg'];
						
					}
				
					
				}
				
			}
			
			if($count == $j){
			
				$retorno = array(
					"success" => true,
					"msg" => "Todos os {$count} uploads realizados com sucesso!"
				);
				
			}else{
				
				$retorno = array(
					"success" => false,
					"msg" => "Somente {$count} uploads realizados!",
					"errors" => $errors
				);
				
			}
			
			return $retorno;
			
		}
		
		//cadasta a imagem no banco de dados
		public function insert_image($name){
			
			try{
				
				$sql = $this->pdo->prepare("SELECT * FROM imagens WHERE nome = :nome");
				$sql->bindParam(":nome", $name, PDO::PARAM_STR);
				$sql->execute();
				
				if($sql->rowCount() > 0){
					
					$retorno = array(
						"success" => true,
						"msg" => "Essa imagem já está registrada!"
					);
				
					
				}else{
					
					$sql = $this->pdo->prepare("INSERT INTO imagens(nome, dtRegistro)VALUES(:nome, NOW())");
					$sql->bindParam(":nome", $name, PDO::PARAM_STR);
					$sql->execute();
					
					if($sql->rowCount() > 0){
				
						$retorno = array(
							"success" => true,
							"msg" => "Imagem cadastrada com sucesso!"
						);
						
					}else{
						
						$retorno = array(
							"success" => false,
							"msg" => "Imagem não cadastrada!"
						);
					}
					
				}
				
			}catch(Exception $e){
			
				$retorno = array(
					"success" => false,
					"msg" => "Não foi possível cadastrar imagem!",
					"error" => $e->getMessage()
				);
				
			}
			
			return $retorno;
			
		}
	
	}

?>
