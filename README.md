# telao-viewer
 Mostra de a 1 telas em um monitor 4K
 ⚠️ Códido legado. Não contém boas práticas.


## Como instalar
0. Baixar/clonar este repositorio e colocar os arqivos na pasta publica do servidor (ex.: /var/www/html)
1. Instalar ffmpeg no sistema (completo, com ffprobe)
2. Criar base de dados, usuário e senha
3. Importar arquivo telao.sql para que as tabelas necessárias sejam criadas
4. Editar o arquivo `admin/config.php` com os dados criados