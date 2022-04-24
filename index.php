<?php

/**
 * Created By Raditya Firman Syaputra
 * On 23/04/2022
 */

require_once('./assets/php/function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Project UTS</title>

    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
</head>

<body>
    <div class="container-md">
        <div class="form-container">
            <div class="row">
                <div class="col-lg-5 my-auto">
                    <div class="left mx-auto">
                        <img src="./assets/img/animation.svg" alt="" />
                    </div>
                    <div class="right">
                        <h4>Kalkulator Simulasi Pengajuan Kredit</h4>
                        <p>
                            Silahkan masukkan data-data berikut untuk memulai simulasi
                            pengajuan kredit
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 my-auto">
                    <h2 class="mt-3" style="margin-left: 20px">Formulir Simulasi</h2>
                    <form action="index.php" method="POST" class="mt-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Jumlah Pinjaman</label>
                                    <input type="number" name="totalPinjaman" value="<?= (isset($_POST["totalPinjaman"])) ? $_POST["totalPinjaman"] : "" ?>" min="100000000" placeholder="Min 100,000,000" required class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Uang Muka</label>

                                    <div class="input-group">
                                        <input type="number" name="uangMuka" value="<?= (isset($_POST["uangMuka"])) ? $_POST["uangMuka"] : "" ?>" required class="form-control" placeholder="Min 30%" min="30" max="100" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Jangka Waktu</label>
                                    <select name="tenor" class="form-control">
                                        <?php
                                        for ($i = 1; $i <= 15; $i++) {
                                            if (isset($_POST["tenor"])) {
                                                if ($_POST["tenor"] == $i) {
                                                    echo "<option value='$i' selected>$i Tahun</option>";
                                                } else {
                                                    echo "<option value='$i'>$i Tahun</option>";
                                                }
                                            } else {
                                                echo '<option value="' . $i . '">' . $i . ' Tahun</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Bunga</label>

                                    <div class="input-group">
                                        <input name="bunga" type="number" value="<?= (isset($_POST["bunga"])) ? $_POST["bunga"] : "5" ?>" required class="form-control" min="5" max="10" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end" style="margin-right: 20px; margin-top: 50px">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST["totalPinjaman"]) && isset($_POST["uangMuka"]) && isset($_POST["tenor"]) && isset($_POST["bunga"])) {
            $totalPinjaman = $_POST["totalPinjaman"];
            $uangMuka = $_POST["uangMuka"];
            $tenor = $_POST["tenor"];
            $bunga = $_POST["bunga"];

            $data = new AngsuranFlat($totalPinjaman, $uangMuka, $tenor, $bunga);
        ?>
            <div class="row">
                <div class="col-lg-12">

                    <table class="table mt-5">
                        <thead class="table-light">
                            <tr>
                                <th colspan="3">
                                    Data Kredit
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 40%;">Total Pinjaman</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($data->totalPinjaman + $data->uangMuka, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Uang Muka</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($data->uangMuka, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Jangka Waktu</td>
                                <td>:</td>
                                <td><?= $data->jangkaWaktu / 12 . " tahun" ?></td>
                            </tr>
                            <tr>
                                <td>Margin Bank</td>
                                <td>:</td>
                                <td><?= $data->bunga * 100 . "% / tahun"  ?></td>
                            </tr>
                            <tr>
                                <td>Perhitungan Margin</td>
                                <td>:</td>
                                <td><b>Flat</b></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table mt-5">
                        <thead class="table-light">
                            <tr>
                                <th colspan="3">
                                    Perhitungan Pinjaman
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width: 40%;">Plafon Pinjaman</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($data->totalPinjaman, 2) ?></td>
                            </tr>
                            <tr>
                                <td>Angsuran per Bulan</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($data->angsuranPerbulan()["total"], 2) ?></td>
                            </tr>

                            <tr>
                                <td>Jangka Waktu</td>
                                <td>:</td>
                                <td><?= $data->jangkaWaktu . " bulan" ?></td>
                            </tr>


                            <tr>
                                <td>Bunga</td>
                                <td>:</td>
                                <td><?= round($data->bunga * 100 / 12, 2) . "% / bulan" ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table mt-5">
                        <thead class="table-light">
                            <tr>
                                <th colspan="3">
                                    Penghasilan Minimum
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $penghasilanMinimum = $data->penghasilanMinimum();
                            foreach ($penghasilanMinimum as $key => $value) {
                            ?>
                                <tr>
                                    <td style="width: 40%;"><?= $value["key"] ?></td>
                                    <td>:</td>
                                    <td>Rp. <?= number_format($value["value"], 2) ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>

                    </table>

                    <div class="table-responsive mt-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-light">
                                    <th colspan="5">Tabel Angsuran</th>
                                </tr>
                                <tr>
                                    <th scope="col">Bulan</th>
                                    <th scope="col">Bunga</th>
                                    <th scope="col">Pokok</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $angsuran = $data->detailAngsuran();
                                for ($i = 0; $i < count($angsuran) - 1; $i++) {
                                ?>
                                    <tr>
                                        <td><?= $angsuran[$i]["bulan"] ?></td>
                                        <td><?= number_format($angsuran[$i]["bunga"], 2, ',', '.') ?></td>
                                        <td><?= number_format($angsuran[$i]["pokok"], 2, ',', '.') ?></td>
                                        <td><?= number_format($angsuran[$i]["total"], 2, ',', '.') ?></td>
                                        <td><?= number_format($angsuran[$i]["sisa"], 2, ',', '.') ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        <?= number_format($angsuran[count($angsuran) - 1]["bunga"], 2, ',', '.') ?>
                                    </th>
                                    <th>
                                        <?= number_format($angsuran[count($angsuran) - 1]["pokok"], 2, ',', '.') ?>
                                    </th>
                                    <th colspan="2">
                                        <?= number_format($angsuran[count($angsuran) - 1]["total"], 2, ',', '.') ?>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
    </div>
</body>

</html>