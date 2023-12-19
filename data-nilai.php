<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
$nilai_siswa = query("SELECT * FROM nilai_siswa, siswa WHERE nilai_siswa.nis = siswa.nis");
// var_dump($nilai_siswa);

$user_type = $_SESSION['user_type'] == 'Super Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai Siswa | SIM Sekolah</title>
    <link rel="icon" href="./assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <header>
        <div class="welcome">
            <h1>Manajemen Nilai Siswa</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <?php if ($user_type) {
                ?>
                    <li id="list-admin"><a href="data-admin.php">List Admin</a></li>
                <?php } ?>
            </ul>
        </nav>
        <a href="logout.php"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
    </header>

    <section class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Data Nilai Siswa</h1>
            <div>
                <button type="button" class="btn btn-primary"><a href="tambah-nilai.php" style="color: #fff; text-decoration:none;"> Tambah Data</a></button>
            </div>
        </div>
        <p>
        <div class="card">
            <div class="table-responsive">
                <table class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nilai UTS</th>
                            <th scope="col">Nilai UAS</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($nilai_siswa as $row) : ?>

                            <tr>
                                <td scope="row"><?= $i; ?></td>
                                <td><?= $row["nis"]; ?></td>
                                <td><?= $row["nama"]; ?></td>
                                <td><?= $row["nilai_uts"]; ?></td>
                                <td><?= $row["nilai_uas"]; ?></td>
                                <td><?= $row["grade"]; ?></td>
                                <td class="button-action">
                                    <a href="ubah-nilai.php?id_nilai=<?= $row["id_nilai"]; ?>"><button type="button" class="btn btn-sm btn-warning">Edit</button></a>
                                    <a href="hapus-nilai.php?id_nilai=<?= $row["id_nilai"]; ?>"><button type="button" class="btn btn-sm btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script src="https://kit.fontawesome.com/7009cf2d19.js" crossorigin="anonymous"></script>
</body>

</html>