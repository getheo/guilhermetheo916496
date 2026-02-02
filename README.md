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
- <a href="https://laravel.com/docs/12.x/installation">Laravel</a> Framework PHP
- <a href="https://www.docker.com/products/docker-desktop/">Docker</a> Desktop instalado
- <a href="https://getcomposer.org/">Composer</a> (dependências do PHP Laravel)
<br>


### Faça o Clone do Projeto
#### O projeto encontra-se no GIT na branch main, execute o comando para baixar:
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

##### Mostra um artista específico (GET `/api/artista/{id}`)

```json
{
  "message": "Artista encontrado",
  "artista": {
    "id": 3,
    "art_nome": "Michel Teló",
    "art_descricao": null,
    "art_status": true,
    "created_at": "2026-01-29T21:17:48.000000Z",
    "updated_at": "2026-01-29T21:17:48.000000Z",
    "deleted_at": null,
    "albuns": [
      {
        "id": 8,
        "artista_id": 3,
        "alb_titulo": "Bem Sertanejo",
        "alb_data_lancamento": null,
        "alb_status": true,
        "created_at": "2026-01-29T21:17:48.000000Z",
        "updated_at": "2026-01-29T21:17:48.000000Z",
        "deleted_at": null
      },
      {
        "id": 9,
        "artista_id": 3,
        "alb_titulo": "Bem Sertanejo - O Show (Ao Vivo)",
        "alb_data_lancamento": null,
        "alb_status": true,
        "created_at": "2026-01-29T21:17:48.000000Z",
        "updated_at": "2026-01-29T21:17:48.000000Z",
        "deleted_at": null
      },
      {
        "id": 10,
        "artista_id": 3,
        "alb_titulo": "Bem Sertanejo - (1ª Temporada) - EP",
        "alb_data_lancamento": null,
        "alb_status": true,
        "created_at": "2026-01-29T21:17:48.000000Z",
        "updated_at": "2026-01-29T21:17:48.000000Z",
        "deleted_at": null
      }
    ],
    "foto": [
      {
        "id": 1,
        "artista_id": 3,
        "fa_data": "2026-01-29 21:20:47",
        "fa_bucket": "mybucket",
        "fa_hash": "artista/3/wIrSh8rZr8vB7d136zS689TW3HLQ2z5bGwh03TLs.jpg",
        "created_at": "2026-01-29T21:20:47.000000Z",
        "updated_at": "2026-01-29T21:20:47.000000Z"
      }
    ]
  }
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
  "alb_titulo": "Novo album para o artista (15)",
  "artista_id": 15
}
```

##### Resposta do cadastro
```json
{
  "message": "Album cadastrado e vinculado ao artista com sucesso.",
  "album": {
    "artista_id": "15",
    "alb_titulo": "Novo album para o artista (15)",
    "updated_at": "2026-01-29T21:35:04.000000Z",
    "created_at": "2026-01-29T21:35:04.000000Z",
    "id": 34
  }
}
```

---

- Musica


| Método  | Endpoint           | Descrição                      |                 Parâmetros / Corpo                          |
|---------|--------------------|--------------------------------|-------------------------------------------------------------|
| `GET`   | `/api/musica`      | Retorna todos as Músicas       | (paginado)                                                  |
| `GET`   | `/api/musica/{id}` | Retorna uma música específica  | `id`                                                        |
| `POST`  | `/api/musica`      | Cadastra uma música            | `{ "album_id": "10", "mus_titulo": "Minha música nova" }`   |
| `PUT`   | `/api/musica/{id}` | Atualiza uma  música           | `{ "album_id": 10, "mus_titulo": "Novo titulo da música" }` |
| `DELETE`| `/api/musica/{id}` | Exclui uma música              | `id`                                                        |


### 🔄 Exemplo de Requisição

##### Mostra todas as músicas (GET `/api/album`)

```json
{
  "id": 11,
  "album_id": 11,
  "mus_titulo": "Amet sed iusto nam eum architecto enim. Deserunt id sint ut voluptatibus dolorem. Qui facilis et expedita vero nihil animi.",
  "mus_arquivo": "Quae dolor et dolor sunt nobis nesciunt. Culpa eius excepturi sequi doloremque dolorum et. Et cum rerum rerum vel fugiat.",
  "mus_status": false,
  "created_at": "2026-01-29T21:17:48.000000Z",
  "updated_at": "2026-01-29T21:17:48.000000Z",
  "deleted_at": null,
  "album": {
    "id": 11,
    "artista_id": 4,
    "alb_titulo": "Use Your Illusion I",
    "alb_data_lancamento": null,
    "alb_status": true,
    "created_at": "2026-01-29T21:17:48.000000Z",
    "updated_at": "2026-01-29T21:17:48.000000Z",
    "deleted_at": null
  }
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

- Regionais (API externa)


| Método  | Endpoint         | Descrição                 |                    parâmetros / Corpo                      |
|---------|------------------|---------------------------|------------------------------------------------------------|
| `GET`   | `/api/regional`  | Mostra Unidade Regionais  | `{ "id": "1", "nome": "Nome da Regional", "ativo": true }` |


### 🔄 Exemplo de Requisição

##### Mostrar todas as Regionais (GET `/api/regional`)

```json
{
  "id": 28,
  "nome": "COORDENADORIA DE POLÍCIA COMUNITÁRIA",
  "ativo": true,
  "created_at": "2026-01-29T21:17:49.000000Z",
  "updated_at": "2026-01-29T21:17:49.000000Z",
  "deleted_at": null
}
```

---