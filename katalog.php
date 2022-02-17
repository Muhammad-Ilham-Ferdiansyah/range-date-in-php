<?php

session_start();

if( !isset ($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'functions.php';
$katalog = query("SELECT * FROM katalog");

//tombol cari ditekan

 if ( isset($_POST["cari"])) {
    $katalog = cari($_POST["keyword"]);
}


?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="img/mrgodek.png">
    <title>Penjahit | Dashboard</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-warning fixed-top">
      <div class="container">
      <a class="navbar-brand font-weight-bold" href="#">Mr. Godek Tailor</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mr-4">
            <li class="nav-item active">
              <a class="nav-link" href="halaman_penjahit.php">Beranda <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Kontak <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Tentang <span class="sr-only">(current)</span></a>
            </li>
          <form class="form-inline my-2 my-lg-0" action="" method="post">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="keyword">
              <button class="btn btn-outline-info my-2 my-sm-0" type="submit" name="cari">Search</button>
          </form>
          <li class="navbar-nav ml-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </li>
        </ul>
        </div>
      </div>
      </nav>
      <div class="row mt-5 no-gutters">
        <div class="col-md-2 bg-dark">
          <ul class="list-group list-group-flush p-2 mt-4">
            <li class="list-group-item bg-warning">HALAMAN PENJAHIT</li>
            <li class="list-group-item" ><a href="kelolaorder.php">Kelola Data Orderan</a></li>
            <li class="list-group-item" ><a href="katalog.php">Kelola Katalog</a></li>
            <li class="list-group-item" ><a href="kelolakomplain.php">Kelola Komplain</a></li>
            <li class="list-group-item" ><a href="kelolalaporan.php">Kelola Laporan</a></li>
          </ul>
          </div>

    <div class="col-md-10 mt-2 mx-auto">
        <a href="tambah.php" class="btn btn-info ml-2 mt-4">Tambah Katalog</a>
    <div class="container">
            <div class="card-group">
            <?php $i=1; ?>
            <?php foreach( $katalog as $row) : ?>
            <div class="row">
            <div class="col-sm-2">
              <div class="card m-2" style="width: 12rem;">
              <img src="img/gambar/<?= $row['model']; ?> " class="card-img-top" alt="model">
              <div class="card-body bg-light">
              <h5 class="card-title"><?= $row['nama_model']; ?></h5>
              <h5 class="card-title">Rp. <?=number_format($row['harga']) ?></h5>
              <a href="ubah.php?id=<?= $row["id_model"]; ?>" class="btn btn-primary">Edit</a>
              <a href="hapus.php?id=<?= $row["id_model"]; ?>" onclick="
                return confirm('Yakin?');" class="btn btn-danger">Hapus</a>
            </div>
          </div>
          </div>
          </div>
          <?php $i++; ?>
        <?php endforeach; ?>
          </div>
          </div>
          </div>
          </div>
          <!-- footer -->

<footer class="page-footer bg-secondary mt-5">
  <div class="bg-warning">
      <div class="container">
              <div class="row py-4 d-flex align-items-center">
                  <div class="col-md-12 text-center">
                  &copy; Mr. Godek 2021
                  </div>
              </div>
      </div>
  </div>

  <div class="container text-center text-md-left mt-5 text-light">
      <div class="row">
              <div class="col-md-3 mx-auto mb-4">
                <h6 class="text-uppercase font-weight-bold">Lokasi</h6>
                <hr class="bg-warning mb-4 d-inline-block mx-auto" style="width:125px; height:2px;">
                <p class="mt-2">Jalan Takraw Timur Langkat, Binjai Sumatera Utara</p>
              </div>

              <div class="col-md-2 mx-auto mb-4">
              <h6 class="text-uppercase font-weight-bold">Model</h6>
                <hr class="bg-warning mb-4 d-inline-block mx-auto" style="width:85px; height:2px;">
                <ul class="list-unstyled">
                  <li class="my-2">Kemeja Pendek</li>
                  <li class="my-2">Kemeja Panjang</li>
                  <li class="my-2">Celana Pendek</li>
                  <li class="my-2">Celana Panjang</li>
                  <li class="my-2">Dress Pendek</li>
                  <li class="my-2">Dress Panjang</li>
                </ul>
              </div>

              <div class="col-md-2 mx-auto mb-4">
              <h6 class="text-uppercase font-weight-bold">Powered by</h6>
              <hr class="bg-warning mb-4 d-inline-block mx-auto" style="width:85px; height:2px;">
              <ul class="list-unstyled">
                  <li class="my-2">Butterfly</li>
                  <li class="my-2">JITU</li>
                  <li class="my-2">JUKI</li>
                </ul>
              </div>
      </div>
  </div>


</footer>

</body>
</html>