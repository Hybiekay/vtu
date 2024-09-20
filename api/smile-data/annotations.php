<?php
/**
 * @OA\Post(
 *     path="/api/smile-data",
 *     summary="Purchase Smile Data",
 *     tags={"Data Plan"},
 *     description="Endpoint for purchasing Smile data bundles.",
 *   security={
 *     {"bearerAuth": {}}
 *   },
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"PhoneNumber", "BundleTypeCode", "actype", "ref"},
 *                 @OA\Property(
 *                     property="PhoneNumber",
 *                     type="string",
 *                     example="2341234567890",
 *                     description="The phone number or account number."
 *                 ),
 *                 @OA\Property(
 *                     property="BundleTypeCode",
 *                     type="string",
 *                     example="123",
 *                     description="The ID of the data bundle."
 *                 ),
 *                 @OA\Property(
 *                     property="actype",
 *                     type="string",
 *                     enum={"PhoneNumber", "AccountNumber"},
 *                     example="PhoneNumber",
 *                     description="Type of account being used, either PhoneNumber or AccountNumber."
 *                 ),
 *                 @OA\Property(
 *                     property="ref",
 *                     type="string",
 *                     example="unique-transaction-reference",
 *                     description="Unique reference for the transaction."
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Transaction successful",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success",
 *                 description="Status of the transaction."
 *             ),
 *             @OA\Property(
 *                 property="network",
 *                 type="string",
 *                 example="SMILE",
 *                 description="Network provider."
 *             ),
 *             @OA\Property(
 *                 property="amount",
 *                 type="number",
 *                 format="float",
 *                 example="1000.00",
 *                 description="Amount debited."
 *             ),
 *             @OA\Property(
 *                 property="oldbal",
 *                 type="number",
 *                 format="float",
 *                 example="5000.00",
 *                 description="Old balance before transaction."
 *             ),
 *             @OA\Property(
 *                 property="newbal",
 *                 type="number",
 *                 format="float",
 *                 example="4000.00",
 *                 description="New balance after transaction."
 *             ),
 *             @OA\Property(
 *                 property="service",
 *                 type="string",
 *                 example="Smile",
 *                 description="Service name."
 *             ),
 *             @OA\Property(
 *                 property="description",
 *                 type="string",
 *                 example="Purchase of SMILE 1GB Plan",
 *                 description="Description of the service purchased."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="400",
 *         description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail",
 *                 description="Status of the request."
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Phone Number or Account Number Is Required",
 *                 description="Error message describing what went wrong."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail",
 *                 description="Status of the request."
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Your authorization token is required.",
 *                 description="Error message for unauthorized requests."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="fail",
 *                 description="Status of the request."
 *             ),
 *             @OA\Property(
 *                 property="msg",
 *                 type="string",
 *                 example="Could Not Complete Transaction",
 *                 description="Error message indicating server-side issues."
 *             )
 *         )
 *     )
 * )
 */

?>
