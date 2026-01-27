# Projeto prático para o Processo Seletivo SEPLAG/2025



Candidato: Guilherme Théo Coleta Arruda<br>
CPF: 916.496.921-53<br>

- Inscrição: 9347 - Perfil: DESENVOLVEDOR PHP - SÊNIOR
- Inscrição: 9318 - Perfil: DESENVOLVEDOR PHP - PLENO
<br>

## Projeto API REST em PHP Laravel + base de dados postgreSQL + Docker Compose.
Este repositório contém um projeto com uma solução que será utilizado exclusivamente para uma avaliação de processo seletivo da SEPLAG.
<br>

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
git clone https://github.com/getheo/api-seletivo-seplag.git
```
<br>

#### Navegue até o diretório onde realizou o clone do projeto
`cd api-seletivo-seplag`
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
- 🔑 **Senha:** `seplag2025`


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
| `POST`  | `/api/login`  | Autenticação do usuário          | `{"email": "teste@seplag.mt.gov.br", "password": "seplag2025" }` |
| `POST`  | `/api/refresh`| Renovar o Token de Acesso        | `{"email": "teste@seplag.mt.gov.br", "password": "seplag2025" }` |


### 🔄 Exemplo de Requisição

##### Autenticar um usuário (POST `/api/login`)

```json
{  
  "email": "teste@seplag.mt.gov.br",
  "password": "seplag2025"
}
```

---


- Unidades


| Método  | Endpoint                 | Descrição                      |                      Parâmetros / Corpo                       |
|---------|--------------------------|--------------------------------|---------------------------------------------------------------|
| `GET`   | `/api/unidade`           | Retorna todas as Unidades      | (paginado)                                                    |
| `GET`   | `/api/unidade/{unid_id}` | Retorna uma unidade específica | `unid_id`                                                     |
| `POST`  | `/api/unidade`           | Cadastra uma unidade           | `{ "unid_nome": "Nome unidade", "unid_sigla": "SIGLA-UNID" }` |
| `PUT`   | `/api/unidade/{unid_id}` | Atualiza uma unidade           | `{ "unid_nome": "Novo nome" }`                                |
| `DELETE`| `/api/unidade/{unid_id}` | Exclui uma unidade             | `unid_id`                                                     |


### 🔄 Exemplo de Requisição

##### Cadastrar uma unidade (POST `/api/unidade`)

```json
{
  "unid_nome": "Nome unidade",
  "unid_sigla": "SIGLA-UNID"
}
```

---


- Lotações


| Método  | Endpoint                         | Descrição                                                   |                      Parâmetros / Corpo                                                                                         |
|---------|----------------------------------|-------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------|
| `GET`   | `/api/lotacao`                   | Retorna todas as Lotações (unidades e pessoas relacionadas) | (paginado)                                                                                                                      |
| `GET`   | `/api/lotacao/{lot_id}`          | Retorna lotação específica                                  | `lot_id`                                                                                                                        |
| `GET`   | `/api/lotacao/unidade/{unid_id}` | Pesquisa as pessoas lotadas em uma Unidade específica       | `unid_id`                                                                                                                       |
| `POST`  | `/api/lotacao`                   | Vincular uma pessoa a uma unidade (Lotação)                 | `{ "pes_id": 1, "unid_id": 2, "lot_data_lotacao": "2025-01-30", "lot_data_remocao": NULL, "lot_portaria": "Portaria 01-2025" }` |
| `PUT`   | `/api/lotacao/{lot_id}`          | Atualiza dados da lotação específica                        | `{ "lot_data_lotacao": "2025-01-30", "lot_data_remocao": "2025-04-01", "lot_portaria": "Portaria 01-2025" }`                    |
| `DELETE`| `/api/lotacao/{lot_id}`          | Exclui informação de vínculo de pessoa com unidade          | `lot_id`                                                                                                                        |


### 🔄 Exemplo de Requisição

##### Listas as pessoas lotadas na unidade (unid_id) pesquisada  (GET `/api/lotacao/1`)

```json
{
  "message": "Lotação encontrada",
  "lotacao": {
    "lot_id": 1,
    "pes_id": 1,
    "unid_id": 1,
    "lot_data_lotacao": "2021-01-01",
    "lot_data_remocao": null,
    "lot_portaria": "Portaria 01-2025",
    "created_at": "2025-04-01T20:55:35.000000Z",
    "updated_at": "2025-04-01T20:55:35.000000Z",
    "pessoa": {
      "pes_id": 1,
      "pes_nome": "Nome da primeira pessoa",
      "pes_data_nascimento": "2001-10-10",
      "pes_sexo": "M",
      "pes_mae": "Nome da Mãe 1 pessoa",
      "pes_pai": "Nome do Pai 1 pessoa",
      "created_at": "2025-04-01T20:55:34.000000Z",
      "updated_at": "2025-04-01T20:55:34.000000Z"
    },
    "unidade": {
      "unid_id": 1,
      "unid_nome": "Secretaria de Planejamento",
      "unid_sigla": "SEPLAG",
      "created_at": null,
      "updated_at": null
    }
  }
}
```

---


- Servidor Efetivo


| Método  | Endpoint                                   | Descrição                              |                                 Parâmetros / Corpo                             |
|---------|--------------------------------------------|----------------------------------------|--------------------------------------------------------------------------------|
| `GET`   | `/api/servidor-efetivo`                    | Retorna os servidores efetivos         | (paginado)                                                                     |
| `GET`   | `/api/servidor-efetivo/{pes_id}`           | Retorna um servidor efetivo específico | `pes_id`                                                                       |
| `GET`   | `/api/servidor-efetivo/unidade/{pes_nome}` | Pesquisa por parte do nome             | `{ "unid_nome": "Busca por parte do nome" }`                                   |
| `POST`  | `/api/servidor-efetivo`                    | Cadastra um novo servidor efetivo      | `{ "pes_id": "1", "se_matricula": "00001" }` (necessário cadastrar uma pessoa) |
| `PUT`   | `/api/servidor-efetivo/pes_{id}`           | Atualiza um servidor efetivo           | `{ "unid_nome": "Novo nome" }`                                                 |
| `DELETE`| `/api/servidor-efetivo/{pes_id}`           | Exclui um servidor efetivo             | `pes_id`                                                                       |


### 🔄 Exemplo de Requisição

##### Cadastrar um Servidor Efetivo (POST `/api/servidor-efetivo`)

```json
{
  "pes_id": "1",
  "se_matricula": "00001"
}
```

---


- Servidor Temporário


| Método  | Endpoint                            | Descrição                               |                                       Parâmetros / Corpo                                 |
|---------|-------------------------------------|-----------------------------------------|------------------------------------------------------------------------------------------|
| `GET`   | `/api/servidor-temporario`          | Retorna os servidores temporários       | (paginado)                                                                               |
| `GET`   | `/api/servidor-temporario/{pes_id}` | Retorna um servidor servidor temporário | `pes_id`                                                                                 |
| `POST`  | `/api/servidor-temporario`          | Cadastra um novo servidor temporário    | `{ "pes_id": "1", "st_data_admissao": "2024-02-10", "st_data_demissao": "2025-01-01" }` (necessário cadastrar uma pessoa)  |
| `PUT`   | `/api/servidor-temporario/pes_{id}` | Atualiza um servidor temporário         | `{ "st_data_admissao": "2024-02-10", "st_data_demissao": "2025-01-01" }`                 |
| `DELETE`| `/api/servidor-temporario/{pes_id}` | Exclui um servidor temporário           | `pes_id`                                                                                 |


### 🔄 Exemplo de Requisição

##### Cadastrar um Servidor Temporário (POST `/api/servidor-temporario`)

```json
{
  "pes_id": "5",
  "st_data_admissao": "2024-02-10",
  "st_data_demissao": "2025-01-01"
}
```

---

- Cidades (recurso opcional)


| Método  | Endpoint               | Descrição                      |                 Parâmetros / Corpo                   |
|---------|------------------------|--------------------------------|------------------------------------------------------|
| `GET`   | `/api/cidade`          | Retorna todas as Cidades       | (paginado)                                           |
| `GET`   | `/api/cidade/{cid_id}` | Retorna uma cidade específica  | `cid_id`                                             |
| `POST`  | `/api/cidade`          | Cadastra uma cidade            | `{ "cid_nome": "Nome cidade", "cid_uf": "MT" }`      |
| `PUT`   | `/api/cidade/{cid_id}` | Atualiza uma cidade            | `{ "cid_nome": "Novo nome cidade", "cid_uf": "SP" }` |
| `DELETE`| `/api/cidade/{cid_id}` | Exclui uma cidade              | `cid_id`                                             |


### 🔄 Exemplo de Requisição

##### Cadastrar uma cidade (POST `/api/cidade`)

```json
{
  "cid_nome": "Minha Cidade",
  "cid_uf": "MT"
}
```

---

- Endereços (recurso opcional)


| Método  | Endpoint                 | Descrição                      |                 Parâmetros / Corpo                   |
|---------|--------------------------|--------------------------------|------------------------------------------------------|
| `GET`   | `/api/endereco`          | Retorna todos os Endereços     | (paginado)                                           |
| `GET`   | `/api/endereco/{end_id}` | Retorna um endereço específico | `end_id`                                             |
| `POST`  | `/api/endereco`          | Cadastra um endereço           | `{ "end_tipo_logradouro": "Bloco III", "end_logradouro": "Rua do Endereço", "end_numero": "25", "end_bairro": "Bairro Tal", "cid_id": "1" }` |
| `PUT`   | `/api/endereco/{end_id}` | Atualiza um endereço           | `{ "end_tipo_logradouro": "Bloco I", "end_logradouro": "Rua atualizada", "end_numero": "10", "end_bairro": "Bairro Atualido", "cid_id": "1" }` |
| `DELETE`| `/api/endereco/{end_id}` | Exclui um endereço             | `end_id`                                             |


### 🔄 Exemplo de Requisição

##### Mostra um endereço (POST `/api/endereco/1`)

```json
{
  "message": "Endereço encontrado",
  "endereco": {
    "end_id": 1,
    "end_tipo_logradouro": "Bloco III",
    "end_logradouro": "Rua C - Complexo Paiaguás",
    "end_numero": 34,
    "end_bairro": "Centro Político Administrativo",
    "cid_id": 1,
    "created_at": "2025-04-04T15:23:09.000000Z",
    "updated_at": "2025-04-04T15:23:09.000000Z",
    "cidade": {
      "cid_id": 1,
      "cid_nome": "Cuiabá",
      "cid_uf": "MT",
      "created_at": "2025-04-04T15:23:09.000000Z",
      "updated_at": "2025-04-04T15:23:09.000000Z"
    }
  }
}
```

---

- Foto Pessoa


| Método  | Endpoint               | Descrição                      |            arâmetros / Corpo            |
|---------|------------------------|--------------------------------|-----------------------------------------|
| `POST`  | `/api/foto-pessoa`     | Cadastra uma foto para pessoa  | `{ "pes_id": "1", "file": "foto.jpg" }` |


### 🔄 Exemplo de Requisição

##### Cadastrar uma foto para uma pessoa (POST `/api/foto-pessoa`)

```json
{
  "pes_id": "1",
  "file": "foto.jpg"
}
```

---


