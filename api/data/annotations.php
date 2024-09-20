<?php
/**
 * @OA\Post(
 *     path="/api/data",
 *     summary="Purchase Data Plan",
 *     description="Endpoint to purchase a data plan. Requires authorization and proper input parameters.",
 *     operationId="purchaseDataPlan",
 *     tags={"Data Plan"},
 *    security={
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
 *                 @OA\Property(property="network", type="string", description="Network ID"),
 *                 @OA\Property(property="phone", type="string", description="Mobile number"),
 *                 @OA\Property(property="ported_number", type="string", enum={"true", "false"}, description="Whether the number is ported"),
 *                 @OA\Property(property="data_plan", type="string", description="Data plan ID"),
 *                 @OA\Property(property="ref", type="string", description="Transaction reference")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Transaction processed successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="Status", type="string", example="successful"),
 *             @OA\Property(property="true_response", type="string", description="Real response from the service", nullable=true)
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