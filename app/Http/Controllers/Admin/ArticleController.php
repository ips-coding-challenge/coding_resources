<?php

namespace App\Http\Controllers\Admin;

use App\Models\Langue;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('search') && $request->get('search') !== '') {
            $articles = Article::with('categories')->where('is_valid', 1)->whereRaw('LOWER(title) like ?', ["%{$request->search}%"])->orderBy('id', 'desc')->paginate(15);
        } else {
            $articles = Article::with('categories')->where('is_valid', 1)->orderBy('id', 'desc')->paginate(15);
        }

        return view('admin.articles.index', compact('articles'));
    }

    public function propositions()
    {

        $propositions = Article::where('is_valid', 0)->orderBy('id', 'DESC')->paginate(15);

        return view('admin.articles.propositions', compact('propositions'));

    }

    public function create(Request $request, Article $article)
    {

        $langues = Langue::all();

        return view('admin.articles.create', compact('langues'));
    }

    public function edit(Request $request, Article $article)
    {

        $langues = Langue::all();

        $article->categories = $article->convertCategoriesToString();

        return view('admin.articles.edit', compact('article', 'langues'));
    }

    public function store(Request $request)
    {

        $this->validateArticle($request);

        return $this->createOrUpdate($request);

    }

    public function update(Request $request, Article $article)
    {

        return $this->createOrUpdate($request, $article);
    }

    public function destroy(Article $article)
    {

        $article->delete();

        return redirect('/admin/article/propositions')->with('deleted', "Article deleted");
    }

    /** Create or update an article
     * @param Request $request
     * @param Article $article
     * @return
     */
    private function createOrUpdate(Request $request, Article $article = null)
    {


        // dd($request->all());
        $this->validateArticle($request, $article);

        DB::beginTransaction();
        try {

            if ($article == null) {
                $article = Article::create($this->paramsToSave());
            } else {
                $article->update($this->paramsToSave());
            }

            $article->saveCategories(request('categories'));

        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
        }

        DB::commit();

        return redirect('/admin/article/propositions')->with('edited', 'Article updated!');
    }

    /** Validation Rule for Article */
    private function validateArticle(Request $request, Article $article)
    {

        $linkRule = ['required', 'url'];

        if ($article !== null) {
            $linkRule[] = Rule::unique('articles', 'url')->ignore($article->id);
        } else {
            $linkRule[] = Rule::unique('articles', 'url');
        }

        $this->validate($request, [
            'title' => 'required',
            'url' => $linkRule,
            'categories' => 'required',
            'langue' => 'bail|required|integer|exists:langues,id'
        ]);
    }

    /** Params to save when create or update */
    private function paramsToSave()
    {
        return [
            'title' => request('title'),
            'url' => request('url'),
            'langue_id' => request('langue'),
            'is_valid' => true
        ];
    }
}
