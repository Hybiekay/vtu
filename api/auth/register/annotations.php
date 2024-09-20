<?php

use OpenApi\Annotations as OA;
/**
 *  @OA\Info(
 *     title="Abakon",
 *     version="1.0.0",
 *     description="A description of your API",
 *     @OA\Contact(
 *         email="contact@abakon.com.ng"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     ),
 * )
 *    @OA\Server(
 *     url="https://test.abakon.ng",
 *      description="Production server"
 *  )
 * 
 *  @OA\Server(
 *      url="http://localhost:3000",
 *      description="Local development server"
 *  )
 *
 */

/**
 * @OA\PathItem(
 *     path="/api/auth/register",
 *     @OA\Post(
 *         summary="Register a new user",
 *          tags={"Auth"},
 *         @OA\RequestBody(
 *             required=true,
 *             @OA\JsonContent(
 *                 type="object",
 *                 @OA\Property(property="firstname", type="string", example="John"),
 *                 @OA\Property(property="lastname", type="string", example="Doe"),
 *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
 *                 @OA\Property(property="phone", type="string", example="1234567890"),
 *                 @OA\Property(property="password", type="string", example="password123"),
 *                 @OA\Property(property="state", type="string", example="NY"),
 *                 @OA\Property(property="referal", type="string", example="admin"),
 *                 @OA\Property(property="transpin", type="string", example="1234")
 *             )
 *         ),
 *         @OA\Response(
 *             response=200,
 *             description="Successful registration",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=0),
 *                 @OA\Property(property="msg", type="string", example="Registration successful")
 *             )
 *         ),
 *         @OA\Response(
 *             response=400,
 *             description="Bad request",
 *             @OA\JsonContent(
 *                 @OA\Property(property="status", type="integer", example=1),
 *                 @OA\Property(property="msg", type="string", example="Invalid input")
 *             )
 *         )
 *     )
 * )
 */
