# Fazendo o preview e upload de imagens
Nesta aplicação utilizei o Javascript para fazer a seleção e preview de múltiplas imagens na página, coloquei um limite de 10 imagens e também uma verificação para que somente arquivos de imagem sejam carregados. Utilizei mais o HTML e CSS no frontend e no backend o Php que faz os uploads das imagens e cadastra em um banco de dados MySQL. Você pode importar o banco de dados que está em banco/upload_imagens.sql e fazer as devidas configurações de conexão com o banco de dados no método construtor da classe Arquivo que está em app/Arquivo.php. Não se esqueça de dar a permissão de acesso para a pasta onde serão salvas as imagens pelo Php.

## Tela inicial
![tela inicial](https://github.com/rodriguesrenato61/preview-upload-imagens/blob/master/imagens/print01.png)

## Selecionando e fazendo preview
![selecionando imagens](https://github.com/rodriguesrenato61/preview-upload-imagens/blob/master/imagens/print02.png)

## Verificando formato de imagem
![validando imagem](https://github.com/rodriguesrenato61/preview-upload-imagens/blob/master/imagens/print03.png)

## Não envia se não houver escolhido alguma imagem
![mensagem erro](https://github.com/rodriguesrenato61/preview-upload-imagens/blob/master/imagens/print05.png)

## Fazendo upload e cadastrando no banco de dados
![sucesso](https://github.com/rodriguesrenato61/preview-upload-imagens/blob/master/imagens/print06.png)
