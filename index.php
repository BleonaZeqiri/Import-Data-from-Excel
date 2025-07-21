<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "data1");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <?php
            if (isset($_SESSION['status'])) {
                echo "<h5 class='text-success'>" . $_SESSION['status'] . "</h5>";
                unset($_SESSION["status"]);
            }
            ?>
            <form action="code.php" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Import Excel file</label>
                    <input class="form-control form-control-sm" id="formFileSm" type="file" name="import_file" required>
                </div>
                <div class="mb-3">
                    <button type="submit" name="import_file_btn" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>

        <!-- Table of students -->
        <div class="row">
            <h4>Student Data</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM student";
                    $query_run = mysqli_query($con, $query);

                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['stud_name'] . "</td>";
                            echo "<td>" . $row['stud_class'] . "</td>";
                            echo "<td>" . $row['stud_phone'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No Data Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>