<?php
//koneksi ke database
$conn = mysqli_connect("localhost","root", "","jasajahit");

function query ($query){
    
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;

    }
    return $rows;
}


function tambah($data){

    global $conn;
    $namamodel = htmlspecialchars($data["nama_model"]);
    $kategori = htmlspecialchars($data["id_kategori"]);
    $harga = htmlspecialchars($data["harga"]);
  
   
   
    //upload gambar
    $model = upload();
    if (!$model){
        return false;
    }

    $query = "INSERT INTO katalog
    VALUES
    ('', '$kategori','$model','$namamodel', '$harga')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function upload (){

    $namaFile = $_FILES["model"]["name"];
    $ukuranFile = $_FILES["model"]["size"];
    $error = $_FILES["model"]["error"];
    $tmpName = $_FILES["model"]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if ( $error == 4 ){
        echo "<script>
                alert ('pilih gambar terlebih dahulu');
            </script>
        ";

        return false;

    }


    //cek apakah ekstensi nya gambar atau bukan
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array ($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert ('yang anda upload bukan gambar');
            </script>
        ";

        return false;

    }

    //cek jika ukurannya terlalu besar
    if ( $ukuranFile > 1000000) {
        echo "<script>
                alert ('gambar terlalu besar');
            </script>
            ";

        return false;
    }

    //lolos pengecekan
    //GENERATE NAMA BARU
    $namaFilebaru = uniqid();
    $namaFilebaru .= '.';
    $namaFilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, "img/gambar/" . $namaFilebaru);

        return $namaFilebaru;

}

function daftar($data){
    global $conn;

    $username = strtolower(stripslashes($data['username_pelanggan']));
    $password = mysqli_real_escape_string($conn, $data['password_pelanggan']);
    $namapelanggan = htmlspecialchars($data['nama_pelanggan']);
    $nohp = htmlspecialchars($data['nohp']);
    $alamat = htmlspecialchars($data['alamat']);
    $kodepos = htmlspecialchars($data['kodepos']);

    
    //tambahkan user ke database
    mysqli_query ($conn, "INSERT INTO pelanggan VALUES('','$username', '$password','$namapelanggan','$nohp','$alamat','$kodepos')");

    return mysqli_affected_rows($conn);

    
}

function hapus ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM katalog WHERE id_model = $id");
    return mysqli_affected_rows($conn);
}

function hapusdataorder ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM data_order WHERE id_order = $id");
    return mysqli_affected_rows($conn);
}
function hapusdatakomplain ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM komplain WHERE id_komplain = $id");
    return mysqli_affected_rows($conn);
}
function hapusdatapembayaran ($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM data_pembayaran WHERE id_pembayaran = $id");
    return mysqli_affected_rows($conn);
}

