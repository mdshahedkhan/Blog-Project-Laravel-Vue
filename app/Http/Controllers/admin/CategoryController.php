<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;
use Exception;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|unique:categories',
            'status' => 'required',
        ]);
        try {
            $exception = DB::transaction(function () use ($request) {
                Category::create([
                    'name'   => $request->name,
                    'slug'   => slugify($request->name),
                    'status' => $request->status,
                ]);
            });
            if (is_null($exception)) {
                return response()->json(['messages' => 'Yah! a category has been successfully created.'], 200);
            } else {
                throw new Exception();
            }
        } catch (Exception $exception) {
            return $exception;
        }
    }

    public function getCategory()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return response(['categories' => $categories], 200);
    }

    public function destroy($id)
    {
        $destroy = Category::destroy($id);
        if ($destroy) {
            return response()->json(['message' => 'Yah! a category has been successfully deleted.'], 200);
        }
        return response()->json(['message' => 'something is wrong']);
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return response()->json(['category' => $category]);
    }

    public function status($id)
    {
        $category = Category::findOrfail($id);
        if ($category->status == 'Active') {
            $category->status = 'inactive';
        } else {
            $category->status = 'active';
        }
        $category->update();

    }

    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|min:4|max:40|string|unique:categories,id,' . $request->id,
            'status' => 'required',
        ]);

        try {
            $category         = Category::findOrfail($request->id);
            $category->name   = $request->name;
            $category->slug   = slugify($request->name);
            $category->status = $request->status;
            $category->update();
            return response()->json(['success' => 'Yah! a category has been successfully updated.']);
        } catch (Exception $exception) {
            return $exception;
        }
    }


    public function deleteItems(Request $request)
    {
        foreach ($request->items as $item) {
            Category::destroy($item);
        }
        return response()->json(['success' => 'Yah! Category Successfully Deleted.']);
    }

    public function Inactive(Request $request)
    {
        foreach ($request->items as $item) {
            $Category         = Category::findOrfail($item);
            $Category->status = 'inactive';
            $Category->save();
        }
        return response()->json(['success' => 'Yah! Category status Successfully changed.']);

    }

    public function Active(Request $request)
    {

        foreach ($request->items as $item) {
            $Category         = Category::findOrfail($item);
            $Category->status = 'active';
            $Category->save();
        }
        return response()->json(['success' => 'Yah! Category status Successfully changed.']);
    }
}
