
<?php

/**
 * @OA\Post(
 *     path="/api/data-pin",
 *     summary="Purchase Data Pin",
 *     description="Allows users to purchase data pins with a specified network, quantity, and data plan.",
 *     tags={"Data Plan"},
 *    security={
 *     {"bearerAuth": {}}
 *   },
 *     @OA\Parameter(
 *         name="Authorization",
 *         in="header",
 *         description="Authorization token",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"network", "quantity", "data_plan", "ref", "businessname"},
 *                 @OA\Property(
 *                     property="network",
 *                     description="Network ID for the data pin",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     description="Quantity of data pins to purchase",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="data_plan",
 *                     description="Data plan ID",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="ref",
 *                     description="Transaction reference",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="businessname",
 *                     description="Business name associated with the transaction",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="ported_number",
 *                     description="Indicates if the number is ported",
 *                     type="string",
 *                     example="false"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Transaction successful",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="Status",
 *                 type="string",
 *                 example="successful"
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="serial",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="pin",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="load_pin",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="check_balance",
 *                 type="string"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail"
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Data Plan ID Is Required"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail"
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Your authorization token is required."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail"
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Could Not Complete Transaction"
 *             )
 *         )
 *     )
 * )
 */
