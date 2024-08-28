<?php

namespace Homeful\References\Http\Controllers;

use Homeful\References\Actions\CreateReferenceAction;
use Homeful\References\Models\Reference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateReferenceController extends Controller
{
    public function __construct(protected CreateReferenceAction $action) {}

    public function __invoke(Request $request): JsonResponse
    {
        $response = with($this->action->run($request->all()), function (Reference $reference) {
            return ['reference_code' => $reference->code];
        });

        return response()->json($response);
    }
}
