<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Services\CommentTree;
use Illuminate\Support\Facades\Schema;

class CommentController extends Controller
{
    /**
   * Create Comment
   *
   * @param Request $request
   * @param Comment $comment
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(Request $request, Comment $comment)
  {
    $columns = Schema::getColumnListing($comment->getTable());
    $this->validate($request, [
      'comment' => 'required',
      'parent_id' => 'sometimes|uuid|nullable',
    ]);
    return $this->created($comment->create($request->only($columns)));
  }

    /**
   * List Comment
   *
   * @param Request $request
   * @param Comment $comment
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function collection(CommentTree $comment)
  {
    return response()->json($comment->buildTree());
  }
}
