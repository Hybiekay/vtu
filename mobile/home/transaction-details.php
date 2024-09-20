<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payment Receipt</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
        }

        .card-style {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .receipt-details table {
            width: 100%;
            margin-bottom: 1rem;
            color: #495057;
        }

.receipt-details table th {
    background: linear-gradient(135deg, #ff5e00, #ff9800);
    color: #fff;
        }

        .receipt-details table td,
        .receipt-details table th {
            padding: 1rem;
            text-align: left;
            border-top: 1px solid #dee2e6;
        }

        .receipt-details a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card-style">
            <div class="text-center">
                <img src="https://abakon.ng/mobile/5445033.png" style="width:80px; height:80px;" />
            </div>
            <h3 style="text-align: center;">Payment Successful</h3>
            <center>
    <b style="background: linear-gradient(135deg, #ff5e00, #ff9800); color: #fff;">
        <?php echo $data->servicedesc; ?>
        <?php if (!isset($_GET["receipt"])): ?>
    </b>
</center>

            <div class="receipt-details">
                <table>
                    <thead>
                        <tr>
                            <th>Transaction No</th>
                            <td><?php echo $data->transref; ?></td>
                        </tr>
                        <tr>
                            <th>Service</th>
                            <td><?php echo $data->servicename; ?></td>
                        </tr>
                        
                            <tr>
                                <th>Amount</th>
                                <td>N<?php echo $data->amount; ?></td>
                            </tr>
                            
                        <?php endif; ?>
                        <tr>
                            <th>Status</th>
                            <td><?php echo $controller->formatStatus($data->status); ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><?php echo $controller->formatDate($data->date); ?></td>
                        </tr>
                    </thead>
                </table>
                <?php if ($data->servicename == "Data Pin" && $data->status == 0): ?>
                    <a href="view-pins?ref=<?php echo $_GET["ref"]; ?>">
                        <b>View Pins</b>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>