function ubah ($data){
    global $conn;

    $id = $data["id"];
    $namamodel = htmlspecialchars($data["nama_model"]);
    $kategori = htmlspecialchars($data["id_kategori"]);
    $harga = htmlspecialchars($data["harga"]);
    $modellama = htmlspecialchars($data["modellama"]);

    //cek apakah user pilih gambar baru atau tidak
    if ( $_FILES['model']['error'] == 4 ){
        $model = $modellama;
    } else {
        $model = upload();
    }


    $query = "UPDATE katalog SET
                id_kategori = '$kategori',
                model = '$model',
                nama_model = '$namamodel',
                harga = '$harga'
                WHERE id_model = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari ($keyword){

    $query = "SELECT * FROM katalog WHERE
            nama_model LIKE '%$keyword%' OR
            harga LIKE '%$keyword%'
            
    ";
    return query($query);
}


function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    //cek konfirmasi password
    if ( $password !== $password2 ){
        echo "<script>
                alert ('konfirmasi password tidak sesuai')
                </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    //tambahkan user ke database
    mysqli_query ($conn, "INSERT INTO user VALUES('','$username', '$password')");

    return mysqli_affected_rows($conn);

}

function inputukurankemeja ($data){
    global $conn;
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $panjangbadan = htmlspecialchars($data["panjang_badan"]);
    $pundak = htmlspecialchars($data["pundak"]);
    $lebardada = htmlspecialchars($data["lebar_dada"]);
    $lebarbawah = htmlspecialchars($data["lebar_bawah"]);
    $panjanglengan = htmlspecialchars($data["panjang_lengan"]);
    $lingkartanganatas = htmlspecialchars($data["lingkar_tangan_atas"]);
    $lingkarbawahlengan = htmlspecialchars($data["lingkar_bawah_lengan"]);
    $tanggal = date("Y-m-d");

    $query = "INSERT INTO data_ukuran_kemeja
    VALUES
    ('','$id_pelanggan','$panjangbadan','$pundak','$lebardada','$lebarbawah','$panjanglengan','$lingkartanganatas','$lingkarbawahlengan','$tanggal')
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function inputukurancelana($data){
    global $conn;
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $panjang = htmlspecialchars($data["panjang"]);
    $lingkarpinggang = htmlspecialchars($data["lingkarpinggang"]);
    $lingkarpaha = htmlspecialchars($data["lingkarpaha"]);
    $tanggal = date("Y-m-d");

    $query = "INSERT INTO data_ukuran_celana
    VALUES
    ('','$id_pelanggan','$panjang','$lingkarpinggang','$lingkarpaha','$tanggal')
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function inputukurandress($data){
    global $conn;
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $panjangbahu = htmlspecialchars($data["panjang_bahu"]);
    $panjangtangan = htmlspecialchars($data["panjang_tangan"]);
    $lingkartangan = htmlspecialchars($data["lingkar_tangan"]);
    $panjangdress = htmlspecialchars($data["panjang_dress"]);
    $lingkarbadan = htmlspecialchars($data["lingkar_badan"]);
    $tanggal = date("Y-m-d");

    $query = "INSERT INTO data_ukuran_dress
    VALUES
    ('','$id_pelanggan','$panjangbahu','$panjangtangan','$lingkartangan','$panjangdress','$lingkarbadan','$tanggal')
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function inputorder($data){
    global $conn;
    $id_model = $data_desain["id_model"];
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $model = $data_desain["nama_model"];
    $tanggal = date("Y-m-d");
    $harga = $data_desain["harga"];

    $query = "INSERT INTO data_order
    VALUES
    ('','$id_pelanggan','$tanggal')
    ";

    mysql_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function konfirmasi ($data){
    global $conn;

    $id = $data["id"];
    $status = htmlspecialchars($data["status"]);

    $query = "UPDATE data_order SET
                status = '$status'
                WHERE id_order = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function buktibayar($data){

    global $conn;
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $namapelanggan = $_SESSION["pelanggan"]["nama_pelanggan"];
    $keterangan = htmlspecialchars($data["keterangan"]);
  
   
   
    //upload gambar
    $bukti = uploadbukti();
    if (!$bukti){
        return false;
    }

    $query = "INSERT INTO data_pembayaran
    VALUES
    ('', '$id_pelanggan','$namapelanggan','$bukti','$keterangan')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function uploadbukti (){

    $namaFile = $_FILES["model"]["name"];
    $ukuranFile = $_FILES["model"]["size"];
    $error = $_FILES["model"]["error"];
    $tmpName = $_FILES["model"]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if ( $error == 4 ){
        echo "<script>
                alert ('pilih gambar terlebih dahulu');
            </script>
        ";

        return false;

    }


    //cek apakah ekstensi nya gambar atau bukan
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array ($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert ('yang anda upload bukan gambar');
            </script>
        ";

        return false;

    }

    //cek jika ukurannya terlalu besar
    if ( $ukuranFile > 3000000) {
        echo "<script>
                alert ('gambar terlalu besar');
            </script>
            ";

        return false;
    }

    //lolos pengecekan
    //GENERATE NAMA BARU
    $namaFilebaru = uniqid();
    $namaFilebaru .= '.';
    $namaFilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, "img/bukti/" . $namaFilebaru);

        return $namaFilebaru;

}

function inputnoresi($data){
    global $conn;
    $id_pelanggan = $_GET["id"];
    $noresi = htmlspecialchars($data["no_resi"]);
    $tanggal = date("Y-m-d");

    $query = "INSERT INTO data_noresi
    VALUES
    ('','$id_pelanggan','$noresi','$tanggal')
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function komplain($data){

    global $conn;
    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $namapelanggan = $_SESSION["pelanggan"]["nama_pelanggan"];
    $keterangan = htmlspecialchars($data["keterangan"]);
  
   
   
    //upload gambar
    $bukti = uploadkomplain();
    if (!$bukti){
        return false;
    }

    $query = "INSERT INTO komplain
    VALUES
    ('', '$id_pelanggan','$namapelanggan','$bukti','$keterangan')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}

function uploadkomplain (){

    $namaFile = $_FILES["komplain"]["name"];
    $ukuranFile = $_FILES["komplain"]["size"];
    $error = $_FILES["komplain"]["error"];
    $tmpName = $_FILES["komplain"]["tmp_name"];

    //cek apakah tidak ada gambar yg diupload
    if ( $error == 4 ){
        echo "<script>
                alert ('pilih gambar terlebih dahulu');
            </script>
        ";

        return false;

    }


    //cek apakah ekstensi nya gambar atau bukan
    $ekstensiGambarValid = ["jpg", "jpeg", "png"];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if( !in_array ($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert ('yang anda upload bukan gambar');
            </script>
        ";

        return false;

    }

    //cek jika ukurannya terlalu besar
    if ( $ukuranFile > 1000000) {
        echo "<script>
                alert ('gambar terlalu besar');
            </script>
            ";

        return false;
    }

    //lolos pengecekan
    //GENERATE NAMA BARU
    $namaFilebaru = uniqid();
    $namaFilebaru .= '.';
    $namaFilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, "img/komplain/" . $namaFilebaru);

        return $namaFilebaru;

}

?>