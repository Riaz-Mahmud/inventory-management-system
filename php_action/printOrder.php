<?php

require_once 'core.php';

$orderId        = $_POST['orderId'];
$addedBy				=	$_SESSION['userName'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_place,gstn FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2];
$subTotal = $orderData[3];
$vat = $orderData[4];
$totalAmount = $orderData[5];
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];
$payment_place = $orderData[10];
$gstn = $orderData[11];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
   INNER JOIN product ON order_item.product_id = product.product_id
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

$table = '<style>
.star img {
    visibility: visible;
}</style>

<h3 align="center">INVOICE</h3>
<h3 align="center">'.$clientName.'</h3>
<p align="center" style=" margin-top:-15px">'.$clientContact.'</p>

<table align="center" cellpadding="0" cellspacing="0" style="width: 100%;border:1px solid black;margin-bottom: 5px;">
               <tbody>
                  <tr>
                     <td style="width: 123px;text-align: center;background-color: black;color: white;border-right: 1px solid white;border-left: 1px solid black;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;"> SL</td>
                     <td style="width: 50%;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: white;border-bottom-color: black;color: white;background-color: black;-webkit-print-color-adjust: exact;">Description Of Goods</td>
                     <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: #fff;border-bottom-color: black;background-color: black;color: white;-webkit-print-color-adjust: exact;">Qty.</td>
                     <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: #fff;border-bottom-color: black;background-color: black;color: white;-webkit-print-color-adjust: exact;">Rate&nbsp;</td>
                     <td style="width: 150px;text-align: center;border-top-style: solid;border-right-style: solid;border-bottom-style: solid;border-top-width: thin;border-right-width: thin;border-bottom-width: thin;border-top-color: black;border-right-color: black;border-bottom-color: black;color: white;background-color: black;-webkit-print-color-adjust: exact;">Amount&nbsp;
                        &nbsp;
                     </td>
                  </tr>';
                  $x = 1;
                  $cgst = 0;
                  $igst = 0;
                  if($payment_place == 2)
                  {
                     $igst = $subTotal*18/100;
                  }
                  else
                  {
                     $cgst = $subTotal*9/100;
                  }
                  $total = $subTotal+2*$cgst+$igst;
            while($row = $orderItemResult->fetch_array()) {

               $table .= '<tr>
                     <td align="center" style="border-left: 1px solid black;border-right: 1px solid black;height: 27px;">'.$x.'</td>
                     <td align="center" style="border-left: 1px solid black;height: 27px;">'.$row[4].'</td>
                     <td align="center" style="border-left: 1px solid black;height: 27px;">'.$row[2].'</td>
                     <td align="center" style="border-left: 1px solid black;height: 27px;">'.$row[1].'</td>
                     <td align="center" style="border-left: 1px solid black;border-right: 1px solid black;height: 27px;">'.$row[3].'</td>
                  </tr>
               ';
            $x++;
            } // /while
                $table.= '

               </tbody>

               <table align="right" cellpadding="0" cellspacing="0" style="width: 100%;margin-bottom:10px;">

               <tr>
                   <td></td>
                   <td></td>
                  <td style="width: 100px;background-color: white;color: black;padding-left: 5px;-webkit-print-color-adjust: exact; text-align: right; padding-right:3px;">Sub Total</td>
                  <td style="width: 100px; border-bottom: 1px solid black; text-align: right; padding-right:10px;">'.$totalAmount.'</td>
               </tr>
               <tr>
                 <td></td>
                 <td></td>
                  <td style="width: 100px;background-color: white;color: black;padding-left: 5px;-webkit-print-color-adjust: exact; text-align: right; padding-right:3px;">Discount</td>
                  <td style="width: 100px; border-bottom: 1px solid black; text-align: right; padding-right:10px;">'.$discount.'</td>
               </tr>
               <tr >
                 <td></td>
                 <td></td>
                  <td style="width: 100px;background-color: white;color: black;padding-left: 5px;-webkit-print-color-adjust: exact; text-align: right; padding-right:3px;">Grand Total</td>
                  <td style="width: 100px; border-bottom: 1px solid black; text-align: right; padding-right:10px;">'.$grandTotal.'</td>
               </tr>
               <tr>
                 <td></td>
                 <td></td>
                  <td style="width: 100px;background-color: white;color: black;padding-left: 5px;-webkit-print-color-adjust: exact; text-align: right; padding-right:3px;">Paid Amount</td>
                  <td style="width: 100px; border-bottom: 1px solid black; text-align: right; padding-right:10px;">'.$paid.'</td>
               </tr>
               <tr>
                 <td></td>
                 <td></td>
                  <td style="width: 100px;background-color: white;color: black;padding-left: 5px;-webkit-print-color-adjust: exact; text-align: right; padding-right:3px;">Due Amount</td>
                  <td style="width: 100px; border-bottom: 1px solid black; text-align: right; padding-right:10px;">'.$due.'</td>
               </tr>
               </table>';

            $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Normal Print Order','$clientName')";
            if($connect->query($sqlActivity) === TRUE)

$connect->close();

echo $table;
