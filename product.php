
<?php
// Database connection details
$host = "localhost";
$dbname = "db2439648";
$username = "2439648";
$password = "39Kathmandu@";

try {
    // Connect to the MySQL database
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Enable PDO error reporting
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Retrieve all products
    $sql = "SELECT Product_name, Category, Price, Date_added
            FROM products
            ORDER BY Product_id ASC";

    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Do not expose database credentials or technical details
    http_response_code(500);
    die("Database connection failed. Please check your configuration.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product List - 5CS045</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333333;
            text-align: center;
        }

        table {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #cccccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #eeeeee;
        }

        tr:hover {
            background-color: #dddddd;
        }

        .message {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>

<body>

    <h1>Product List</h1>

    <?php if (count($products) > 0): ?>

        <table>
            <thead>
                <tr>
                    <th>Product name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Date added</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars(
                                $product['Product_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $product['Category'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            £<?= number_format(
                                (float) $product['Price'],
                                2,
                                '.',
                                ''
                            ) ?>
                        </td>

                        <td>
                            <?= date(
                                'd/m/Y',
                                strtotime($product['Date_added'])
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>

        <p class="message">No products found in the database.</p>

    <?php endif; ?>

</body>
</html>
