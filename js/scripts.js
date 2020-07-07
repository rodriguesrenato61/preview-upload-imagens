const btnFiles = document.querySelector('#files');

const btnUpload = document.querySelector('#btn-upload');

const quantArquivos = document.querySelector('#quant-arquivos');

const btnEnviar = document.querySelector('#btn-enviar');

const preview = document.querySelector('#preview');

const modalFundo = document.querySelector("#modal-fundo");

const modalMeio = document.querySelector("#modal-meio");

const modalBody = document.querySelector("#modal-body");

const fecharModal = document.querySelector("#fechar-modal");

var selecionados = new Array();//armazena os arquivos que foram escolhidos

const limite = 10;//quantidade máxima de imagens a serem selecionadas

//atribuindo o carregamento das imagens no preview ao evento change do input de arquivos
btnFiles.addEventListener('change', function(){

	const files = btnFiles.files;//pegando os arquivos selecionados
	
	var tmp = new Array();//armazena os arquivos que foram escolhidos temporariamente
	
	let erro = false;
	
	//limpa array removendo registros nulos
	for(let i = 0; i < selecionados.length; i++){
	
		if(selecionados[i] != null){
		
			tmp.push(selecionados[i]);
			
		}
		
	}
	
	selecionados = tmp;
	
	
	console.log("Array limpo!");
	console.log(selecionados);
	
	if(files.length > 0){
		
		for(let i = 0; i < files.length; i++){
							 
			if(imagemValida(files[i])){
			 
				if(selecionados.length < limite){
				
					//colocando os arquivos no array  
					selecionados.push(files[i]);
					
				}else{
					
					alert("Quantidade máxima de imagens selecionadas!");
					break;
					
				}
				 
			}else{
				 
				erro = true;
				 
				console.log("Erro formato inválido!");
				 
			}
							
		}
		
		
		if(selecionados.length > 0){
	
			let html = "";
	  
			//criando elementos html para preview das imagens
			for(let i = 0; i < selecionados.length; i++){
									
				html += "<div class='imagem-preview'>";
					html += "<div class='imagem-head'>";
						html += "<span class='fechar-imagem'>x</span>";
					html += "</div>";
					html += "<div class='imagem-body'>";
						html += "<img class='imagem'>";
					html += "</div>";
				html += "</div>";
					
			}
			
			//adicionando elementos ao Dom
			preview.innerHTML = html;
			
			//selecionando elementos criados para serem manipulados
			let imagemPreview = document.querySelectorAll(".imagem-preview");
			let removerImagem = document.querySelectorAll(".fechar-imagem");
			let imagem = document.querySelectorAll(".imagem");
			
			//fazendo a manipulação dos elementos e colocando as imagens no preview 
			for(let i = 0; i < selecionados.length; i++){
				
				//utilizando o FileReader para colocar as imagens no preview
				let fileReader = new FileReader();
				
				fileReader.onload = function(){
					
					imagem[i].title = selecionados[i].name;
					imagem[i].src = fileReader.result;
						
				}
						
				fileReader.readAsDataURL(selecionados[i]);
						
				//adicionando evento de remoção das imagens
				removerImagem[i].addEventListener('click', function(){
					
					imagemPreview[i].style.display = "none";
							
					//retirando a imagem do array das imagens escolhidas
					selecionados[i] = null;
								
					console.log("Imagem "+i+" removida");
					
					let count = countArquivos(selecionados);
					
					if(count > 1){
					
						quantArquivos.innerText = count+" arquivos selecionados";
						
					}else if(count == 1){
						
						quantArquivos.innerText = "1 arquivo selecionado";
						
					}else{
						
						quantArquivos.innerText = "Selecione 10 imagens no máximo!";

					}
					
					console.log("Restante: ");
					console.log(selecionados);
										
				}); 
				
						
			}
			
			  
			console.log("Selecionados: ");
			console.log(selecionados);
			
		}
			
		quantArquivos.innerText = selecionados.length+" arquivos selecionados";
		
		if(erro){
			
			alert("Selecione somente arquivos de imagem!");
			
		}
		
	}else{
		
		quantArquivos.innerText = "Selecione 10 imagens no máximo!";
	
		console.log("Nenhum arquivo selecionado!");
		
	}
	
});

//adicionando o envio de imagens ao evento submit do formulário
btnEnviar.addEventListener('click', function(){
	
	btnEnviar.innerText = "Enviando...";
	
	btnEnviar.disabled = true;
	
	enviar(selecionados);

});


fecharModal.addEventListener('click', function(){

	modalClose();
	
});

modalFundo.addEventListener('click', function(){

	modalClose();
	
});

function countArquivos(arquivos){

	let count = 0;
	
	for(let i = 0; i < arquivos.length; i++){
	
		if(arquivos[i] != null){
		
			count++;
			
		}
		
	}
	
	return count;
	
}


function imagemValida(arquivo){
 
	let valido = false;
	
	let formatos = new Array();
	formatos.push("image/png");
	formatos.push("image/jpeg");
	formatos.push("image/jpg");
	formatos.push("image/gif");
	
	for(let i = 0; i < formatos.length; i++){
	
		if(arquivo.type == formatos[i]){
		 
			valido = true;
			
			break;
			
		}
		
	}
	
	return valido;
}

//envia os arquivos para o backend
function enviar(arquivos){
	
	let files = new Array();
	
	arquivos.forEach(function(arquivo){
		
		if(arquivo != null){
	
			files.push(arquivo);
			
		}
		
	});
	
	if(files.length > 0){
		
		//os arquivos seram colocados em um objeto FormData para o envio
		let form = new FormData();
		
		files.forEach(function(file){
		
			form.append('files[]', file);
			
		});
		
		//utilizando o fetch para fazer o envio dos arquivos por ajax
		//aqui vc coloca o caminho absoluto do arquivo php que faz o upload
		fetch('http://localhost/testes/upload_imagens/upload.php', {
		  method: 'POST',
		  body: form  
		}).then(function(response){
			
			return response.json();
		}).then(function(data){
			
			if(data.success){
					
				window.location.href = "http://localhost/testes/upload_imagens/resultado.php";
				
			}else{
			
				let modalBody = "<h3>"+data.msg+"</h3>";
				
				if(data.errors){
					
					errors = data.errors;
				
					erros.forEach(function(erro){
					
						modalBody += "<p>"+erro+"</p>";
						
					});
					
				}
				
				modalShow(modalBody);
				
				btnEnviar.innerText = "Enviar";
		
				btnEnviar.disabled = false;
				
			}
			
			
		}).catch(function(erro){
			
			let msgErro = "<h3>Não foi possível enviar as imagens!</h3>";
			
			modalShow(msgErro);
			
			btnEnviar.innerText = "Enviar";
		
			btnEnviar.disabled = false;
			
		});
		
	}else{
	
		modalShow("<h3>Nenhum arquivo encontrado!</h3>");
		
		btnEnviar.innerText = "Enviar";
		
		btnEnviar.disabled = false;
		
	}
		
}


function modalShow(html){
	
	modalFundo.style.display = 'block';
	modalMeio.style.display = 'block';
	modalBody.innerHTML = html;
	
}

function modalClose(){
	
	modalFundo.style.display = 'none';
	modalMeio.style.display = 'none';
	modalBody.innerHTML = '';
}
