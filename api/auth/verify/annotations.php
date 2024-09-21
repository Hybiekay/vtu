<?php
/**
 * @OA\Post(
 *     path="/api/auth/verify",
 *     summary="Verify recovery code for password reset",
 *      tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "otp"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="otp", type="string", example="3456")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Verification successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Successfully verified"),
 *             @OA\Property(property="token", type="string", example="userLoginToken")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Only POST method is allowed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Verification failed",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Error verifying OTP")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Email or token missing",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Email is required")
 *         )
 *     ),
 * )
 */