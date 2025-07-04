<!-- Modal de Criação -->
<div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="createBookModalLabel">📝Cadastrar Novo Livro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('books.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="isbn" class="form-label fw-semibold">ISBN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="isbn" name="isbn" required>
                            <div class="invalid-feedback">Por favor, insira um ISBN válido.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="title" name="title" required>
                            <div class="invalid-feedback">Por favor, insira o título do livro.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="author" class="form-label fw-semibold">Autor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="author" name="author" required>
                            <div class="invalid-feedback">Por favor, insira o autor do livro.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-semibold">Editora</label>
                            <input type="text" class="form-control rounded-3" id="publisher" name="publisher">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="publication_year" class="form-label fw-semibold">Ano de Publicação</label>
                            <input type="number" class="form-control rounded-3" id="publication_year" name="publication_year" min="1000" max="{{ date('Y') + 1 }}">
                            <div class="invalid-feedback">Por favor, insira um ano válido.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="edition" class="form-label fw-semibold">Edição</label>
                            <input type="text" class="form-control rounded-3" id="edition" name="edition">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="genre" class="form-label fw-semibold">Gênero</label>
                            <input type="text" class="form-control rounded-3" id="genre" name="genre">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="language" class="form-label fw-semibold">Idioma</label>
                            <input type="text" class="form-control rounded-3" id="language" name="language" value="Português">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="pages" class="form-label fw-semibold">Número de Páginas</label>
                            <input type="number" class="form-control rounded-3" id="pages" name="pages" min="1">
                            <div class="invalid-feedback">Por favor, insira um número válido de páginas.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="total_copies" class="form-label fw-semibold">Total de Exemplares</label>
                            <input type="number" class="form-control rounded-3" id="total_copies" name="total_copies" min="0">
                            <div class="invalid-feedback">Por favor, insira um número válido.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="available_copies" class="form-label fw-semibold">Exemplares Disponíveis</label>
                            <input type="number" class="form-control rounded-3" id="available_copies" name="available_copies" min="0">
                            <div class="invalid-feedback">Por favor, insira um número válido.</div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" checked>
                                <label class="form-check-label fw-semibold" for="is_active">Livro Ativo</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark rounded-pill shadow-sm">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="editBookModalLabel">⚙️Editar Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBookForm" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PATCH')
                <div class="modal-body p-4">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_isbn" class="form-label fw-semibold">ISBN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="edit_isbn" name="isbn" required>
                            <div class="invalid-feedback">Por favor, insira um ISBN válido.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_title" class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="edit_title" name="title" required>
                            <div class="invalid-feedback">Por favor, insira o título do livro.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_author" class="form-label fw-semibold">Autor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="edit_author" name="author" required>
                            <div class="invalid-feedback">Por favor, insira o autor do livro.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_publisher" class="form-label fw-semibold">Editora</label>
                            <input type="text" class="form-control rounded-3" id="edit_publisher" name="publisher">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_publication_year" class="form-label fw-semibold">Ano de Publicação</label>
                            <input type="number" class="form-control rounded-3" id="edit_publication_year" name="publication_year" min="1000" max="{{ date('Y') + 1 }}">
                            <div class="invalid-feedback">Por favor, insira um ano válido.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_edition" class="form-label fw-semibold">Edição</label>
                            <input type="text" class="form-control rounded-3" id="edit_edition" name="edition">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_genre" class="form-label fw-semibold">Gênero</label>
                            <input type="text" class="form-control rounded-3" id="edit_genre" name="genre">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_language" class="form-label fw-semibold">Idioma</label>
                            <input type="text" class="form-control rounded-3" id="edit_language" name="language">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_pages" class="form-label fw-semibold">Número de Páginas</label>
                            <input type="number" class="form-control rounded-3" id="edit_pages" name="pages" min="1">
                            <div class="invalid-feedback">Por favor, insira um número válido de páginas.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_total_copies" class="form-label fw-semibold">Total de Exemplares</label>
                            <input type="number" class="form-control rounded-3" id="edit_total_copies" name="total_copies" min="0">
                            <div class="invalid-feedback">Por favor, insira um número válido.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_available_copies" class="form-label fw-semibold">Exemplares Disponíveis</label>
                            <input type="number" class="form-control rounded-3" id="edit_available_copies" name="available_copies" min="0">
                            <div class="invalid-feedback">Por favor, insira um número válido.</div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-4">
                            <div class="form-check mt-4">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="form-check-input" id="edit_is_active" name="is_active" value="1">
                                <label class="form-check-label fw-semibold" for="edit_is_active">Livro Ativo</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark text-white rounded-pill shadow-sm">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Visualização -->
<div class="modal fade" id="viewBookModal" tabindex="-1" aria-labelledby="viewBookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3">
                <h5 class="modal-title fw-bold" id="viewBookModalLabel">📘 Detalhes do Livro</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light rounded-bottom-4 p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <tbody class="table-light">
                            <tr>
                                <th class="bg-secondary text-white">ISBN</th>
                                <td id="view_isbn"></td>
                                <th class="bg-secondary text-white">Título</th>
                                <td id="view_title"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">Autor</th>
                                <td id="view_author"></td>
                                <th class="bg-secondary text-white">Editora</th>
                                <td id="view_publisher"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">Ano</th>
                                <td id="view_publication_year"></td>
                                <th class="bg-secondary text-white">Edição</th>
                                <td id="view_edition"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">Gênero</th>
                                <td id="view_genre"></td>
                                <th class="bg-secondary text-white">Idioma</th>
                                <td id="view_language"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">Páginas</th>
                                <td id="view_pages"></td>
                                <th class="bg-secondary text-white">Total de Exemplares</th>
                                <td id="view_total_copies"></td>
                            </tr>
                            <tr>
                                <th class="bg-secondary text-white">Disponíveis</th>
                                <td id="view_available_copies"></td>
                                <th class="bg-secondary text-white">Status</th>
                                <td id="view_is_active"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary rounded-pill shadow-sm" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
