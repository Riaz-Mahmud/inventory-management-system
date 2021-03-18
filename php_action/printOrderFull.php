<?php

require_once 'core.php';

$orderId        = $_POST['orderId'];
$addedBy				=	$_SESSION['userName'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_place,gstn,invoiceId FROM orders WHERE order_id = $orderId";

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
$invoiceId = $orderData[12];

//echo "Today is " . date("Y/m/d") . "<br>";

$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
   INNER JOIN product ON order_item.product_id = product.product_id
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

$table = '<style>
.star img {
    visibility: visible;
}</style>

<h3 align="right">CASH MEMO</h3>
<hr size="5" width="100%" color="red"  style=" margin-top:-18px">

<h3 align="left">JONAKI MOTORS</h3>
<hr size="1" width="23%" color="black" align="left" style=" margin-top:-18px">


<table cellpadding="0" cellspacing="0" style="width: 100%;">

<tr style="border-bottom: 1px solid black;">
   <td >95, NEW ESKATON ROAD, HELENA CENTER</td>
   <td  align="left">MEMO# '.$invoiceId.'</td>
</tr>
<tr style="border-bottom: 1px solid black;">
   <td >DHAKA-100</td>
   <td  align="left">DATE: '.$orderDate.'</td>
</tr>
<tr style="border-bottom: 1px solid black;">
   <td>+8848316990,+8858312608,+8801711524544,+8801680602521</td>
</tr>
<tr style="border-bottom: 1px solid black;">
   <td>jonakimotors@yahoo.com</td>
</tr>
</table>

<p align="left">BILL TO</p>
<hr size="1" align="left" width="9%" color="red"  style=" margin-top:-16px;">
  <table cellpadding="0" cellspacing="0" style=" width: 40%; margin-top:-5px; margin-left:40px; margin-bottom: 10px;">
    <tr style="border-bottom: 1px solid black;">
       <td >Name</td>
       <td >:</td>
       <td  align="left">'.$clientName.'</td>
    </tr>
    <tr style="border-bottom: 1px solid black;">
       <td >Contact</td>
       <td >:</td>
       <td  align="left">'.$clientContact.'</td>
    </tr>
  </table>



<table align="center" cellpadding="0" cellspacing="0" style="width: 100%;border:1px solid black;margin-bottom: 5px;">
               <tbody>
                  <tr>
                     <td style="width: 123px;text-align: center;background-color: red;color: white;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;"> SL</td>
                     <td style="width: 50%;text-align: center;color: white;background-color: red;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;">Description Of Goods</td>
                     <td style="width: 150px;text-align: center;background-color: red;color: white;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;">Qty.</td>
                     <td style="width: 150px;text-align: center;background-color: red;color: white;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;">Rate&nbsp;</td>
                     <td style="width: 150px;text-align: center;color: white;background-color: red;border-bottom: 1px solid black;-webkit-print-color-adjust: exact;">Amount&nbsp;
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

            </table>
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

            <tr >
              <td></td>
              <td></td>
              <td  colspan="2" align="center" style="padding-top:50px;"><hr size="1" width="60%" color="red" > </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td colspan="2" align="center">Signature </td>
            </tr>
            </table>'
            .'<p align="center" style="margin-top:0px;">Thank You</p>';

            $sqlActivity = "INSERT INTO activity (name,details,itemName) VALUES ('$addedBy','Full Print Order','$clientName')";
            if($connect->query($sqlActivity) === TRUE)

$connect->close();

echo $table;
