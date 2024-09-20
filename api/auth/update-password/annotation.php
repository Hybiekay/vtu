<?php

/**
 * @OA\Post(
 *     path="api/auth/update-password",
 *     summary="Update User Password",
 *     description="Updates user password using email and token.",
 *      tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", example="user@example.com"),
 *                 @OA\Property(property="token", type="string", example="123456"),
 *                 @OA\Property(property="password", type="string", example="NewPassword123!")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Password updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Password Updated Successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request - Missing fields",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="All the fields are required")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - Incorrect code or email",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Code or Email is not correct")
 *         )
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed - Only POST method is allowed",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Only POST method is allowed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="An unexpected error occurred")
 *         )
 *     )
 * )
 */
