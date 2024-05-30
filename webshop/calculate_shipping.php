<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $orderDate = $_POST['order_date'];


    $nonShippingDays = [0, 6]; 

    $cutOffTime = '11:00:00';


    $currentTime = new DateTime();
    $currentDate = $currentTime->format('Y-m-d');

    if ($orderDate < $currentDate) {
        echo "<div class='container mt-5'>";
        echo "<h2>Error: The order date cannot be in the past.</h2>";
        echo "</div>";
        exit;
    }

    $orderDateTime = new DateTime($orderDate . ' ' . $currentTime->format('H:i:s'));

    $cutOffDateTime = new DateTime($orderDate . ' ' . $cutOffTime);
    if ($orderDateTime > $cutOffDateTime) {
        $orderDateTime->modify('+1 day');
    }


    $shippingDate = clone $orderDateTime;
    while (in_array((int)$shippingDate->format('w'), $nonShippingDays)) {
        $shippingDate->modify('+1 day');
    }


    echo "<div class='container mt-5'>";
    echo "<h2>Order Date: " . $orderDateTime->format('Y-m-d H:i:s') . "</h2>";
    echo "<h2>Expected Shipping Date: " . $shippingDate->format('Y-m-d') . "</h2>";
    echo "</div>";
}
?>
