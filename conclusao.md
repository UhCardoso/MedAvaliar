# Site MedAvaliar
É um site para avaliação de clínicas médicas divididas em diferentes especialidades.
O usuário poderar logar e cadastrar uma nova clínica para que ela seja avaliada por outros membros.

Neste projeto consolidei os conhecimentos em Design Patterns DAO, CRUD ao MySQL utilizando stmt com relacionamento entre tabelas e Orientação a Objetos na linguagem PHP.

# ÍNDICE
1. [SOBRE O PROJETO](#1)
2. [INSTALAÇÃO](#2)

<div id="1" />

## Sobre o projeto

Neste projeto é possível realizar se registrar como usuário para o enviao do cadastro de uma nova clínica no sistema.

Após o envio da clínica, ela ficará disponível para que os outros usuários a avaliem dando sua nota e adicinando comentários.

### 1 - Sistema de autenticação
Usuário deve se cadastrar no sistema com seu email e senha para utilizar funcionalidades

### 2 - Tela de edição de perfil
Usuário pode editar suas informações como foto e biografia na tela de edição de perfil

[imagem]

### 2 - Tela inicial com todas as categorias de clínicas
Nesta tela é listada todas as categorias por diferetes categorias. Cada clínica tem uma nota que é gerada através de um calculo com a média de avaliação por categoria de todos os usuários.

[imagem]

### 3 - tela de cadastro de clínica
Nesta tela o usuário deverá informar o nome da cínica, imagem, categoria, Estado onde é localizada, cidade, bairro, link de incorporação de localização fornecido pelo Google Maps e descrição.

[imagem]

### 4 - Página de detalhes sobre a clínica

Nesta tela são apresentadas as informações da clinica, como: localização no mapa, endereço, descrição das suas atividades e sua imagem.

[imagem]

### 5 - Seção de avaliação
Na parte debaixo da tela é possível que o usuário deixe sua avaliação sobre a clínica, caso ele ainda não tenha avaliado.

O usuário poderá deixar seu comentário alem da sua nota de 1 a 10 nas seguinte categorias de avaliação: atendimento, qualidade dos serviços, qualidade dos equipamentos, tempo de espera e custo benefício.

### 6 - Possibilidade de avaliação anônima

O usuário poderá fazer sua avaliaçãode forma anônima caso ele prefira.

[imagem]

### 7 - Seção de comentários

Mostra os comentários sobre a clinica e as notas de cada categoria de avaliação

[imagem]

### 8 - Tela de perfil de usuários
Mostra detelhes do perfil do usuário mostrando sua foto, biografia e clínicas que ele já adicionou no site.

[imagem]

### 9 - Sistema de busca
O usuário poderá buscar clínica pelo nome dela ou por sua localização.

[imagem]

<div id="2" />

## Instalação

### Requisitos

Ter instalado o Xampp

### 