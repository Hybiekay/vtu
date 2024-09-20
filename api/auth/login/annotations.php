<?php
/**
 * @OA\Post(
 *     path="/api/auth/login",
 *     summary="Login a user",
 *      tags={"Auth"},
 * 
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"phone", "accesspass"},
 *             @OA\Property(property="phone", type="string", example="08012345678"),
 *             @OA\Property(property="password", type="string", example="userpassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="msg", type="string", example="Login Successful"),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="phone", type="string", example="08012345678"),
 *             @OA\Property(property="token", type="string", example="token")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="unauthorized"),
 *             @OA\Property(property="msg", type="string", example="Phone Number Field Is Required")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fail"),
 *             @OA\Property(property="msg", type="string", example="Authorization token not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="unauthorized"),
 *             @OA\Property(property="msg", type="string", example="Unauthorized Access")
 *         )
 *     ),
 * )
 */

// Your API logic here...



    

