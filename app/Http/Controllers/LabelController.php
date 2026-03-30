<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Services\LabelService;
use App\Http\Resources\LabelResource;
use App\Http\Requests\Label\StoreLabelRequest;
use App\Http\Requests\Label\UpdateLabelRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class LabelController extends Controller
{
    protected LabelService $labelService;

    public function __construct(LabelService $labelService)
    {
        $this->labelService = $labelService;
    }

    /*
    ---------------------------------
    | Get all labels for the authenticated user
    ---------------------------------
    */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Label::class);

        $labels = $this->labelService->getAllLabels(auth()->id(), true);

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
        $label = $this->labelService->getLabelById(auth()->id(), $id);

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

        $label = $this->labelService->createLabel(
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

        $updatedLabel = $this->labelService->updateLabel(
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

        $this->labelService->deleteLabel($label);

        return response()->json([
            'message' => 'Label deleted successfully.'
        ]);
    }
}