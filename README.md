# Ducheff
Repositorio do projeto de desenvolvimento de um sistema web de gestão de pedidos e do aplicativo mobile para android de solicitação de pedidos delivery.


# Estrutura do Projeto

O projeto está divido em três diretórios:

1 - Documentos: Precisa ser uma pasta protegida e privada, pois aqui está toda a documentação de Requisitos
e Testes do sistema e do Aplicativo Mobile.

2 - Release: É o diretório raiz do sistema web, precisar ser instalado no servidor Web, no local dos web sites.

3 - Mobile: É o diretório do projeto Gradle do aplicativo mobile, precisa ser protegido e privado.

# Configurações Gerais

O arquivo de configurações do sistema web está localizado na pasta /release/app/config/app.php lá você encontrará as principais configurações do sistema.

Para fazer configurações da base de dados você precisará editar o arquivo /release/app/config/database.php
informando o usuario e senha do banco de dados, e também o nome do banco de dados.
Todos os scripts SQL para criação do Banco estão localizados em /release/app/database/ sendo que a versão
mais recente do banco é a 'database-V1.3.sql'.

O script inserts.sql consiste em um script de teste de inserções na base de dados para verificar e testar
o comportamento do sistema com uma quantidade relativa de informações já cadastradas.

Para configurar o email você precisará editar o arquivo /release/app/config/mail.php informando o servidor
SMTP e o login e senha do email que você utilizará para enviar outros emails.

