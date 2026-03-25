<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Services\NoteService;
use App\Http\Resources\NoteResource;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
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
        $notes = $this->noteService->getUserNotes(auth()->id());

        return NoteResource::collection($notes);
    }

    /**
     * Retrieve a single note.
     */
    public function show(Note $note): NoteResource
    {
        return new NoteResource($note);
    }

    /**
     * Create a new note.
     */
    public function store(StoreNoteRequest $request): NoteResource
    {
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
        $notes = $this->noteService->getArchivedNotes(auth()->id());

        return NoteResource::collection($notes);
    }

    /**
     * Toggle pinned state.
     */
    public function togglePin(Note $note): NoteResource
    {
        $note = $this->noteService->togglePinned($note);

        return new NoteResource($note);
    }

    /**
     * Archive a note.
     */
    public function archive(Note $note): NoteResource
    {
        $note = $this->noteService->archiveNote($note);

        return new NoteResource($note);
    }

    /**
     * Restore an archived note.
     */
    public function unarchive(Note $note): NoteResource
    {
        $note = $this->noteService->unarchiveNote($note);

        return new NoteResource($note);
    }
}