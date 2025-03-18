<?php

namespace App\Http\Controllers\Qaqatua;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpseclib3\Crypt\PublicKeyLoader;
use OpenApi\Attributes as OA;

class EchoController extends Controller
{

    public function __construct()
    {
    }

    private function privateKey(Project $project){
        $strPrivkey = $project->privkey;
        $privKey = PublicKeyLoader::loadPrivateKey($strPrivkey);
        return $privKey;
    }

    private function publicKey(Project $project){
        $strPublicKey = $project->pubkey;
        $pubKey = PublicKeyLoader::loadPublicKey($strPublicKey);
        return $pubKey;
    }

    private function fields(User $user){
        $project = Project::where('user_id', $user->id)->first(); //$user->projects()[0];
        return explode(",",''.$project->fields);
    }

    #[OA\Post(path:"/api/encrypt",summary:"Encrypt a payload",security:[['bearerAuth'=>[]]])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "example",
                description: "",
                required: ["false"],
                type: "string",
                example: "My Project"
            )
        ],
        type: 'object'
    ))]
    #[OA\Response(response: '200', description: 'The project')]
    public function encrypt(Request $request) : JsonResponse
    {
        try {
            $project = Project::where('user_id', $request->user()->id)->first(); //$user->projects()[0];
            $pubKey = $this->publicKey($project);

            $input = $request->all();

            $fields = $this->fields($request->user());
            foreach ($fields as $field){
                $founded = data_get($input, $field);
                if( $founded ) {
                    $encode = $founded;
                    openssl_public_encrypt($encode, $encrypted, $pubKey);
                    data_set($input, $field, base64_encode($encrypted));
                }
            }

            return response()->json($input, 200);
        }catch (\Exception $e){
            return response()->json(["error"=>$e->getMessage()], 500);
        }
    }


    #[OA\Post(path:"/api/decrypt",summary:"Decrypt a payload",security:[['bearerAuth'=>[]]])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "example",
                description: "",
                required: ["false"],
                type: "string",
                example: "DWmP95kLSEQx/+wxkbWidpQjuPk6Wqc2N8+BT4D0fGJuvg3lu36The+mdz4t8bwB1Fjo+ARv4x1gaTLn+cs0Ap8u3HLwReAKQk3xHcONgJPUE4QJY6d1XF0rGptBr5tueGjRu3ZefmcKYLmSmN2sWUhQnDghA871tIEN2VAIiXiCQUkHL4Rk94FLU1LaF/whaqC0BI+QNMoc7sagIdoOBIjCXApKblY40sib8HqOGuTkjwhDtHPGWMWMxgQmdoawnpH8DbthlVyxSu7Jkqtb6iAJgsYXQZ3ysFSK5k3hnH5ddbFMrpeteDtrKXg9aFZi2fg/oO9uaxKFBm909ceImw=="
            )
        ],
        type: 'object'
    ))]
    #[OA\Response(response: '200', description: 'The project')]
    public function decrypt(Request $request) : JsonResponse
    {
        try{
            $project = Project::where('user_id', $request->user()->id)->first(); //$user->projects()[0];

            $privKey = $this->privateKey($project);

            $input = $request->all();

            $fields = $this->fields($request->user());
            foreach ($fields as $field){
                $founded = data_get($input, $field);
                if( $founded ) {
                    $decoded = base64_decode($founded);
                    openssl_private_decrypt($decoded, $decrypted, $privKey);
                    data_set($input, $field, $decrypted);
                }
            }
            return response()->json($input, 201);
        }catch (\Exception $e){
            return response()->json(["error"=>$e->getMessage()], 500);
        }
    }

}
