<?php

require_once 'core.php';
include_once("xlsxwriter.class.php");
if(isset($_SESSION['userId']) && $_SESSION['userType']==1) {
    $addedBy	=	$_SESSION['userName'];
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);

    $filename = "product_data-" . date('Ymd') . ".xlsx";
    header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    $sqlActivity = "INSERT INTO activity (name,details) VALUES ('$addedBy','Download Excel Sheet')";
    if($connect->query($sqlActivity) === TRUE)

    $writer = new XLSXWriter();
    $writer->setAuthor('Some Author');

        // //Cell Marge code//
        // $header = array("string","string","string","string","string");
        // $row1 = array("Jonaki Motors");
        // $sheet_name = 'Sheet1';
        // $writer = new XLSXWriter();
        // $writer->writeSheetHeader($sheet_name, $header, $suppress_header_row = true);
        // $writer->writeSheetRow($sheet_name, $row1);
        // $writer->markMergedCell($sheet_name, $start_row=0, $start_col=0, $end_row=0, $end_col=4);


    $rows = array('Jonaki Motors','','','','','','Date: ',date('d-m-Y'));
    $writer->writeSheetRow('Sheet1', $rows);
    $rows = array('Product Report','','','','','','Download by:',$addedBy);
    $writer->writeSheetRow('Sheet1', $rows);
    $rows = array('');
    $writer->writeSheetRow('Sheet1', $rows);

    $rows = array('SR.N.', 'Brand Name', 'Category Name', 'Product Name', 'Parts Number', 'Rate', 'Quantity', 'Product Price', 'Status');
    $writer->writeSheetRow('Sheet1', $rows);

    $sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
            product.categories_id, product.quantity, product.rate, product.active, product.status,
            brands.brand_name, categories.categories_name,product.part_number FROM product
            INNER JOIN brands ON product.brand_id = brands.brand_id
            INNER JOIN categories ON product.categories_id = categories.categories_id
            WHERE product.status = 1 AND product.active = 1";
        $result = $connect->query($sql);
    if($result->num_rows > 0){
        // Output each row of the data
        $active = "";
        $Total=0;

        $i=0;
        while($row = $result->fetch_assoc()){
          $Qun = $row["quantity"];
          $Rate = $row["rate"];
          $TotalProductPrice = $Qun * $Rate;
          $Total += $TotalProductPrice;
          if($row["status"] == 1) {
            $active = "Available";
          } else {
            $active = "Not Available";
          }
          $i++;
            $rows = array($i,$row["brand_name"],$row["categories_name"], $row["product_name"],$row["part_number"],$row["rate"],$row["quantity"],$TotalProductPrice,$active);
            $writer->writeSheetRow('Sheet1', $rows);
        }
        $rows = array("","","","","","","Total:", $Total);
        $writer->writeSheetRow('Sheet1', $rows);
    }else{
      $rows = array("No Data Found");
      $writer->writeSheetRow('Sheet1', $rows);
    }

    $writer->writeToStdOut();
    exit(0);

}else {
    header('location: http://localhost/inventory-management-system/index.php');
}
