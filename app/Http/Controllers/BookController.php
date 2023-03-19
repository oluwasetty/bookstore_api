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
     *      path="/books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      summary="Get list of books",
     *      description="Returns list of books",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *     )
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
     *      path="/books",
     *      operationId="postBook",
     *      tags={"Books"},
     *      summary="post a book",
     *      description="post a book",
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *       )
     *     )
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
     *      path="/books/{id}",
     *      operationId="getoneBook",
     *      tags={"Books"},
     *      summary="get a book",
     *      description="get a book",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *     )
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
     *      path="/books/{id}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      summary="update a book",
     *      description="update a book",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *     )
     */
    public function update(Request $request, $id)
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
     *      path="/books/{id}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      summary="delete a book",
     *      description="delete a book",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *     )
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
     *      path="/search-books",
     *      operationId="searchBooks",
     *      tags={"Books"},
     *      summary="Search for books",
     *      description="Returns list of books",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     *     )
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
