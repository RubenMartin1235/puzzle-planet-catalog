<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Planet;
use App\Models\Comment;

class CommentController extends Controller
{
    protected static $validateRules = [
        'message'=>'required|string|max:255',
    ];

    public function createOnPlanet(Request $request, Planet $planet)
    {
        return view('comments.create',[
            'pl' => $planet,
        ]);
    }

    protected function store(Request $request, $commentable) {
        $validated = $request->validate(self::$validateRules);
        $comment = Comment::factory()->make($validated);
        $comment->commentable()->associate($commentable);
        $comment->user()->associate(Auth::user());
        $comment->save();
    }
    public function storeOnPlanet(Request $request, Planet $planet)
    {
        $this->store($request, $planet);
        return redirect(route('planets.show', $planet));
    }


    public function edit(Request $request, Comment $comment)
    {
        if (!$this->isAllowedToModify($request, $comment)) {
            return redirect(url()->previous());
        }
        $commentable = $comment->commentable;
        $data = [
            'cm' => $comment,
            'commentable' => $commentable
        ];
        switch ($commentable::class) {
            case Planet::class:
                $data['pl'] = $commentable;
                $data['breadcrumbs_lvl1'] = "Planets";
                break;

            default:
                $data['card'] = $commentable;
                $data['breadcrumbs_lvl1'] = "Cards";
                break;
        }
        $data['commentable_route'] = route(strtolower($data['breadcrumbs_lvl1']).'.show', $commentable);
        return view('comments.edit',$data);
    }

    public function update(Request $request, Comment $comment)
    {
        if (!$request->commentable_route) {
            return redirect(route('planets.index'));
        }
        if (!$this->isAllowedToModify($request, $comment)) {
            return redirect($request->commentable_route);
        }
        $validated = $request->validate(self::$validateRules);
        $comment->fill($validated);
        $comment->save();
        return redirect($request->commentable_route);
    }

    protected function isAllowedToModify(Request $request, Comment $comment) {
        return (Auth::user()->hasAnyRole(['admin']) || $comment->user->id == Auth::user()->id);
    }

    public function destroy(Request $request, $comment = null)
    {
        $cm = $comment ?? Comment::find($request->comment_id);
        if ($cm && $this->isAllowedToModify($request, $cm)) {
            $cm->delete();
        }
        return redirect(url()->previous());
    }
}
