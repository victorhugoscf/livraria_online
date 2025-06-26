@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Listagem de Livros</h4>
            <a href="{{ url('/books/create') }}" class="btn btn-light btn-sm rounded-pill shadow-sm d-flex align-items-center">
                <i class="fas fa-plus-circle me-2"></i> Adicionar Novo Livro
            </a>
        </div>
        <div class="card-body p-4">
            @if ($books->isEmpty())
                <div class="alert alert-info text-center py-4 rounded-3" role="alert">
                    <h5 class="alert-heading">Ops! Nenhum livro encontrado.</h5>
                    <p class="mb-0">Parece que não há livros registrados no momento. Que tal adicionar um?</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle caption-top">
                        <caption class="text-muted mb-3">Lista completa dos livros disponíveis no acervo.</caption>
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="rounded-start-3">#ID</th>
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
                        <tbody>
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
                                        <a href="{{ url('/books/' . $book->id) }}" class="btn btn-info btn-sm rounded-circle shadow-sm" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('/books/' . $book->id . '/edit') }}" class="btn btn-warning btn-sm rounded-circle shadow-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('/books/' . $book->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este livro?');" class="d-inline">
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

                {{-- Se o $books for uma instância de Paginator, as links() serão exibidas --}}
                @if ($books instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator || $books instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $books->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
