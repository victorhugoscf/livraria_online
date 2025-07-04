<?php

namespace App\Services;

use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator; // <--- ESTA LINHA É CRUCIAL PARA A PAGINAÇÃO

/**
 * Class BookService
 * @package App\Services
 */
class BookService
{
    /**
     * @var Book
     */
    protected $bookModel;

    /**
     * BookService constructor.
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->bookModel = $book;
    }

    /**
     * Get all books. (Este método retorna todos, mas não para a listagem paginada)
     *
     * @return Collection<int, Book>
     */
    public function getAllBooks(): Collection
    {
        return $this->bookModel->all();
    }

    /**
     * Get paginated books.
     *
     * @param int $perPage Quantidade de itens por página.
     * @return LengthAwarePaginator
     */
    public function getPaginatedBooks(int $perPage = 15): LengthAwarePaginator
    {
        // Retorna uma instância de Paginator, que permite a exibição dos links de paginação na view
        return $this->bookModel->paginate($perPage);
    }

    /**
     * Find a book by its ID.
     *
     * @param int $id
     * @return Book|null
     */
    public function findBookById(int $id): ?Book
    {
        return $this->bookModel->find($id);
    }

    /**
     * Create a new book.
     *
     * @param array<string, mixed> $data
     * @return Book
     * @throws Exception
     */
    public function createBook(array $data): Book
    {
        try {
            $book = $this->bookModel->create($data);

            return $book;
        } catch (Exception $e) 
        {
            // Você pode logar o erro aqui: Log::error($e->getMessage());
            throw new Exception("Erro ao criar o livro: " . $e->getMessage());
        }
    }

    /**
     * Update an existing book.
     *
     * @param Book $book
     * @param array<string, mixed> $data
     * @return bool
     * @throws Exception
     */
    public function updateBook(Book $book, array $data): bool
    {
        try {
            // Atualizar apenas os campos fornecidos em $data
            foreach ($data as $key => $value) 
            {
                if ($value !== null) 
                { // Ignorar valores nulos, exceto para is_active
                    $book->$key = $value;
                }
            }

            // Garantir que is_active seja tratado corretamente
            $book->is_active = isset($data['is_active']) ? (bool) $data['is_active'] : $book->is_active;

            // Salvar as alterações no banco de dados
            return $book->save();
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao atualizar livro no BookService: ' . $e->getMessage(), [
                'book_id' => $book->id,
                'data'    => $data
            ]);
            return false;
        }
    }

    /**
     * Delete a book.
     *
     * @param Book $book
     * @return bool|null
     * @throws Exception
     */
    public function deleteBook(Book $book): ?bool
    {
        try {
            return $book->delete();
        } catch (Exception $e) 
        {
            // Você pode logar o erro aqui: Log::error($e->getMessage());
            throw new Exception("Erro ao deletar o livro: " . $e->getMessage());
        }
    }

    public function searchBooks(?string $keyword = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->bookModel->query();

        if ($keyword) 
        {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('author', 'like', '%' . $keyword . '%')
                  ->orWhere('isbn', 'like', '%' . $keyword . '%')
                  ->orWhere('publisher', 'like', '%' . $keyword . '%')
                  ->orWhere('genre', 'like', '%' . $keyword . '%');
            });
        }

        return $query->paginate($perPage);
    }
}