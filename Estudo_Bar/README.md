#Sistema de Gestão de Bebidas
##Descrição
O Sistema de Gestão de Bebidas é uma aplicação web que permite a gestão de estoque de bebidas e autenticação de usuários. O sistema é desenvolvido em PHP e utiliza MySQL para o armazenamento de dados.

##Funcionalidades
Cadastro de Bebidas: Permite adicionar novas bebidas ao estoque.
Visualização de Estoque: Mostra a lista de bebidas no estoque e destaca as que estão próximas da validade.
Autenticação de Usuários: Permite o login de usuários com diferentes permissões.
Logout: Permite que o usuário encerre a sessão.

##Requisitos
Servidor Web (Apache, Nginx, etc.)
PHP 7.4 ou superior
MySQL 5.7 ou superior
Biblioteca PDO para PHP
Bootstrap (para estilização)

##Estrutura do Projeto
index.php: Página inicial de login.
dashboard.php: Página de cadastro de bebidas, acessível após login.
estoque.php: Página que exibe o estoque de bebidas e informações sobre a validade.
logout.php: Página para encerrar a sessão do usuário.
config.php: Arquivo de configuração do banco de dados.

##Uso
Acessar a Página de Login

Abra o navegador e vá para http://localhost/<NOME_DO_PROJETO>/index.php.
Login

Utilize as credenciais de exemplo fornecidas ou crie novos usuários diretamente no banco de dados.
Cadastro de Bebidas

Após o login, você será redirecionado para dashboard.php, onde pode adicionar novas bebidas.
Visualização do Estoque

Vá para estoque.php para visualizar o estoque e verificar as bebidas próximas da validade.
Logout

Clique no botão "Sair" para encerrar a sessão.

O comando de criar o BD estar no arquivo de texto 
Criar_BD.
