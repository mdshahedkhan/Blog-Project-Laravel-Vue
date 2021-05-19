<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $Posts = Post::with('user', 'category')->orderBy('id', 'DESC')->get();
        return response()->json(['posts' => $Posts], 200);
    }

    // Advance Filtering
    public function Filter_Post(Request $request)
    {
        $Post = '';
        if ($request->orderby) {
            if ($request->orderby == 'ascending') {
                $Post = Post::with('user', 'category')->orderBy('id', 'ASC')->get();
            } else {
                $Post = Post::with('user', 'category')->orderBy('id', 'DESC')->get();
            }
        } elseif ($request->search) {
            $Searching = str_replace('%', ' ', $request->search);
            $Post      = Post::with('category', 'user')->where('title', 'like', '%' . $Searching . '%')->get();
        } else if ($request->category) {
            if ($request->category == 'All-category') {
                $Post = Post::with('user', 'category')->get();
            } else {
                $Post = Post::with('user', 'category')->whereHas('category', function ($query) use ($request) {
                    $query->where('id', $request->category);
                })->get();
            }
        }
        return response()->json(['post' => $Post], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Destroy(Request $request)
    {
        if ($request->items) {
            $i = 0;
            foreach ($request->items as $item) {
                Post::destroy($item);
                $i++;
            }
            return response()->json(['success' => 'Yah! ' . $i . ' post has been successfully deleted.']);
        }
    }

    public function Status(Request $request)
    {
        $i = 0;
        foreach ($request->items as $item) {
            $Post         = Post::find($item)->first();
            $Post->status = $request->type;
            $Post->save();
            $i++;
        }
        return response()->json(['success' => 'Yah! ' . $i . ' post has been successfully ' . $request->type . '.']);
    }

}
