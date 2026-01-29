# Projeto prático para o PROCESSO SELETIVO CONJUNTO Nº 001/2026/SEPLAG e demais Órgãos

Candidato: Guilherme Théo Coleta Arruda | CPF: 916.496.921-53 | Inscrição: 16352 | Perfil: Engenheiro da Computação- Sênior
<br><br>
### Projeto Prático - IMPLEMENTAÇÃO FULL STACK SÊNIOR - JAVA + ANGULAR/REACT
Neste projeto o(a) candidato(a) implementar uma solução fullstack que possibilite o gerenciamento de artistas e seus álbuns
<br><br>

### Projeto API REST em PHP Laravel + postgreSQL + Docker Compose
Pórem, este repositório contém um projeto com uma solução alternativa utilizando outras tecnologias e será utilizado exclusivamente para este projeto e assim, espero que seja avaliado os conceitos de desenvolvimento.
<br><br>
### 🛠 Tecnologias

#### As seguintes ferramentas foram usadas na construção do projeto:
- PHP 8+
- Laravel 11+
- PostgreSQL
- MinIO (armazenamento das fotos)
- Docker e Docker Compose
<br>

### 🛠 Pré-requisitos
- <a href="https://git-scm.com/downloads">GIT</a> instalado para baixar o projeto
- <a href="https://www.docker.com/products/docker-desktop/">Docker</a> Desktop instalado
- <a href="https://getcomposer.org/">Composer</a> (dependências do PHP Laravel)
<br>


### Faça o Clone do Projeto
#### O projeto encontra-se no GIT na branch master, execute o comando para baixar:
```bash
git clone https://github.com/getheo/guilhermetheo916496.git
```
<br>

#### Navegue até o diretório onde realizou o clone do projeto
`cd guilhermetheo916496`
<br>

#### Na raíz do projeto já estão os arquivos de configurações
`.env`
`Dockerfile`
`docker-compose.yml`
<br>

#### Instale as dependências do PHP Laravel
```bash
composer install
```
<br>

### 🐳 Verificando o Docker

Verifica se o Docker Compose está instalado
```bash
docker --version
```

Verifica se já existe Containers instalados
```bash
docker ps -a
```
<br>

### 🏗️ Configurando o ambiente
#### Os arquivos (Dockerfile e docker-compose.yml) estão configurados para instanciar e subir os containers:
- api-seletivo-seplag
- db
- minio_server

#### Suas respectivas imagens 
- api-seletivo-seplag
- postgres
- minio/minio
<br>

Desta forma, basta acessar a raiz do projeto pelo terminal e executar o comando:
```bash
docker compose up -d --build
```

Aguarde a instalação e configurações dos contaniers, após instalado, confirme a instalação executando novamente o comando:
```bash
docker ps -a
```
<br>

### Caso precise excluir tudo para refazer o processo:
```bash
docker compose down
```

### Exclui informações de cache:
```bash
docker system prune
```

### Confirme exclusão de cache de container:
```bash
docker container prune -f
```
<br>

### 🗄️ Configurando o banco de dados no container
Após a confirmação dos containers instalados com suas respectivas imagens, para garantir que tudo esteja funcionando, execute as migrations dentro do contaniner (api-seletivo-seplag)
```bash
docker exec api-seletivo-seplag php artisan migrate:fresh
```
<br>

Execute o comando abaixo para inserir alguns dados para os teste.
```bash
docker exec api-seletivo-seplag php artisan db:seed
```
<br>

### 📚 Gerando a Documentação
Execute o comando abaixo para criar a documentação Swagger, onde será possível testar todos os endpoints.
```bash
docker exec api-seletivo-seplag php artisan l5-swagger:generate
```
<br>

### 🌐 Iniciando o Servidor Web no Container
Execute o comando abaixo para instanciar o servidor web no container (api-seletivo-seplag)
```bash
docker exec api-seletivo-seplag php artisan serve
```
<br>

### 🧪 Testando a API
Para verificar a documentação e realizar os teste, basta acessar pelo navegador (Swagger e/ou POSTMAN):
```bash
http://localhost:8000/api/documentation
```

É necessário realizar a Autenticação no endpoint `/api/login`.
```bash
http://localhost:8000/api/login
```
- 📧 **Email:** `teste@seplag.mt.gov.br`
- 🔑 **Senha:** `seplag2026`


