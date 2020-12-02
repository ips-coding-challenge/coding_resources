<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        if ($request->has('search') && $request->get('search') !== '') {
            $categories = Category::whereRaw('LOWER(name) like ?', ["%{$request->search}%"])->orderBy('id', 'desc')->paginate(15);
        } else {
            $categories = Category::orderBy('id', 'desc')->paginate(15);
        }


        return view('admin.categories.index', compact('categories'));

    }

    public function update(Request $request, Category $category)
    {

        if (!$request->ajax()) {
            return response()->json(['What are you trying to do ?'], 403);
        }

        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('categories')->ignore($category->id)
            ]
        ]);

        $category->update([
            'name' => request('name')
        ]);

        return response()->json($category, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        $category->delete();

        return redirect('/admin/category')->with('deleted', "Category deleted");
    }
}
