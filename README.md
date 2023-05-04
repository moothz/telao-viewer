# telao-viewer
 Mostra de 1 a 4 telas em um monitor 4K
 Se quiser que mostrem em um monitor FullHD, só colocar o zoom em 50%

 ⚠️ **Atenção**: Códido legado. *Não* contém boas práticas.

## Screenshots

### Criação de Telas
![alt text](telao1.png)

### Atalhos
<p align="center">
  <img width="460" height="300" src="telao2.png">
</p>


## Como instalar
0. Baixar/clonar este repositorio e colocar os arqivos na pasta publica do servidor (ex.: /var/www/html)
1. Instalar ffmpeg no sistema (completo, com ffprobe)
2. Criar base de dados, usuário e senha
3. Importar arquivo telao.sql para que as tabelas necessárias sejam criadas
4. Editar o arquivo `admin/config.php` com os dados criados