<?php

namespace App\Http\Controllers\ApiDocs;

/**
 * @OA\Info(
 *     title="TaskHub-API",
 *     version="1.0.0",
 *     description="API for managing tasks and tags in TaskHub",
 *     @OA\Contact(
 *         email="support@taskhub.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://taskhub-api.test",
 *     description="TaskHub-API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     name="Authorization",
 *     in="header",
 *     description="Enter token in format (Bearer <token>)"
 * )
 * @OA\Post(
 *     path="/api/login",
 *     tags={"Authentication"},
 *     summary="User login to obtain an API token",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email", example="ahmet@example.com"),
 *             @OA\Property(property="password", type="string", example="password")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unauthorized")
 *         )
 *     )
 * )
 */
class LoginApiDoc
{
}
