<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Langue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search') && $request->get('search') !== '') {
            $books = Book::with('categories')->where('is_valid', 1)->whereRaw('LOWER(title) like ?', ["%{$request->search}%"])->orderBy('id', 'desc')->paginate(15);
        } else {
            $books = Book::with('categories')->where('is_valid', 1)->orderBy('id', 'desc')->paginate(15);
        }

        return view('admin.books.index', compact('books'));
    }

    public function propositions()
    {

        $propositions = Book::where('is_valid', 0)->orderBy('id', 'DESC')->paginate(15);

        return view('admin.books.propositions', compact('propositions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langues = Langue::all();

        return view('admin.books.create', compact('langues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->createOrUpdate($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $langues = Langue::all();

        $book->categories = $book->convertCategoriesToString();

        return view('admin.books.edit', compact('book', 'langues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        return $this->createOrUpdate($request, $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/admin/book')->with('deleted', "Book deleted");
    }

    private function validateBook(Request $request, Book $book = null)
    {

        $linkRule = ['required', 'url'];

        if ($book !== null) {
            $linkRule[] = Rule::unique('books', 'link')->ignore($book->id);
        } else {
            $linkRule[] = Rule::unique('books', 'link');
        }

        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'link' => $linkRule,
            'categories' => 'required',
            'langue' => 'bail|required|integer|exists:langues,id'
        ]);

    }

    private function createOrUpdate(Request $request, Book $book = null)
    {

        $creation = $book === null;
        $this->validateBook($request, $book);

        DB::beginTransaction();
        try {

            if ($book == null) {
                $book = Book::create($this->paramsToSave());
            } else {
                $book->update($this->paramsToSave());
            }
            $book->saveCategories(request('categories'));

        } catch (\Exception $e) {
            DB::rollback();
            if ($creation) return response()->json(['data' => [$e->getMessage()]], 422);
        }

        DB::commit();

        return redirect('/admin/book/propositions')->with('edited', 'Book updated!');
    }

    private function paramsToSave()
    {

        return [
            'title' => request('title'),
            'author' => request('author'),
            'link' => request('link'),
            'description' => request('description'),
            'cover' => request('cover'),
            'langue_id' => request('langue'),
            'is_valid' => true
        ];

    }
}
