<?php

namespace App\Http\Controllers\Qaqatua;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
class ProjectController extends ApiController
{

    #[OA\Get(path: '/api/projects', operationId: 'getProjects',security:[['bearerAuth'=>[]]])]
    #[OA\Response(response: '200', description: 'The project list')]
    public function index(): JsonResponse
    {
        $projects = Project::all();

        return $this->sendResponse(ProjectResource::collection($projects), 'Projects retrieved successfully.');
    }

    #[OA\Post(path:"/api/projects",summary:"Create a project",security:[['bearerAuth'=>[]]])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "name",
                description: "The name of the project",
                required: ["true"],
                type: "string",
                example: "My Project"
            ),
            new OA\Property(
                property: "privkey",
                description: "The private key base64 encoded",
                required: ["true"],
                type: "string",
                example: ""
            ),
            new OA\Property(
                property: "pubkey",
                description: "The public key base64 encoded",
                required: ["true"],
                type: "string",
                example: ""
            ),
            new OA\Property(
                property: "fields",
                description: "A comma list of fields to enc/decp by default",
                required: ["false"],
                type: "string",
                example: "iban,account,user.pin"
            ),
        ],
        type: 'object'
    ))]
    #[OA\Response(response: '200', description: 'The project')]
    public function store(Request $request): JsonResponse
    {
        $current = Project::where('user_id', $request->user()->id)->count();
        if( $current > 0 ){
            return $this->sendError(403, "No more projects available");
        }

        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'privkey' => 'required',
            'pubkey' => 'required',
        ]);
        $input['user_id']=$request->user()->id;

        $project = Project::create($input);

        return $this->sendResponse(new ProjectResource($project), 'Project created successfully.');
    }

    #[OA\Put(path:"/api/projects/{id}",summary:"Update a project",security:[['bearerAuth'=>[]]])]
    #[OA\PathParameter(parameter: "id", name: "id")]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "name",
                description: "The name of the project",
                required: ["true"],
                type: "string",
                example: "My Project"
            ),
            new OA\Property(
                property: "privkey",
                description: "The private key base64 encoded",
                required: ["true"],
                type: "string",
                example: ""
            ),
            new OA\Property(
                property: "pubkey",
                description: "The public key base64 encoded",
                required: ["true"],
                type: "string",
                example: ""
            ),
            new OA\Property(
                property: "fields",
                description: "A comma list of fields to enc/decp by default",
                required: ["false"],
                type: "string",
                example: "iban,account,user.pin"
            ),
        ],
        type: 'object'
    ))]
    #[OA\Response(response: '200', description: 'The project')]
    public function update(Request $request, Project $project): JsonResponse
    {
        logger($project);
        $validated = $request->validate([
            'name'=>'required',
            'privkey'=>'sometimes',
            'pubkey'=>'sometimes',
            'fields'=>'sometimes',
        ]);

        $project->update($validated);
        return $this->sendResponse(new ProjectResource($project), 'Project updated successfully.');
    }
}
