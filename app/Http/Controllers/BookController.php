<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\Resource as BookResource;
use App\Http\Requests\BookRequest;
use App\Books\BooksRepository;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/books",
     *     summary="Get books",
     *     description="Returns list of books",
     *     operationId="getBooks",
     *     tags={"Book"},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            // returns all books
            $books = Book::orderBy('title', 'ASC')->paginate($request->per_page ?? 25);
            return BookResource::collection($books)->additional(['status' => true, 'message' => 'List Successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/books",
     *     tags={"Book"},
     *     operationId="addBook",
     *     summary="Add a new book to the store",
     *     description="",
     *     @OA\RequestBody(
     *         description="Book object that needs to be added to the store",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book"),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(ref="#/components/schemas/Book")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     ),
     *     security={{"apiAuth": {"write:books", "read:books"}}}
     * )
     */
    public function store(BookRequest $request)
    {
        try {
            // creates books
            $book = Book::create(array_merge($request->all(), ['image' => 'http://placeimg.com/480/640/any']));
            return (new BookResource($book))->additional(['status' => true, 'message' => 'Saved Successfully'])->response()->setStatusCode(201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/books/{bookId}",
     *     summary="Find book by ID",
     *     description="Returns a single book",
     *     operationId="getBookById",
     *     tags={"Book"},
     *     @OA\Parameter(
     *         description="ID of book to return",
     *         in="path",
     *         name="bookId",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="c85c9c7c-dbb8-4d62-b1a9-f5585ee208d6"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     */
    public function show($id)
    {
        try {
            // show one book
            $book = Book::find($id);
            if ($book) {
                return (new BookResource($book))->additional(['status' => true, 'message' => 'Retrieved Successfully'])->response()->setStatusCode(200);
            } else {
                return response()->json(['status' => false, 'message' => 'resource could not be found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/books/{bookId}",
     *     tags={"Book"},
     *     operationId="updateBook",
     *     summary="Update an existing book.",
     *     description="",
     *     @OA\Parameter(
     *         description="ID of book to update",
     *         in="path",
     *         name="bookId",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="c85c9c7c-dbb8-4d62-b1a9-f5585ee208d6"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Book object that needs to be added to the store",
     *         @OA\JsonContent(ref="#/components/schemas/Book"),
     *         @OA\MediaType(
     *             mediaType="application/xml",
     *             @OA\Schema(ref="#/components/schemas/Book"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     ),
     *     security={{"apiAuth": {"write:books", "read:books"}}}
     * )
     */
    public function update(BookRequest $request, $id)
    {
        try {
            // update books
            $book = Book::find($id);
            if ($book) {
                $book->update(array_merge($request->all()));
                return (new BookResource($book))->additional(['status' => true, 'message' => 'Updated Successfully'])->response()->setStatusCode(200);
            } else {
                return response()->json(['status' => false, 'message' => 'resource could not be found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/books/{bookId}",
     *     summary="Deletes a book",
     *     description="",
     *     operationId="deleteBook",
     *     tags={"Book"},
     *     @OA\Parameter(
     *         description="Book id to delete",
     *         in="path",
     *         name="bookId",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="c85c9c7c-dbb8-4d62-b1a9-f5585ee208d6"
     *         )
     *     ),
     *     @OA\Header(
     *         header="api_key",
     *         description="Api key header",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     ),
     *     security={{"apiAuth": {"write:books", "read:books"}}}
     * )
     */
    public function destroy($id)
    {
        try {
            // delete book
            $book = Book::find($id);
            if ($book) {
                $book->delete();
                return response()->json(['status' => true, 'message' => 'Deleted Successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'resource could not be found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/search-books",
     *     summary="Search for books.",
     *     tags={"Book"},
     *      description="Returns list of related books",
     *     operationId="searchBooks",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Search query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Method Not Allowed",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *     )
     * )
     */
    public function search(Request $request, BooksRepository $book)
    {
        try {
            // // returns search results books
            $books = $request->has('q')
                ? $book->search($request->q, $request->per_page ?? 25)
                : Book::orderBy('title', 'ASC')->paginate($request->per_page ?? 25);
            return BookResource::collection($books)->additional(['status' => true, 'message' => 'Search Completed'])->response()->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
