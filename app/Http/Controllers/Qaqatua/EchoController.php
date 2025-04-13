<?php

namespace App\Http\Controllers\Qaqatua;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;
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

    private function fields(Project $project){
        return explode(",",''.$project->fields);
    }

    private function findProject(Request $request) : Project{
        try {
            $projects = Project::where('user_id', $request->user()->id)->get();
            if($projects->isEmpty()){
                return new Project();
            }
            $projectName = $request->query('project') ?: "";
            foreach ($projects as $p) {
                if ($p->name == $projectName) {
                    return $p;
                }
            }
            return $projects[0];
        }catch (\Exception $e){
            return new Project();
        }
    }

    private function requestFields(Request $request, array $fields){
        if( $request->has('fields') ) {
            $paramfields = explode(",",$request->query('fields'));
            if( $request->has('op') && $request->query('op') =='merge') {
                return array_merge($fields, $paramfields);
            }else {
                return $paramfields;
            }
        }
        return $fields;
    }

    #[OA\Post(path:"/api/encrypt",summary:"Encrypt a payload",security:[['bearerAuth'=>[]]])]
    #[OA\QueryParameter(name: 'project', description: 'the project to use')]
    #[OA\QueryParameter(name: 'fields', description: 'a comma list of fields to operate')]
    #[OA\QueryParameter(name: 'op', description: ' "merge" or "overwrite" the default list of fields')]
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
            $project = $this->findProject($request);
            $pubKey = $this->publicKey($project);

            $input = json_decode($request->getContent(), true);

            $fields = $this->fields($project);
            $fields = $this->requestFields($request, $fields);
            foreach ($fields as $field){
                $field = trim($field);
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
    #[OA\QueryParameter(name: 'project', description: 'the project to use')]
    #[OA\QueryParameter(name: 'fields', description: 'a comma list of fields to operate')]
    #[OA\QueryParameter(name: 'op', description: ' "merge" or "overwrite" the default list of fields')]
    #[OA\Response(response: '200', description: 'The project')]
    public function decrypt(Request $request) : JsonResponse
    {
        try{
            $project = $this->findProject($request);

            $privKey = $this->privateKey($project);

            $input = json_decode($request->getContent(), true);

            $fields = $this->fields($project);
            $fields = $this->requestFields($request, $fields);
            foreach ($fields as $field){
                $field = trim($field);
                $founded = data_get($input, $field);
                if( $founded ) {
                    $decoded = base64_decode($founded);
                    openssl_private_decrypt($decoded, $decrypted, $privKey);
                    data_set($input, $field, $decrypted);
                }
            }

            return response()->json($input, 200);
        }catch (\Exception $e){
            return response()->json(["error"=>$e->getMessage()], 500);
        }
    }

    #[OA\Post(path:"/api/ofuscate",summary:"Ofusct a payload",security:[['bearerAuth'=>[]]])]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(
        properties: [
            new OA\Property(
                property: "example",
                description: "",
                required: ["false"],
                type: "string",
                example: "hola caracola"
            )
        ],
        type: 'object'
    ))]
    #[OA\QueryParameter(name: 'project', description: 'the project to use')]
    #[OA\QueryParameter(name: 'fields', description: 'a comma list of fields to operate')]
    #[OA\QueryParameter(name: 'op', description: ' "merge" or "overwrite" the default list of fields')]
    #[OA\Response(response: '200', description: 'The project')]
    public function ofuscate(Request $request) : JsonResponse
    {
        try{
            $project = $this->findProject($request);

            $input = json_decode($request->getContent(), true);

            $fields = $this->fields($project);
            $fields = $this->requestFields($request, $fields);
            foreach ($fields as $field){
                $field = trim($field);
                $founded = data_get($input, $field);
                if( $founded ) {
                    $ofuscated = $this->ofuscarCadena($founded, ['@', '.', '/','-',' ']);
                    data_set($input, $field, $ofuscated);
                }
            }

            return response()->json($input, 200);
        }catch (\Exception $e){
            print($e->getTraceAsString());
            return response()->json(["error"=>$e->getMessage()], 500);
        }
    }

    function ofuscarCadena($cadena, $excluirCaracteres = []) {
        $cadenaOfuscada = '';
        $longitudCadena = strlen($cadena);

        for ($i = 0; $i < $longitudCadena; $i++) {
            $caracter = $cadena[$i];

            if (in_array($caracter, $excluirCaracteres)) {
                $cadenaOfuscada .= $caracter; // Mantener el carácter original si está excluido
            } else {
                if (preg_match('/[a-zA-Z0-9]/', $caracter)){
                    // Algoritmo de ofuscación simple: desplazar el valor ASCII
                    $valorAscii = ord($caracter);
                    $valorOfuscado = $valorAscii + 5; // Puedes ajustar este valor de desplazamiento
                    $cadenaOfuscada .= chr($valorOfuscado);
                }
            }
        }

        return $cadenaOfuscada; // Codificar en Base64 para mayor ofuscación
    }

}
