
<?php
/**
 * @OA\Post(
 *     path="/api/exam-pin",
 *     summary="Purchase Exam Pin Token",
 *     description="Allows users to purchase exam pin tokens with specified details.",
 *     tags={"Exam Pin"},
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
 *                 required={"provider", "quantity", "ref"},
 *                 @OA\Property(
 *                     property="provider",
 *                     description="Provider ID for the exam pin",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="quantity",
 *                     description="Quantity of exam pin tokens to purchase",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="ref",
 *                     description="Transaction reference",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="exam_name",
 *                     description="Exam name",
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
 *                 property="msg",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="pin",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="pins",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="token",
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
 *                 example="Provider Id Required"
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
