<?php
/**
 * @OA\Post(
  *   path="/api/airtime",
 *   summary="Purchase Airtime",
 *   description="Purchases airtime for a mobile number using various networks.",
 *   tags={"Airtime"},
 *   @OA\RequestBody(
 *     required=true,
 *     description="Request body for purchasing airtime",
 *     @OA\JsonContent(
 *       @OA\Property(property="network", type="string", description="Network ID (e.g., MTN, Glo, Airtel)"),
 *       @OA\Property(property="phone", type="string", description="Mobile phone number to receive airtime"),
 *       @OA\Property(property="amount", type="number", format="float", description="Airtime amount to purchase"),
 *       @OA\Property(property="ported_number", type="string", description="Indicate if the number is ported", example="false"),
 *       @OA\Property(property="airtime_type", type="string", description="Airtime type (e.g., VTU, Share And Sell, Momo, Awoof)", example="VTU"),
 *       @OA\Property(property="ref", type="string", description="Transaction reference")
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Airtime purchase successful",
 *     @OA\JsonContent(
 *       @OA\Property(property="status", type="string", description="Transaction status", example="success"),
 *       @OA\Property(property="Status", type="string", description="Detailed status", example="successful"),
 *     )
 *   ),
 *   @OA\Response(
 *     response=400,
 *     description="Bad Request - Validation failed",
 *     @OA\JsonContent(
 *       @OA\Property(property="status", type="string", description="Transaction status", example="fail"),
 *       @OA\Property(property="msg", type="string", description="Error message explaining the failure"),
 *     )
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Unauthorized - Invalid or missing token",
 *     @OA\JsonContent(
 *       @OA\Property(property="status", type="string", description="Transaction status", example="fail"),
 *       @OA\Property(property="msg", type="string", description="Authorization token is required or invalid"),
 *     )
 *   ),
 *   @OA\Response(
 *     response=500,
 *     description="Internal Server Error - Something went wrong",
 *     @OA\JsonContent(
 *       @OA\Property(property="status", type="string", description="Transaction status", example="fail"),
 *       @OA\Property(property="msg", type="string", description="Detailed error message"),
 *     )
 *   ),
 *   security={
 *     {"bearerAuth": {}}
 *   }
 * )
 */


?>
