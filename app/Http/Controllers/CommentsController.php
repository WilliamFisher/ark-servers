<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Server;
use App\Comment;
use Auth;

class CommentsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function store(Server $server)
    {
      $this->validate(request(), ['body' => 'required|min:2']);

      $comment = new Comment;
      $comment->user_id = Auth::user()->id;
      $comment->server_id = $server->id;
      $comment->body = request('body');

      $comment->save();

      return back()->with('status', 'Successfully added a comment.');
    }
}
