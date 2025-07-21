<?php
$con = mysqli_connect("localhost", "root", "", "data1");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST["import_file_btn"])) {
    $allowed_ext = ['xls', 'csv', 'xlsx'];
    $fileName = $_FILES['import_file']['name'];
    $checking = explode('.', $fileName);
    $file_ext = end($checking);
    if (in_array($file_ext, $allowed_ext)) {
        $targetPath = $_FILES['import_file']['tmp_name'];

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            // Marrim të dhënat (pa ID sepse është AUTO_INCREMENT)
            $stud_name = $row[1];
            $stud_class = $row[2];
            $stud_phone = $row[3];

            // Futen direkt në databazë
            $in_query = "INSERT INTO student (stud_name, stud_class, stud_phone) VALUES('$stud_name', '$stud_class', '$stud_phone')";
            $in_result = mysqli_query($con, $in_query);
            $msg = 1;
        }

        if (isset($msg)) {
            $_SESSION['status'] = "Imported Successfully";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Import Failed";
            header("Location: index.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Invalid File";
        header("Location: index.php");
        exit(0);
    }
}
?>