- Execute e será gerado o TOKEN. Copie e cole na variável "Authorize" (canto superior direito da tela do Swagger).
- Após esta ação é possível realizar os testes. Tempo do token expira em 5 minutos.
- Para renovar o token, utilize o serviço /api/refresh. Copie e cole o novo token na opção Authorize.
<br>

### Para verificar os arquivos publicados no MinIO, acesse:
```bash
http://localhost:9090/login
```

- 📧 **Username:** `minio`
- 🔑 **Senha:** `miniostorage`
<br>


### 📌 Endpoints da API

Abaixo estão os principais endpoints da API.


#### 📝 Rotas e Funcionalidades

- Autenticação


| Método  | Endpoint      | Descrição                        |                       Parâmetros / Corpo                         |
|---------|---------------|----------------------------------|------------------------------------------------------------------|
| `POST`  | `/api/login`  | Autenticação do usuário          | `{"email": "teste@seplag.mt.gov.br", "password": "seplag2026" }` |
| `POST`  | `/api/refresh`| Renovar o Token de Acesso        | `{"email": "teste@seplag.mt.gov.br", "password": "seplag2026" }` |


### 🔄 Exemplo de Requisição

##### Autenticar um usuário (POST `/api/login`)

```json
{  
  "email": "teste@seplag.mt.gov.br",
  "password": "seplag2026"
}
```

---


- Artistas


| Método  | Endpoint                 | Descrição                      |                      Parâmetros / Corpo                 |
|---------|--------------------------|--------------------------------|---------------------------------------------------------|
| `GET`   | `/api/artista`           | Retorna todos os Artistas      | (paginado)                                              |
| `GET`   | `/api/artista/{id}`      | Retorna um artista específico  | `id`                                                    |
| `POST`  | `/api/artista`           | Cadastra um artista            | `{ "art_nome": "Nome artista", "art_descricao": ""}`    |
| `PUT`   | `/api/artista/{id}`      | Atualiza um artista            | `{ "art_nome": "Novo artista" }`                        |
| `DELETE`| `/api/artista/{id}`      | Exclui um artista              | `id`                                                    |


### 🔄 Exemplo de Requisição

##### Cadastrar um artista (POST `/api/artista`)

```json
{
  "art_nome": "Nome unidade"  
}
```

---

- Album


| Método  | Endpoint          | Descrição                      |                 Parâmetros / Corpo                     |
|---------|-------------------|--------------------------------|--------------------------------------------------------|
| `GET`   | `/api/album`      | Retorna todos os Albuns        | (paginado)                                             |
| `GET`   | `/api/album/{id}` | Retorna um album específico    | `id`                                                   |
| `POST`  | `/api/album`      | Cadastra um album              | `{ "alb_titulo": "Nome album", "artista_id": 1 }`      |
| `PUT`   | `/api/album/{id}` | Atualiza um  album             | `{ "alb_titulo": "Novo nome album", "artista_id": 2 }` |
| `DELETE`| `/api/album/{id}` | Exclui um album                | `id`                                             |


### 🔄 Exemplo de Requisição

##### Cadastrar uma album (POST `/api/album`)

```json
{
  "alb_titulo": "Nome de um album",
  "artista_id": 2
}
```

---

- Foto Artista


| Método  | Endpoint               | Descrição                          |            parâmetros / Corpo           |
|---------|------------------------|------------------------------------|-----------------------------------------|
| `POST`  | `/api/foto-artista`    | Cadastra uma foto para um artista  | `{ "artista_id": "1", "file": "foto.jpg" }` |


### 🔄 Exemplo de Requisição

##### Cadastrar uma foto de capa para um artista (POST `/api/foto-artista`)

```json
{
  "artista_id": "1",
  "file": "foto.jpg"
}
```

---

- Foto Album


| Método  | Endpoint               | Descrição                          |            parâmetros / Corpo                   |
|---------|------------------------|------------------------------------|-------------------------------------------------|
| `POST`  | `/api/foto-album`      | Cadastra uma foto para um album    | `{ "album_id": "1", "file": "foto-album.jpg" }` |


### 🔄 Exemplo de Requisição

##### Cadastrar uma foto de capa para um album (POST `/api/foto-album`)

```json
{
  "album_id": "1",
  "file": "foto-album.jpg"
}
```

---