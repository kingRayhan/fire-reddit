<?php

namespace App\Http\Controllers;

use App\Events\NewCommentCreatedEvent;
use App\Events\NewThreadCreatedEvent;
use App\Http\Requests\Thread\CreateThread;
use App\Http\Requests\Thread\CreateThreadCommentRequest;
use App\Http\Requests\Thread\CreateThreadRequest;
use App\Http\Resources\Thread\ThreadIndexResource;
use App\Http\Resources\Thread\ThreadSingleResource;
use App\Models\Thread;
use App\Models\User;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])->except(['index', 'show', 'userThreads']);
    }

    /**
     * Get all threads
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $thread = Thread::parents()->with('user')->with('votes')->withCount('comments')->latest()->paginate(env('THREADS_PER_PAGE'));
        return ThreadIndexResource::collection($thread);
    }

    public function userThreads(User $username)
    {
        return ThreadIndexResource::collection($username->threads()->paginate(env('THREADS_PER_PAGE')));
    }

    /**
     * Single thread
     * @param Thread $thread
     * @return ThreadSingleResource
     */
    public function show(Thread $thread)
    {
        return new ThreadSingleResource($thread);
    }

    /**
     * Create new thread
     * @param CreateThreadRequest $request
     * @return ThreadIndexResource
     */
    public function store(CreateThreadRequest $request)
    {
        $thread = auth()->user()->threads()->create($request->all());
        event(new NewThreadCreatedEvent($thread));
        return new ThreadIndexResource($thread);
    }


    public function storeComment(CreateThreadCommentRequest $request, Thread $thread)
    {
        $comment = new Thread($request->all());
        $comment->user()->associate(auth()->user());
        $newComment = $thread->comments()->save($comment);

        NewCommentCreatedEvent::dispatch($newComment);


        return new ThreadSingleResource($newComment);
    }


    public function destroy(Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();
        return response(['message' => 'Deleted successfully'], 204);
    }
}
