<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
// Ambil nilai ID nilai siswa yang akan diubah dari parameter GET
$id_nilai = $_GET["id_nilai"];

// Query data nilai siswa berdasarkan id_nilai
$nilai_siswa = query("SELECT * FROM nilai_siswa WHERE id_nilai = $id_nilai")[0];

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
    // Ambil nilai-nilai dari form
    $nis = $_POST['nis'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];
    $grade = $_POST['grade'];

    // Lakukan proses update dengan fungsi ubahNilaiSiswa
    if (ubahNilaiSiswa($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil diubah!');
                document.location.href = 'data-nilai.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data gagal diubah!');
                document.location.href = 'data-nilai.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Nilai Siswa</title>
    <link rel="icon" href="./assets/img/logo.png">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="margin-top: 50px;">
    <header class="container">
        <h3>Ubah Data Nilai Siswa</h3>
    </header>
    <section id="edit-data-nilai" class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_nilai" value="<?= $nilai_siswa['id_nilai']; ?>">

            <div class="form-group row">
                <label for="nis" class="col-4 col-form-label">NIS</label>
                <div class="col-8">
                    <input id="nis" name="nis" value="<?= $nilai_siswa['nis']; ?>" type="text" class="form-control" required="required" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="nilai_uts" class="col-4 col-form-label">Nilai UTS</label>
                <div class="col-8">
                    <input id="nilai_uts" name="nilai_uts" value="<?= $nilai_siswa['nilai_uts']; ?>" type="text" class="form-control" required="required" onkeyup="hitungGrade()">
                </div>
            </div>
            <div class="form-group row">
                <label for="nilai_uas" class="col-4 col-form-label">Nilai UAS</label>
                <div class="col-8">
                    <input id="nilai_uas" name="nilai_uas" value="<?= $nilai_siswa['nilai_uas']; ?>" type="text" class="form-control" required="required" onkeyup="hitungGrade()">
                </div>
            </div>
            <div class="form-group row">
                <label for="grade" class="col-4 col-form-label">Grade</label>
                <div class="col-8">
                    <input id="grade" name="grade" value="<?= $nilai_siswa['grade']; ?>" type="text" class="form-control" required="required">
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-4 col-8">
                    <button name="submit" type="submit" class="btn btn-success">Submit</button>
                    <button name="cancel" type="button" class="btn btn-danger"><a href="data-nilai.php" style="color: #fff; text-decoration:none; ">Cancel</a></button>
                </div>
            </div>
        </form>

        <script>
            function hitungGrade() {
                var nilai_uts = parseFloat(document.getElementById('nilai_uts').value);
                var nilai_uas = parseFloat(document.getElementById('nilai_uas').value);
                var grade = document.getElementById('grade');
                var rata_rata = (nilai_uts + nilai_uas) / 2;

                if (rata_rata >= 80) {
                    grade.value = 'A';
                } else if (rata_rata >= 60) {
                    grade.value = 'B';
                } else if (rata_rata >= 40) {
                    grade.value = 'C';
                } else if (rata_rata >= 20) {
                    grade.value = 'D';
                } else {
                    grade.value = 'E';
                }
            }
        </script>

        <script src="https://kit.fontawesome.com/7009cf2d19.js " crossorigin="anonymous "></script>
</body>

</html>