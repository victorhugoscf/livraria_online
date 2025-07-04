@extends('layouts.app')
@section('content')
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Listagem de Livros</h4>
            <button type="button" class="btn btn-light btn-sm rounded-pill shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createBookModal">
                <i class="fas fa-plus-circle me-2"></i> Adicionar Novo Livro
            </button>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Campo de busca -->
            <div class="mb-4">
                <div class="input-group rounded-3">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 rounded-end-3" id="searchBooks" placeholder="Buscar por ISBN, título ou autor..." aria-label="Buscar livros">
                </div>
            </div>

            @if ($books->isEmpty())
                <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                    <h5 class="alert-heading">Ops! Nenhum livro encontrado.</h5>
                    <p class="mb-0">Parece que não há livros registrados no momento. Que tal adicionar um?</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle caption-top" id="booksTable">
                        <caption class="text-muted mb-3">Lista completa dos livros disponíveis no acervo.</caption>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="rounded-start-3">ID</th>
                                <th scope="col">ISBN</th>
                                <th scope="col">Título</th>
                                <th scope="col">Autor</th>
                                <th scope="col">Editora</th>
                                <th scope="col">Ano</th>
                                <th scope="col">Gênero</th>
                                <th scope="col">Idioma</th>
                                <th scope="col">Páginas</th>
                                <th scope="col">Total</th>
                                <th scope="col">Disponíveis</th>
                                <th scope="col" class="text-center">Ativo</th>
                                <th scope="col" class="text-center rounded-end-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="booksTableBody">
                            @foreach ($books as $book)
                            <tr>
                                <th scope="row">{{ $book->id }}</th>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher ?? 'N/A' }}</td>
                                <td>{{ $book->publication_year ?? 'N/A' }}</td>
                                <td>{{ $book->genre ?? 'N/A' }}</td>
                                <td>{{ $book->language }}</td>
                                <td>{{ $book->pages ?? 'N/A' }}</td>
                                <td>{{ $book->total_copies }}</td>
                                <td>{{ $book->available_copies }}</td>
                                <td class="text-center">
                                    @if ($book->is_active)
                                        <span class="badge bg-success rounded-pill px-3 py-2 text-uppercase fw-normal">Sim</span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 py-2 text-uppercase fw-normal">Não</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-info btn-sm rounded-circle shadow-sm view-book-btn" data-id="{{ $book->id }}" data-bs-toggle="modal" data-bs-target="#viewBookModal" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm rounded-circle shadow-sm edit-book-btn" data-id="{{ $book->id }}" data-bs-toggle="modal" data-bs-target="#editBookModal" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="delete-book-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-circle shadow-sm" title="Deletar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($books instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator || $books instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="d-flex justify-content-center mt-4" id="paginationLinks">
                        {{ $books->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>

    @include('books.partials.modals')
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Verificar se jQuery está carregado
    if (typeof jQuery === 'undefined') {
        console.error('jQuery não está carregado!');
        alert('Erro: jQuery não está carregado. Verifique a conexão com a CDN.');
        return;
    } else {
        console.log('jQuery carregado com sucesso, versão:', jQuery.fn.jquery);
    }

    // Configurar o CSRF token para todas as requisições AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Função de busca com AJAX
    $('#searchBooks').on('input', function() {
        const searchTerm = $(this).val().trim();
        console.log('Termo de busca:', searchTerm);

        $.ajax({
            url: '{{ route("books.index") }}',
            method: 'GET',
            data: { search: searchTerm },
            success: function(data) {
                console.log('Resposta da busca:', data);

                // Atualizar a tabela com os novos dados
                $('#booksTableBody').html($(data).find('#booksTableBody').html());
                $('#paginationLinks').html($(data).find('#paginationLinks').html());

                // Atualizar mensagem de "nenhum livro encontrado"
                if ($(data).find('#booksTableBody tr').length === 0) {
                    $('#booksTable').after('<div class="alert alert-info text-center py-4 rounded-3 mt-3" id="noResults">Nenhum livro encontrado para o termo de busca.</div>');
                } else {
                    $('#noResults').remove();
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro na busca:', error, xhr.responseText);
                alert('Erro ao realizar a busca: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Modal de criação
    $('#createBookForm').on('submit', function(event) {
        event.preventDefault();
        if (!this.checkValidity()) {
            event.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const formData = new FormData(this);
        console.log('Enviando formulário de criação:', Object.fromEntries(formData));

        $.ajax({
            url: '{{ route("books.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('Resposta de criação:', data);
                $('#createBookModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Erro ao criar livro:', error, xhr.responseText);
                if (xhr.status === 422) {
                    const errors = JSON.parse(xhr.responseText).errors;
                    $.each(errors, function(field, messages) {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}`).next('.invalid-feedback').text(messages[0]);
                    });
                } else {
                    alert('Erro ao criar o livro: ' + xhr.status + ' ' + xhr.statusText);
                }
            }
        });
    });

    // Modal de edição
    $('.edit-book-btn').on('click', function() {
        const bookId = $(this).data('id');
        console.log('Botão de edição clicado para o livro ID:', bookId);

        $.ajax({
            url: `/books/${bookId}/edit`,
            method: 'GET',
            success: function(data) {
                console.log('Dados do livro recebidos:', data);

                if (data.message) {
                    console.error('Erro do servidor:', data.message);
                    alert('Erro: ' + data.message);
                    return;
                }

                // Preencher o formulário
                $('#edit_id').val(data.id || '');
                $('#edit_isbn').val(data.isbn || '');
                $('#edit_title').val(data.title || '');
                $('#edit_author').val(data.author || '');
                $('#edit_publisher').val(data.publisher || '');
                $('#edit_publication_year').val(data.publication_year || '');
                $('#edit_edition').val(data.edition || '');
                $('#edit_genre').val(data.genre || '');
                $('#edit_language').val(data.language || 'Português');
                $('#edit_pages').val(data.pages || '');
                $('#edit_total_copies').val(data.total_copies || 0);
                $('#edit_available_copies').val(data.available_copies || 0);
                $('#edit_is_active').prop('checked', !!data.is_active);
                $('#editBookForm').attr('action', `/books/${bookId}`);
                $('#editBookForm').removeClass('was-validated');
                $('.invalid-feedback').text('');

                $('#editBookModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao buscar dados do livro:', error, xhr.responseText);
                alert('Erro ao carregar os dados do livro: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Modal de visualização
    $('.view-book-btn').on('click', function() {
        const bookId = $(this).data('id');
        console.log('Botão de visualização clicado para o livro ID:', bookId);

        $.ajax({
            url: `/books/${bookId}/json`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('Dados do livro recebidos:', data);

                if (data.message) {
                    console.error('Erro do servidor:', data.message);
                    alert('Erro: ' + data.message);
                    return;
                }

                // Preencher os campos de visualização
                $('#view_isbn').text(data.isbn || 'N/A');
                $('#view_title').text(data.title || 'N/A');
                $('#view_author').text(data.author || 'N/A');
                $('#view_publisher').text(data.publisher || 'N/A');
                $('#view_publication_year').text(data.publication_year || 'N/A');
                $('#view_edition').text(data.edition || 'N/A');
                $('#view_genre').text(data.genre || 'N/A');
                $('#view_language').text(data.language || 'N/A');
                $('#view_pages').text(data.pages || 'N/A');
                $('#view_total_copies').text(data.total_copies || '0');
                $('#view_available_copies').text(data.available_copies || '0');
                $('#view_is_active').text(data.is_active ? 'Sim' : 'Não');

                $('#viewBookModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erro ao buscar dados do livro:', error, xhr.responseText);
                alert('Erro ao carregar os dados do livro: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });

    // Validação do formulário de edição
    $('#editBookForm').on('submit', function(event) {
        event.preventDefault();
        if (!this.checkValidity()) {
            event.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        const formData = new FormData(this);
        const bookId = $('#edit_id').val();

        // Spoof do método PATCH
        formData.append('_method', 'PATCH');

        $.ajax({
            url: `/books/${bookId}`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                $('#editBookModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    const errors = JSON.parse(xhr.responseText).errors;
                    $.each(errors, function(field, messages) {
                        $(`#edit_${field}`).addClass('is-invalid');
                        $(`#edit_${field}`).next('.invalid-feedback').text(messages[0]);
                    });
                } else if (xhr.status === 405) {
                    alert('Erro: Método HTTP não permitido (405). Verifique se você está spoofando o método corretamente.');
                } else {
                    alert('Erro ao atualizar o livro: ' + xhr.status + ' ' + xhr.statusText);
                }
            }
        });
    });

    // Confirmação de exclusão
    $('.delete-book-form').on('submit', function(event) {
        event.preventDefault();
        if (!confirm('Tem certeza que deseja deletar este livro?')) {
            return;
        }

        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'DELETE',
            success: function(data) {
                console.log('Livro deletado:', data);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Erro ao deletar livro:', error, xhr.responseText);
                alert('Erro ao deletar o livro: ' + xhr.status + ' ' + xhr.statusText);
            }
        });
    });
});
</script>
@endsection