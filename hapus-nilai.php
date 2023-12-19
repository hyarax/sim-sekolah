<?php
require 'functions.php';

$id_nilai = $_GET["id_nilai"];

if (hapusNilaiSiswa($id_nilai) > 0) {
    echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'data-nilai.php';
        </script>
    ";
} else {
    echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = 'data-nilai.php';
        </script>
    ";
}
