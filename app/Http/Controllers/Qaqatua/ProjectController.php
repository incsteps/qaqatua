<?php

namespace App\Http\Controllers\Qaqatua;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\RSA\PrivateKey;

class ProjectController extends ApiController
{

    #[OA\Get(path: '/api/projects', operationId: 'getProjects',security:[['bearerAuth'=>[]]])]
    #[OA\Response(response: '200', description: 'The project list')]
    public function index(Request $request): JsonResponse
    {
        $projects = Project::where('user_id', $request->user()->id)->get();

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
    public function store(Request $request)
    {
        $isInnertia = $request->header('X-Inertia');

        $current = Project::where('user_id', $request->user()->id)->count();
        if( $current > 3 ){
            return $isInnertia ?
                back()->withErrors(["name"=>"No more projects available"]) :
                $this->sendError(403, "No more projects available");
        }

        $validated = $request->validate([
            'name' => 'required',
            'fields' => 'sometimes',
            'privkey' => 'sometimes',
            'pubkey' => 'sometimes',
        ]);
        $validated['user_id']=$request->user()->id;

        if( $validated['privkey'] == null || $validated['pubkey']==null){
            $private_key = RSA::createKey();
            $public_key = $private_key->getPublicKey();
            $validated['privkey'] = $private_key->toString("PKCS1");
            $validated['pubkey'] = $public_key->toString("PKCS1");
        }

        $project = Project::create($validated);

        if( $isInnertia){
            return back();
        }
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
    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        $validated = $request->validate([
            'name'=>'sometimes',
            'privkey'=>'sometimes',
            'pubkey'=>'sometimes',
            'fields'=>'sometimes',
        ]);
        $project->update($validated);

        $isInnertia = $request->header('X-Inertia');
        if( $isInnertia){
            return back();
        }

        return $this->sendResponse(new ProjectResource($project), 'Project updated successfully.');
    }

    #[OA\Delete(path:"/api/projects/{id}",summary:"delete a project",security:[['bearerAuth'=>[]]])]
    #[OA\PathParameter(parameter: "id", name: "id")]
    #[OA\Response(response: '200', description: 'The project has been deleted')]
    public function delete(Request $request, $id)
    {
        $project = Project::find($id);
        $project->delete();

        $isInnertia = $request->header('X-Inertia');
        if( $isInnertia){
            return back();
        }

        return $this->sendResponse(new ProjectResource($project), 'Project deleted successfully.');
    }
}
