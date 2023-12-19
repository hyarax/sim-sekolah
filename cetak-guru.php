<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
$kd_golongan = '';

require 'functions.php';
$guru = query("SELECT * FROM guru");


$user_type = $_SESSION['user_type'] == 'Super Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Guru</title>
    <link rel="icon" href="./assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/print.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <section id="data-guru" class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 style="margin-right: auto;">Print Data Guru</h1>
            <div class="buttons" style="margin-bottom:20px">
                <button type="button" class="btn btn-sm  btn-danger" style="margin-right:10px;"><a href="data-guru.php" style="color: #fff; text-decoration:none; "> Batal</a></button>
                <button id="print" onclick="printTable()" class="btn btn-sm btn-secondary" style="margin-right: 10px;">Cetak</button>
                <button id="show-all" class="btn btn-sm btn-info" style="margin-right: 10px;">Semua</button>
                <button name="refresh" type="submit" class="btn btn-sm btn-success" style="margin-right: 10px;">Refresh</button>
            </div>
        </div>

        <div class="list-guru" id="printIndentTable">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">NIP</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Tanggal Lahir</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">No. Telp</th>
                        <th scope="col">Bidang Studi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($guru as $row) : ?>

                        <tr>
                            <td scope="row"><?= $i; ?></td>
                            <td scope="row"><?= $row["nip"]; ?></td>
                            <td><?= $row["nama"]; ?></td>
                            <td><?= $row["jns_kelamin"]; ?></td>
                            <td><?= $row["tgl_lahir"]; ?></td>
                            <td><?= $row["alamat"]; ?></td>
                            <td><?= $row["no_telp"]; ?></td>
                            <td><?= $row["bidang_studi"]; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        function printTable() {
            window.print();
        }
    </script>
    <script src="extensions/print/bootstrap-table-print.js"></script>
    <script src="https://kit.fontawesome.com/7009cf2d19.js " crossorigin="anonymous "></script>
</body>

</html>