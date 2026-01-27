<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="Api Seletivo Seplag Gov-MT", version="0.1")
 * @OA\SecurityScheme(
    *     type="http",
    *     securityScheme="bearerAuth",
    *     scheme="bearer",
    *     bearerFormat="JWT"
    * )
 */

class SwaggerAuthController extends Controller
{
    //
}
