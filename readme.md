# Site MedAvaliar
É um site para avaliação de clínicas médicas divididas em diferentes especialidades.
O usuário poderar logar e cadastrar uma nova clínica para que ela seja avaliada por outros membros.

Neste projeto consolidei os conhecimentos em Design Patterns DAO, CRUD ao banco de dados SQL com relacionamento entre tabelas e Orientação a Objetos na linguagem PHP.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F01site.jpg?alt=media&token=192193b6-d22c-41ff-932d-5358d28da3dc" heigth="500" width="500">
</div>

# ÍNDICE
1. [SOBRE O PROJETO](#1)
2. [INSTALAÇÃO](#2)

<div id="1" />

## Sobre o projeto

Neste projeto é possível registrar como usuário e realizar o cadastro de uma nova clínica no sistema.

Após o envio da clínica, ela ficará disponível para os outros usuários avaliarem dando sua nota e adicionando comentários.

### 1 - Sistema de autenticação
Usuário deve se cadastrar no sistema com seu email e senha para utilizar funcionalidades

### 2 - Tela de edição de perfil
Usuário pode editar suas informações como foto e biografia na tela de edição de perfil

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F02edicaoperfil.jpg?alt=media&token=31881242-a536-4417-9cae-575859cf020e" heigth="500" width="500">
</div>

### 2 - Tela inicial com todas as categorias de clínicas
Nesta tela são listadas todas as categorias por diferetes categorias. Cada clínica tem uma nota que é gerada através de um calculo com a média de avaliação por categoria de todos os usuários.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F03categorias.jpg?alt=media&token=d1f1fcd2-76cf-403a-8ea7-4a877916bf56" heigth="500" width="500">
</div>

### 3 - Tela de cadastro de clínica
Nesta tela o usuário deverá informar o nome da clínica, imagem, categoria, Estado onde é localizada, cidade, bairro, link de incorporação de localização fornecido pelo Google Maps e descrição.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F04-cadstro-clinica.jpg?alt=media&token=6d9319fe-a8d5-4bbd-a6fd-53a359a56a67" heigth="500" width="500">
</div>

### 4 - Página de detalhes sobre a clínica

Nesta tela são apresentadas as informações da clinica, como: localização no mapa, endereço, descrição das suas atividades e sua imagem.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F05-detalhes-clinica.jpg?alt=media&token=16f1a23e-4804-4608-aebb-0c2b31b6d12e" heigth="500" width="500">
</div>

### 5 - Seção de avaliação
Na parte debaixo da tela é possível que o usuário deixe sua avaliação sobre a clínica, caso ele ainda não tenha avaliado.

O usuário poderá deixar seu comentário, além da sua nota de 1 a 10 nas seguinte categorias de avaliação: atendimento, qualidade dos serviços, qualidade dos equipamentos, tempo de espera e custo benefício.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F07-avalia-anonim.jpg?alt=media&token=98e9f605-580f-4e67-a157-6eb13d08bae9" heigth="500" width="500">
</div>

### 6 - Possibilidade de avaliação anônima

O usuário poderá fazer sua avaliação de forma anônima caso ele prefira.

### 7 - Seção de comentários

Mostra os comentários sobre a clínica e as notas de cada categoria de avaliação

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F08-comentario.jpg?alt=media&token=67e0f915-f5a1-4615-80f0-e6f3485c6f00" heigth="500" width="500">
</div>

### 8 - Tela de perfil de usuários
Mostra detalhes do perfil do usuário como foto, biografia e clínicas que ele já adicionou no site.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F09-tela%20perfil.jpg?alt=media&token=bb42c28d-370b-4d4c-b9cb-8c6f90130e73" heigth="500" width="500">
</div>

### 9 - Sistema de busca
O usuário poderá buscar clínica pelo nome ou pela localidade dela.

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F10-busca.jpg?alt=media&token=95335388-6b86-4bb9-b730-d276cb10645c" heigth="500" width="500">
</div>

<div id="2" />

## Instalação

### Requisitos

Ter instalado o Xampp

### Clone o projeto

Dentro da pasta `htdocs` do seu Xampp dê os seguintes comandos:

```
git clone https://github.com/UhCardoso/MedAvaliar.git
```
```
cd MedAvaliar
```

### Instale a base de dados
- No navegador na url ``http://localhost/phpmyadmin``
 - Crie um novo banco de dados com o nome ``medavaliar``

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F11-novo%20banco.jpg?alt=media&token=1b845482-94a1-4542-9366-b7549bd0d538" heigth="500" width="500">
</div>

- Vá na opção "importar" e escolhar o arquivo "medavaliar.sql" na raiz do projeto para fazer a importação

<div style="text-align: center;">   
    <img src="https://firebasestorage.googleapis.com/v0/b/werlen-dev.appspot.com/o/projects%2Freadmes%2Fmedavaliar%2F12-export%20database.jpg?alt=media&token=e98ace67-2ffc-49df-a3f9-a9e1626cf1af" heigth="500" width="500">
</div>

- Acesse a url ``http://localhost/medavaliar`` e entre no site
