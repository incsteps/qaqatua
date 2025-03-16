<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;


#[
    OA\Info(version: "1.0.0", description: "QA enc/dec api", title: "QA Encription/Decription API"),
    OA\Server(url: 'http://localhost:8000', description: "local server"),
    OA\Server(url: 'https://qaqatua.com', description: "production server"),
    OA\SecurityScheme( securityScheme: 'bearerAuth', type: "http", name: "Authorization", in: "header", scheme: "bearer"),
]
abstract class Controller
{
    //
}
