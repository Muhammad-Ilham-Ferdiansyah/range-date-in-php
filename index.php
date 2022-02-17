<?php
include "functions.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Range Tanggal</title>
</head>

<body>

    <div class="container text-center mt-5">
        <h1>Menampilkan Data Berdasarkan Range Tanggal</h1>
        <form method="POST">
            <table class="table">
                <tr>
                    <td>From</td>
                    <td><input class="form-control" type="date" name="dari_tgl"></td>
                    <td>To</td>
                    <td><input class="form-control" type="date" name="sampai_tgl"></td>
                    <td><input type="submit" name="cari" value="Search" class="btn btn-primary"></td>
                    <td><input type="submit" name="reset" value="Refresh" class="btn btn-success"></td>
                </tr>
            </table>
        </form>
        <?php if (empty($_POST)) {
        ?>
            <div class="alert alert-success" role="alert">
                Silakan masukkan range tanggal yang akan di cari
            </div>
        <?php } else { ?>
            <div class="alert alert-success" role="alert">
            <?php if (isset($_POST['cari'])) {
                $dari_tanggal = mysqli_real_escape_string($conn, $_POST['dari_tgl']);
                $sampai_tanggal = mysqli_real_escape_string($conn, $_POST['sampai_tgl']);
                echo "Dari tanggal " . $dari_tanggal . " sampai tanggal " . $sampai_tanggal;
            }
        } ?>
            </div>
    </div>
    <div class="p-5">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Desain</th>
                    <th scope="col">Ukuran</th>
                    <th scope="col">Tanggal Transaksi</th>
                </tr>
            </thead>
            <?php
            $no = 1;
            if (isset($_POST['cari'])) {
                $dari_tanggal = mysqli_real_escape_string($conn, $_POST['dari_tgl']);
                $sampai_tanggal = mysqli_real_escape_string($conn, $_POST['sampai_tgl']);
                $dataQuery = query("SELECT * FROM data_orderan WHERE tanggal_order BETWEEN '$dari_tanggal' AND '$sampai_tanggal'");
            } else if (isset($_POST['reset'])) {
                $dataQuery = query("SELECT * FROM data_orderan");
            } else {
                $dataQuery = query("SELECT * FROM data_orderan");
            }
            ?>
            <?php foreach ($dataQuery as $orderan) : ?>
                <?php $format = date_create($orderan["tanggal_order"]); ?>
                <tbody>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $orderan["desain"]; ?></td>
                        <td><?= $orderan["ukuran"]; ?></td>
                        <td><?= date_format($format, 'd F Y'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
    </div>

</body>

</html>