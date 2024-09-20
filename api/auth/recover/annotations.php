<?php
/**
 * @OA\Post(
 *     path="/api/auth/recover",
 *     summary="Recover user login details",
 * tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="string", example="user@example.com")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Email sent successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Email sent successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fails"),
 *             @OA\Property(property="message", type="string", example="Email is required")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User Not Found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fail"),
 *             @OA\Property(property="message", type="string", example="User does not exist")
 *         )
 *     ),
 * )
 */