<?php

namespace App\Http\Controllers;

use App\Events\NewVoteOnThreadEvent;
use App\Models\Thread;

class VoteController extends Controller
{
    /**
     * VoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function upVote($thread_id)
    {
        $previousVote = auth()->user()->votes->where('thread_id', $thread_id)->first();

        // check if there is a vote by this user
        if ($previousVote) {
            // if type == UP_VOTE -> remove this
            if ($previousVote->type == 'UP_VOTE') $previousVote->delete();

            // if type == DOWN_VOTE -> change type = UP_VOTE
            if ($previousVote->type == 'DOWN_VOTE') $previousVote->update(['type' => 'UP_VOTE']);

        } else {
            // When this is absolutely new vote
            auth()->user()->votes()->create([
                'thread_id' => $thread_id,
                'type' => 'UP_VOTE'
            ]);
        }

        $count = Thread::find($thread_id)->scores;

        NewVoteOnThreadEvent::dispatch($count, $thread_id);


        return response()->json([
            'message' => 'Vote created',
            'currentScores' => $count
        ], 201);
    }

    public function downVote($thread_id)
    {
        $previousVote = auth()->user()->votes->where('thread_id', $thread_id)->first();

        // check if there is a vote by this user
        if ($previousVote) {
            // if type == DOWN_VOTE -> remove this
            if ($previousVote->type == 'DOWN_VOTE') $previousVote->delete();

            // if type == UP_VOTE -> change type = DOWN_VOTE
            if ($previousVote->type == 'UP_VOTE') $previousVote->update(['type' => 'DOWN_VOTE']);
        } else {
            // When this is absolutely new vote
            auth()->user()->votes()->create([
                'thread_id' => $thread_id,
                'type' => 'DOWN_VOTE'
            ]);
        }

        $count = Thread::find($thread_id)->scores;
        NewVoteOnThreadEvent::dispatch($count, $thread_id);

        return response()->json([
            'message' => 'Vote created',
            'currentScores' => $count
        ], 201);
    }
}
