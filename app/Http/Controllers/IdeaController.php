<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Http\Requests\IdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $status = $request->status;

        if (! in_array($status, IdeaStatus::values())) {
            $status = null;
        }

        $ideas = $user
            ->ideas()
            ->when($status, fn ($query, $status) => $query->where('status', $status))
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request, CreateIdea $action)
    {
        $action->handle($request->safe()->all());

        return to_route('ideas.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('workWith', $idea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdeaRequest $request, Idea $idea, UpdateIdea $action)
    {
        Gate::authorize('workWith', $idea);

        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return redirect('/ideas');
    }
}
