<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function create()
    {
        return view('books.create');
    }

    public function edit(int $id)
    {
        try {
            $book = $this->bookService->findBookById($id);

            if (!$book) 
            {
                return response()->json(['message' => 'Livro não encontrado.'], 404);
            }

            return response()->json($book);
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao buscar livro para edição: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['message' => 'Erro interno do servidor.', 'error' => $e->getMessage()], 500);
        }
    }

    public function index(Request $request)
    {
        $perPage       = $request->input('per_page', 15);
        $searchKeyword = $request->input('search');
        $books         = $this->bookService->searchBooks($searchKeyword, $perPage);

        return view("books.index", compact("books", "searchKeyword"));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'isbn'             => 'required|string|unique:books,isbn|max:255',
                'title'            => 'required|string|max:255',
                'author'           => 'required|string|max:255',
                'publisher'        => 'nullable|string|max:255',
                'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
                'edition'          => 'nullable|string|max:255',
                'genre'            => 'nullable|string|max:255',
                'language'         => 'sometimes|string|max:255',
                'pages'            => 'nullable|integer|min:1',
                'total_copies'     => 'nullable|integer|min:0',
                'available_copies' => 'nullable|integer|min:0|lte:total_copies',
                'is_active'        => 'nullable|boolean',
            ]);

            $book = $this->bookService->createBook($validatedData);
            return redirect()->route('books.index')
                ->with('success', 'Livro criado com sucesso.')
                ->with('book', $book);
        } catch (ValidationException $e) 
        {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Erro de validação.');
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao criar livro: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()
                ->with('error', 'Erro interno do servidor ao criar livro.');
        }
    }

    public function showJson(int $id)
    {
        try 
        {
            $book = $this->bookService->findBookById($id);

            if (!$book) 
            {
                return response()->json(['message' => 'Livro não encontrado.'], 404);
            }

            return response()->json($book);
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao buscar livro para visualização JSON: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['message' => 'Erro interno do servidor.', 'error' => $e->getMessage()], 500);
        }
    }

public function update(Request $request, int $id)
    {
        $book = $this->bookService->findBookById($id);

        if (!$book)
        {
            // Log de erro: Livro não encontrado para atualização
            \Log::warning('Tentativa de atualizar livro não encontrado.', ['book_id' => $id]);
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }

        try {
            // Log: Dados da requisição antes da validação
            \Log::info('Dados recebidos para atualização do livro (ID: ' . $id . ') antes da validação:', $request->all());

            $validatedData = $request->validate([
                'isbn'             => 'sometimes|string|unique:books,isbn,' . $book->id . '|max:255',
                'title'            => 'sometimes|string|max:255',
                'author'           => 'sometimes|string|max:255',
                'publisher'        => 'nullable|string|max:255',
                'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
                'edition'          => 'nullable|string|max:255',
                'genre'            => 'nullable|string|max:255',
                'language'         => 'sometimes|string|max:255',
                'pages'            => 'nullable|integer|min:1',
                'total_copies'     => 'nullable|integer|min:0',
                'available_copies' => 'nullable|integer|min:0|lte:total_copies',
                'is_active'        => 'nullable|boolean',
            ]);

            // Log: Dados validados que serão enviados para o serviço
            \Log::info('Dados validados para atualização do livro (ID: ' . $id . '):', $validatedData);

            $updated = $this->bookService->updateBook($book, $validatedData);

            if ($updated)
            {
                // Log de sucesso: Livro atualizado
                \Log::info('Livro atualizado com sucesso.', ['book_id' => $book->id, 'updated_data' => $validatedData]);
                return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso.');
            } else
            {
                // Log de aviso: Nenhuma alteração ou erro na atualização do serviço
                \Log::warning('Nenhuma alteração foi feita ou erro no serviço ao atualizar o livro.', ['book_id' => $book->id, 'data_sent' => $validatedData]);
                return redirect()->back()->with('error', 'Nenhuma alteração foi feita ou erro ao atualizar.')->withInput();
            }
        } catch (ValidationException $e)
        {
            // Log de erro: Falha de validação
            \Log::error('Erro de validação ao atualizar livro (ID: ' . $id . '):', ['errors' => $e->errors(), 'request_data' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Erro de validação. Verifique os campos.');
        } catch (\Exception $e)
        {
            // Log de erro crítico: Erro interno do servidor
            \Log::critical('Erro inesperado ao atualizar livro (ID: ' . $id . '): ' . $e->getMessage(), ['trace' => $e->getTraceAsString(), 'request_data' => $request->all()]);
            return redirect()->back()->with('error', 'Erro interno do servidor ao atualizar livro.')->withInput();
        }
    }
    public function search(Request $request)
    {
        try {
            $searchKeyword = $request->input('search');
            $books         = $this->bookService->searchBooks($searchKeyword, 15);
            
            return view('books.index', compact('books', 'searchKeyword'));
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao buscar livros: ' . $e->getMessage(), ['search' => $request->input('search')]);
            return response()->json(['message' => 'Erro interno do servidor.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(int $id)
    {
        $book = $this->bookService->findBookById($id);

        if (!$book) 
        {
            return response()->json(['message' => 'Livro não encontrado.'], 404);
        }

        try {
            $deleted = $this->bookService->deleteBook($book);

            if ($deleted) 
            {
                return response()->json(['message' => 'Livro deletado com sucesso.'], 200);
            } else {
                return response()->json(['message' => 'Erro ao deletar o livro.'], 400);
            }
        } catch (\Exception $e) 
        {
            \Log::error('Erro ao deletar livro: ' . $e->getMessage(), ['id' => $id]);
            return response()->json(['message' => 'Erro interno Garrado do servidor ao deletar livro.', 'error' => $e->getMessage()], 500);
        }
    }
}