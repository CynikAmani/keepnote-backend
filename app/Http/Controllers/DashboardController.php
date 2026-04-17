<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\TodoGroup;
use App\Http\Resources\NoteResource;
use App\Http\Resources\TodoGroupResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get recent items for the dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $limit = $request->query('limit', 3);

        $recentNotes = Note::forUser($user->id)
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $recentTodoGroups = TodoGroup::with('todoItems')
            ->forUser($user->id)
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $stats = [
            'notes' => [
                'active' => Note::forUser($user->id)->active()->count(),
                'archived' => Note::forUser($user->id)->archived()->count(),
            ],
            'todo_groups' => [
                'active' => TodoGroup::forUser($user->id)->active()->count(),
                'archived' => TodoGroup::forUser($user->id)->archived()->count(),
            ]
        ];

        return response()->json([
            'recent_notes' => NoteResource::collection($recentNotes),
            'recent_todo_groups' => TodoGroupResource::collection($recentTodoGroups),
            'stats' => $stats,
        ]);
    }
}
