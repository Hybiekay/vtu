<?php


// -------------------------------------------------------------------
// Purchase Airtime
// -------------------------------------------------------------------
/**
 * @OA\Post(
 *     path="/api/alphatopup",
 *     summary="Purchase Airtime",
 *     description="Purchase airtime and deduct balance from the user's wallet.",
 *     operationId="purchaseAirtime",
 *     tags={"Airtime"},
 *  security={
 *     {"bearerAuth": {}}
 *   },
 *     @OA\Parameter(
 *         name="Authorization",
 *         in="header",
 *         required=true,
 *         description="Bearer token for authorization",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="phone", type="string", description="Mobile number"),
 *                 @OA\Property(property="amount", type="string", description="Amount of airtime to purchase"),
 *                 @OA\Property(property="ref", type="string", description="Transaction reference")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Transaction successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="Status", type="string", example="successful")
 *         )
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad request due to invalid parameters or insufficient balance",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fail"),
 *             @OA\Property(property="msg", type="string", description="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Unauthorized due to missing or invalid authorization token",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fail"),
 *             @OA\Property(property="msg", type="string", description="Error message")
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="fail"),
 *             @OA\Property(property="msg", type="string", description="Error message")
 *         )
 *     )
 * )
 */