README - Sistema de Gerenciamento de Livros com Laravel

Este é um sistema de gerenciamento de livros desenvolvido para um trabalho acadêmico, utilizando Laravel 11, Bootstrap 5, jQuery e MySQL. Ele permite cadastrar, listar, editar, visualizar e excluir livros, com interface responsiva e modais para interação.

Objetivo

Gerenciar informações de livros (ISBN, título, autor, editora, ano de publicação, gênero, idioma, páginas, exemplares totais/disponíveis, status) em uma interface amigável, com listagem, busca e paginação.
Tecnologias

    Laravel 11: Framework PHP para backend.
    Bootstrap 5: Interface frontend responsiva.
    jQuery: Manipulação de DOM e AJAX.
    MySQL: Banco de dados relacional.
    Blade: Templates do Laravel.

Estrutura do Projeto

    app/Http/Controllers/BookController.php: Controla ações como listar, criar, editar, excluir e buscar livros.
    app/Models/Book.php: Modelo Eloquent para a tabela books.
    database/migrations/: Define a tabela books com campos como ISBN, título, etc.
    resources/views/layouts/app.blade.php: Layout principal com imports de Bootstrap, jQuery, menu superior e rodapé.
    resources/views/books/index.blade.php: Lista livros com tabela, busca e botões para modais.
    resources/views/partials/modals/: Contém modais de criação, edição e visualização.
    routes/web.php: Define rotas do sistema.

Rotas

    GET /books: Lista livros.
    GET /books/create: Formulário de criação (opcional, via modal).
    POST /books: Salva novo livro.
    GET /books/{id}/json: Retorna dados do livro em JSON.
    GET /books/{id}/edit: Formulário de edição (opcional, via modal).
    PUT/PATCH /books/{id}: Atualiza livro.
    DELETE /books/{id}: Exclui livro.
    GET /books/search: Busca livros.

Instalação

    Clone o repositório:

    git clone https://github.com/victorhugoscf/livraria_online
    cd livraria_online

    Instale as dependências com o Composer:

    composer install

    Copie o arquivo .env e configure o banco de dados:
    cp .env.example .env

    Gere a chave da aplicação:

    php artisan key:generate

    Execute as migrações para criar a tabela books:

    php artisan migrate

    Inicie o servidor Laravel:

    php artisan serve

    Acesse a aplicação:

    http://localhost:8000/books
    
Funcionalidades

    Listagem: Exibe livros em tabela com paginação e busca.
    Criação: Modal com formulário para adicionar livro (POST para books.store).
    Edição: Modal para editar livro, preenchido via AJAX (books.showJson, PATCH para books.update).
    Visualização: Modal com detalhes do livro (somente leitura, via AJAX).
    Exclusão: Remove livro com confirmação (DELETE para books.destroy).
    Busca: Filtra livros por título, autor, etc.

Estilização

    Usa Bootstrap 5 para layout responsivo.
    Modais estilizados com fundo branco e bordas pretas, botões em preto/branco.
    Arquivos de modais em partials/modals (criação, edição, visualização), incluídos no index.blade.php.

