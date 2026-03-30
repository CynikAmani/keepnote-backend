<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Services\UserService;
use App\Http\Resources\LabelResource;
use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class LabelController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /*
    ---------------------------------
    | Get all labels for the authenticated user
    ---------------------------------
    */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Label::class);

        $labels = $this->userService->getAllLabels(auth()->id(), true);

        return LabelResource::collection($labels);
    }

    /*
    ---------------------------------
    | Get a single label by ID for the authenticated user
    | Load all notes/todos and counts
    ---------------------------------
    */
    public function show(int $id): LabelResource|JsonResponse
    {
        $label = $this->userService->getLabelById(auth()->id(), $id);

        if (!$label) {
            return response()->json(['message' => 'Label not found.'], 404);
        }

        $this->authorize('view', $label);

        return new LabelResource($label);
    }

    /*
    ---------------------------------
    | Create a new label for the authenticated user
    ---------------------------------
    */
    public function store(StoreLabelRequest $request): LabelResource
    {
        $this->authorize('create', Label::class);

        $label = $this->userService->createLabel(
            auth()->id(),
            $request->validated()['name']
        );

        return new LabelResource($label);
    }

    /*
    ---------------------------------
    | Update an existing label
    ---------------------------------
    */
    public function update(UpdateLabelRequest $request, Label $label): LabelResource
    {
        $this->authorize('update', $label);

        $updatedLabel = $this->userService->updateLabel(
            $label,
            $request->validated()['name']
        );

        return new LabelResource($updatedLabel);
    }

    /*
    ---------------------------------
    | Delete a label
    ---------------------------------
    */
    public function destroy(Label $label): JsonResponse
    {
        $this->authorize('delete', $label);

        $this->userService->deleteLabel($label);

        return response()->json([
            'message' => 'Label deleted successfully.'
        ]);
    }
}