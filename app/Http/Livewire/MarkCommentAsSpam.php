<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class MarkCommentAsSpam extends Component
{

    public Comment $comment;

    protected $listeners = ['setMarkAsSpamComment'];


    public function setMarkAsSpamComment($commentId){
        $this->comment = Comment::findOrFail($commentId);

        $this->emit('markAsSpamCommentWasSet');

    }

    public function markAsSpam(){
        if(auth()->guest()){
            abort(403);
        }

        $this->comment->spam_reports++;
        $this->comment->save();

        // $this->comment = Comment::make();

        $this->emit('commentWasMarkedAsSpam','Comment was marked as spam!');

    }

    public function render()
    {
        return view('livewire.mark-comment-as-spam');
    }
}
