<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoteService
{
    /**
     * Retrieve all active notes for a user.
     */
    public function getUserNotes(int $userId): Collection
    {
        return Note::forUser($userId)
            ->active()
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();
    }

    /**
     * Retrieve archived notes for a user.
     */
    public function getArchivedNotes(int $userId): Collection
    {
        return Note::archived()
            ->forUser($userId)
            ->latest()
            ->get();
    }

    /**
     * Retrieve a single note belonging to a user.
     */
    public function getUserNoteById(int $userId, int $noteId): Note
    {
        return Note::forUser($userId)
            ->findOrFail($noteId);
    }

    /**
     * Create a new note.
     */
    public function createNote(int $userId, array $data): Note
    {
        $data['user_id'] = $userId;

        return Note::create($data);
    }

    /**
     * Update an existing note.
     */
    public function updateNote(Note $note, array $data): Note
    {
        $note->update($data);

        return $note->refresh();
    }

    /**
     * Soft delete a note.
     */
    public function deleteNote(Note $note): void
    {
        $note->delete();
    }

    /**
     * Toggle pinned state.
     */
    public function togglePinned(Note $note): Note
    {
        $note->update([
            'is_pinned' => !$note->is_pinned
        ]);

        return $note->refresh();
    }

    /**
     * Archive a note.
     */
    public function archiveNote(Note $note): Note
    {
        $note->update([
            'is_archived' => true
        ]);

        return $note->refresh();
    }

    /**
     * Restore an archived note.
     */
    public function unarchiveNote(Note $note): Note
    {
        $note->update([
            'is_archived' => false
        ]);

        return $note->refresh();
    }
}