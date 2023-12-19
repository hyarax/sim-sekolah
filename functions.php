<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "sekolah_database");


function query($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

function tambahSiswa($data)
{
	global $conn;

	$nis = htmlspecialchars($data["nis"]);
	$nama = htmlspecialchars($data["nama"]);
	$jns_kelamin = htmlspecialchars($data["jns_kelamin"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$kd_kelas = htmlspecialchars($data["kd_kelas"]);

	$query = "INSERT INTO siswa
				VALUES
			  ('$nis', '$nama', '$jns_kelamin', '$alamat', '$kd_kelas')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function tambahGuru($data)
{
	global $conn;

	$nip = htmlspecialchars($data["nip"]);
	$nama = htmlspecialchars($data["nama"]);
	$jns_kelamin = htmlspecialchars($data["jns_kelamin"]);
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$no_telp = htmlspecialchars($data["no_telp"]);
	$bidang_studi = htmlspecialchars($data["bidang_studi"]);

	$query = "INSERT INTO guru
				VALUES
			  ('$nip', '$nama', '$jns_kelamin',  '$tgl_lahir','$alamat', '$no_telp', '$bidang_studi')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function tambahJadwal($data)
{
	global $conn;

	$kd_jadwal = htmlspecialchars($data["kd_jadwal"]);
	$hari = htmlspecialchars($data["hari"]);
	$waktu = htmlspecialchars($data["waktu"]);
	$jmlh_jam = htmlspecialchars($data["jmlh_jam"]);
	$kd_kelas = htmlspecialchars($data["kd_kelas"]);
	$nip = htmlspecialchars($data["nip"]);
	$kd_mapel = htmlspecialchars($data["kd_mapel"]);

	$query = "INSERT INTO jadwal_pelajaran
				VALUES
			  ('$kd_jadwal', '$hari', '$waktu',  '$jmlh_jam','$kd_kelas', '$nip', '$kd_mapel')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function tambahNilaiSiswa($data)
{
	global $conn;
	$nis = htmlspecialchars($data["nis"]);
	$nilai_uts = htmlspecialchars($data["nilai_uts"]);
	$nilai_uas = htmlspecialchars($data["nilai_uas"]);
	$grade = htmlspecialchars($data["grade"]);
	$query = "INSERT INTO nilai_siswa (nis, nilai_uts, nilai_uas, grade) VALUES ('$nis', '$nilai_uts', '$nilai_uas', '$grade')";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


function registrasi($data)
{
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$user_type = htmlspecialchars($data["user_type"]);

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

	if (mysqli_fetch_assoc($result)) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}


	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database

	$query = "INSERT INTO users
				VALUES
			  ('', '$username', '$password',  '$user_type')
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusSiswa($nis)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM siswa WHERE nis = $nis");
	return mysqli_affected_rows($conn);
}
function hapusGuru($nip)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM guru WHERE nip = $nip");
	return mysqli_affected_rows($conn);
}
function hapusJadwal($kd_jadwal)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM jadwal_pelajaran WHERE kd_jadwal = $kd_jadwal");
	return mysqli_affected_rows($conn);
}

function hapusNilaiSiswa($id_nilai)
{
	global $conn;
	$query = "DELETE FROM nilai_siswa WHERE id_nilai = $id_nilai";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function hapusAdmin($id)
{
	global $conn;

	$result = mysqli_query($conn, "SELECT count(*) as total from users");
	$result2 = mysqli_query($conn, "SELECT * from users where id = $id");
	$result3 = mysqli_query($conn, " SELECT count(*) as totalsuperadmin from users where user_type = 'Super Admin'");
	$data = mysqli_fetch_assoc($result);
	$data2 = mysqli_fetch_assoc($result2);
	$data3 = mysqli_fetch_assoc($result3);
	if ($data['total'] > 1) {
		if ($data2['user_type'] == 'Super Admin') {
			if ($data3['totalsuperadmin'] > 1) {
				mysqli_query($conn, "DELETE FROM users WHERE id = $id");
				return mysqli_affected_rows($conn);
			}
		} else {
			mysqli_query($conn, "DELETE FROM users WHERE id = $id");
			return mysqli_affected_rows($conn);
		}
	}
}

function ubahSiswa($data)
{
	global $conn;

	$nis = htmlspecialchars($data["nis"]);
	$nama = htmlspecialchars($data["nama"]);
	$jns_kelamin = htmlspecialchars($data["jns_kelamin"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$kd_kelas = htmlspecialchars($data["kd_kelas"]);

	$query = "UPDATE siswa SET
				nis = '$nis',
				nama = '$nama',
				jns_kelamin = '$jns_kelamin',
				alamat = '$alamat',
				kd_kelas = '$kd_kelas'
			  WHERE nis = $nis
			";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ubahNilaiSiswa($data)
{
	global $conn;

	$id_nilai = htmlspecialchars($data["id_nilai"]);
	$nilai_uts = htmlspecialchars($data["nilai_uts"]);
	$nilai_uas = htmlspecialchars($data["nilai_uas"]);
	$grade = htmlspecialchars($data["grade"]);

	$query = "UPDATE nilai_siswa SET
				nilai_uts = '$nilai_uts',
				nilai_uas = '$nilai_uas',
				grade = '$grade'
			WHERE id_nilai = $id_nilai
		";

	if (mysqli_query($conn, $query)) {
		return mysqli_affected_rows($conn);
	} else {
		// Tampilkan pesan kesalahan jika query tidak berhasil dieksekusi
		echo "Error: " . mysqli_error($conn);
		return -1; // Atau nilai lain yang menandakan terjadinya kesalahan
	}
}

function ubahGuru($data)
{
	global $conn;

	$nip = htmlspecialchars($data["nip"]);
	$nama = htmlspecialchars($data["nama"]);
	$jns_kelamin = htmlspecialchars($data["jns_kelamin"]);
	$tgl_lahir = htmlspecialchars($data["tgl_lahir"]);
	$alamat = htmlspecialchars($data["alamat"]);
	$no_telp = htmlspecialchars($data["no_telp"]);
	$bidang_studi = htmlspecialchars($data["bidang_studi"]);

	$query = "UPDATE guru SET
				nip = '$nip',
				nama = '$nama',
				jns_kelamin = '$jns_kelamin',
				tgl_lahir = '$tgl_lahir',
				alamat = '$alamat',
				no_telp = '$no_telp',
				bidang_studi = '$bidang_studi',
			  WHERE nip = $nip
			";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function ubahJadwal($data)
{
	global $conn;

	$kd_jadwal = htmlspecialchars($data["kd_jadwal"]);
	$hari = htmlspecialchars($data["hari"]);
	$waktu = htmlspecialchars($data["waktu"]);
	$jmlh_jam = htmlspecialchars($data["jmlh_jam"]);
	$kd_kelas = htmlspecialchars($data["kd_kelas"]);
	$nip = htmlspecialchars($data["nip"]);
	$kd_mapel = htmlspecialchars($data["kd_mapel"]);

	$query = "UPDATE jadwal_pelajaran SET
				kd_jadwal = '$kd_jadwal',
				hari = '$hari',
				waktu = '$waktu',
				jmlh_jam = '$jmlh_jam',
				kd_kelas = '$kd_kelas',
				nip = '$nip',
				kd_mapel = '$kd_mapel'
			  WHERE kd_jadwal = $kd_jadwal
			";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function ubahAdmin($data)
{
	global $conn;

	$id = $data["id"];
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$user_type = htmlspecialchars($data["user_type"]);

	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	$query = "UPDATE users SET
				username = '$username',
				password = '$password',
				user_type = '$user_type'
			  WHERE id = $id;
			";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}
