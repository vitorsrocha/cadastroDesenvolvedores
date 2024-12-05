# Cadastro de Desenvolvedores

Projeto consiste em cadastrar desenvolvedores e seus níveis, com a possibilidade de editar e excluir o mesmo. O projeto está usando conceitos de Clean Architecture.

## 🚀 Começando

Na raiz do projeto contém um script chamado updateImageDocker.sh responsavel por criar as imagens do Frontend e Backend, e subir via docker compose junto com MYSQL8

### 📋 Pré-requisitos

Necessário instalar Docker Compose

## 🛠️ Tecnologias

* [PHP 8]
* [Compose]
* [Angular 18]
* [Node 22]
* [Mysql 8]

## Collections

O projeto contém um arquivo de importação da collection Postman chamado 'Cadastro de Desenvolvedores.api' contendo todas as requests.

## Tabelas do Banco

Na Raiz do projeto contém o arquivo o schema (schema.sql) das tabelas.

## URL 

### Frontend 

- localhost:90/desenvolvedores
- localhost:90/niveis
  
## 🚚 Endpoints da API 

- BaseURL = localhost:81

### **Níveis**

- **Filtro Níveis (GET):** `/api/niveis/filtro?valor=value`

  - **Resposta de Sucesso (200):** Retorna a lista de níveis existentes.

  ```json
  {
    "id": 1,
    "nivel": "Nome do Nível"
  }
  ```

  - **Resposta de Erro (404):** Retorna se não houver nenhum nível cadastrado.

- **Listar Níveis (GET):** `/api/niveis`

  - **Resposta de Sucesso (200):** Retorna a lista de níveis existentes.

  ```json
  {
    "id": 1,
    "nivel": "Nome do Nível"
  }
  ```

  - **Resposta de Erro (404):** Retorna se não houver nenhum nível cadastrado.

- **Cadastrar Nível (POST):** `/api/niveis`

  - **Corpo da Requisição:**

  ```json
  {
    "nivel": "Nome do Nível"
  }
  ```

  - **Resposta de Sucesso (201):** Retorna o novo nível criado.
  - **Resposta de Erro (400):** Retorna se o corpo da requisição estiver incorreto.

- **Editar Nível (PUT/PATCH):** `/api/niveis?id=1`

  - **Corpo da Requisição:**

  ```json
  {
    "nivel": "Nome do Nível"
  }
  ```

  - **Resposta de Sucesso (200):** Retorna o nível editado.
  - **Resposta de Erro (400):** Retorna se o corpo da requisição estiver incorreto.

- **Remover Nível (DELETE):** `/api/niveis?id=1`
  - **Resposta de Sucesso (204):** Retorna se o nível foi removido com sucesso.
  - **Resposta de Erro (400):** Retorna se houver desenvolvedores associados ao nível.

### **Desenvolvedores**

- **Filtro Desenvolvedores (GET):** `/api/desenvolvedores/filtro?valor=value`

  - **Resposta de Sucesso (200):** Retorna a lista de níveis existentes.

  ```json
  {
    "id": 1,
    "nome": "Nome do Desenvolvedor",
    "sexo": "M",
    "data_nascimento": "1990-01-01",
    "idade": 31,
    "hobby": "hobby",
    "nivel": {
      "id": 1,
      "nivel": "Nome do Nível"
    }
  }
  ```

  - **Resposta de Erro (404):** Retorna se não houver nenhum nível cadastrado.

- **Listar Desenvolvedores (GET):** `/api/desenvolvedores`

  - **Resposta de Sucesso (200):** Retorna a lista de desenvolvedores existentes.

  ```json
  {
    "id": 1,
    "nome": "Nome do Desenvolvedor",
    "sexo": "M",
    "data_nascimento": "1990-01-01",
    "idade": 31,
    "hobby": "hobby",
    "nivel": {
      "id": 1,
      "nivel": "Nome do Nível"
    }
  }
  ```

  - **Resposta de Erro (404):** Retorna se não houver nenhum desenvolvedor cadastrado.

- **Cadastrar Desenvolvedor (POST):** `/api/desenvolvedores`

  - **Corpo da Requisição:**

  ```json
  {
    "nivel_id": 1,
    "nome": "Nome do Desenvolvedor",
    "sexo": "M",
    "data_nascimento": "1990-01-01",
    "hobby": "hobby"
  }
  ```

  - **Resposta de Sucesso (201):** Retorna o novo desenvolvedor criado.
  - **Resposta de Erro (400):** Retorna se o corpo da requisição estiver incorreto.

- **Editar Desenvolvedor (PUT/PATCH):** `/api/desenvolvedores?id=1`

  - **Corpo da Requisição:**

  ```json
  {
    "nome": "Novo Nome do Desenvolvedor",
    "hobby": "hobby",
    "nivel_id": 2,
    "sexo": "F",
    "data_nascimento": "1990-01-01"
  }
  ```

  - **Resposta de Sucesso (200):** Retorna o desenvolvedor editado.
  - **Resposta de Erro (400):** Retorna se o corpo da requisição estiver incorreto.

- **Remover Desenvolvedor (DELETE):** `/api/desenvolvedores?id=1`
  - **Resposta de Sucesso (204):** Retorna se o desenvolvedor foi removido com sucesso.
  - **Resposta de Erro (400):** Retorna se houver problemas na remoção.
