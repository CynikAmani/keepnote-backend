<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Services\NoteService;
use App\Http\Resources\NoteResource;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NoteController extends Controller
{
    protected NoteService $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    /**
     * List active notes for the authenticated user.
     */
    public function index(): ResourceCollection
    {
        $this->authorize('viewAny', Note::class);

        $notes = $this->noteService->getUserNotes(auth()->id());

        return NoteResource::collection($notes);
    }

    /**
     * Retrieve a single note.
     */
    public function show(Note $note): NoteResource
    {
        $this->authorize('view', $note);

        return new NoteResource($note);
    }

    /**
     * Create a new note.
     */
    public function store(StoreNoteRequest $request): NoteResource
    {
        $this->authorize('create', Note::class);

        $note = $this->noteService->createNote(
            auth()->id(),
            $request->validated()
        );

        return new NoteResource($note);
    }

    /**
     * Update an existing note.
     */
    public function update(UpdateNoteRequest $request, Note $note): NoteResource
    {
        $this->authorize('update', $note);

        $note = $this->noteService->updateNote(
            $note,
            $request->validated()
        );

        return new NoteResource($note);
    }

    /**
     * Delete a note.
     */
    public function destroy(Note $note): JsonResponse
    {
        $this->authorize('delete', $note);

        $this->noteService->deleteNote($note);

        return response()->json([
            'message' => 'Note deleted successfully'
        ]);
    }

    /**
     * Retrieve archived notes.
     */
    public function archived(): ResourceCollection
    {
        $this->authorize('viewAny', Note::class);

        $notes = $this->noteService->getArchivedNotes(auth()->id());

        return NoteResource::collection($notes);
    }

    /**
     * Toggle pinned state.
     */
    public function togglePin(Note $note): NoteResource
    {
        $this->authorize('togglePin', $note);

        $note = $this->noteService->togglePinned($note);

        return new NoteResource($note);
    }

    /**
     * Archive a note.
     */
    public function archive(Note $note): NoteResource
    {
        $this->authorize('archive', $note);

        $note = $this->noteService->archiveNote($note);

        return new NoteResource($note);
    }

    /**
     * Restore an archived note.
     */
    public function unarchive(Note $note): NoteResource
    {
        $this->authorize('unarchive', $note);

        $note = $this->noteService->unarchiveNote($note);

        return new NoteResource($note);
    }
}