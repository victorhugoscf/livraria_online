<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
  /**
   * @var BookService
   */
	protected $bookService;

  /**
   * BookController constructor.
   * @param BookService $bookService
   */
	public function __construct(BookService $bookService)
	{
		$this->bookService = $bookService;
	}

	public function index(Request $request)
	{
		$perPage = $request->input('per_page', 15); // Itens por página
		$searchKeyword = $request->input('search'); // Termo de busca

		// Usa o novo método searchBooks que já inclui a paginação
		$books = $this->bookService->searchBooks($searchKeyword, $perPage);
		return view("books.index", compact("books", "searchKeyword"));
	}

  /**
   * Store a newly created book in storage.
   *
   * @param Request $request
   * @return JsonResponse
   */
	public function store(Request $request): JsonResponse
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
				'language'         => 'sometimes|string|max:255|default:Português',
				'pages'            => 'nullable|integer|min:1',
				'total_copies'     => 'nullable|integer|min:0',
				'available_copies' => 'nullable|integer|min:0|lte:total_copies',
				'is_active'        => 'nullable|boolean',
			]);

			$book = $this->bookService->createBook($validatedData);
			return response()->json($book, 201); // 201 Created
		} catch (ValidationException $e) {
			return response()->json(['errors' => $e->errors()], 422); // 422 Unprocessable Entity
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro interno do servidor ao criar livro.', 'error' => $e->getMessage()], 500);
		}
	}

	/**
	 * Display the specified book.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function show(int $id): JsonResponse
	{
		$book = $this->bookService->findBookById($id);

		if (!$book) 
		{
			return response()->json(['message' => 'Livro não encontrado.'], 404);
		}

		return response()->json($book);
	}

	/**
	 * Update the specified book in storage.
	 *
	 * @param Request $request
	 * @param int $id
	 * @return JsonResponse
	 */
	public function update(Request $request, int $id): JsonResponse
	{
		$book = $this->bookService->findBookById($id);

		if (!$book) 
		{
			return response()->json(['message' => 'Livro não encontrado.'], 404);
		}

		try {
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

				$updated = $this->bookService->updateBook($book, $validatedData);

				if ($updated) 
				{
					return response()->json(['message' => 'Livro atualizado com sucesso.', 'book' => $book->fresh()]);
				} 
				else 
				{
					return response()->json(['message' => 'Nenhuma alteração foi feita ou erro ao atualizar.'], 400);
				}
			} catch (ValidationException $e) {
				return response()->json(['errors' => $e->errors()], 422);
			} catch (\Exception $e) {
				return response()->json(['message' => 'Erro interno do servidor ao atualizar livro.', 'error' => $e->getMessage()], 500);
			}
	}

	/**
	 * Remove the specified book from storage.
	 *
	 * @param int $id
	 * @return JsonResponse
	 */
	public function destroy(int $id): JsonResponse
	{
			$book = $this->bookService->findBookById($id);

			if (!$book) {
					return response()->json(['message' => 'Livro não encontrado.'], 404);
			}

			try {
					$deleted = $this->bookService->deleteBook($book);

					if ($deleted) {
							return response()->json(['message' => 'Livro deletado com sucesso.'], 200);
					} else {
							return response()->json(['message' => 'Erro ao deletar o livro.'], 500);
					}
			} catch (\Exception $e) {
					return response()->json(['message' => 'Erro interno do servidor ao deletar livro.', 'error' => $e->getMessage()], 500);
			}
	}
}

