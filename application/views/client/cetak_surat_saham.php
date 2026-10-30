<?php
// URL of the image you want to load
$imageUrl = base_url('assets/stisla/images/iaa.png');
$imageUrl2 = base_url('assets/stisla/images/bg.png');
$imageUrl3 = 'https://investment.dharma-iaa.com/assets/stisla/images/qrcode/surat_saham/'. $data_transaksi['no_sertifikat'] . '.png';

// Initialize cURL session
$ch = curl_init($imageUrl);
$ch2 = curl_init($imageUrl2);
$ch3 = curl_init($imageUrl3);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session and fetch the image data
$imageData = curl_exec($ch);
$imageData2 = curl_exec($ch2);
$imageData3 = curl_exec($ch3);

$base64Image = base64_encode($imageData);
$base64 = 'data:image/png'. ';base64,' . $base64Image;

$base64Image2 = base64_encode($imageData2);
$base642 = 'data:image/png'. ';base64,' . $base64Image2;

$base64Image3 = base64_encode($imageData3);
$base64qr = 'data:image/png'. ';base64,' . $base64Image3;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/stisla/vendors/fontawesome/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        td {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 20px;
            height: 25px;
        }

        .bg {
            overflow: hidden;
            height: auto;
            position: relative;
        }

        .btn {
            border: none;
            border-radius: 5px;
            color: black;
            background-color: #eeeeef;
            text-align: center;
            font-size: 15px;
            margin: 4px 2px;
            opacity: 0.8;
            transition: 0.3s;
            /* display: inline-block; */
            text-decoration: none;
            cursor: pointer;

            width: 100px;
            height: 30px;
            padding-top: 12px;
            margin-left: 10px;
            margin-top: 530px;
            position: relative;
        }

        .btn:hover {
            opacity: 1
        }

        .box {
            width: 760;
            height: 389;
            position: absolute;
            background-image: url('<?= $base642 ?>');
            background-size: cover;
        }

        .sisi-1 {
            /* position: absolute; */
            text-align: center;
            padding: 55px;
            margin-top: 240px;
        }

        .sisi-2 {
            width: 580px;
            margin-left: 350px;
            height: 360px;
            position: absolute;
            display: table;
            text-align: center;
            padding: 20px;
        }

        .logo-title {
            /* display: table-cell; */
            vertical-align: middle;
            margin: auto;
        }

        .isi {
            /* display: table-cell; */
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }

        .title {
            font-size: 20px;
            padding: 5px;
            color: rgb(0, 155, 76);
        }

        .wrap {
            /* display: table-cell; */
            vertical-align: middle;
            margin-left: -695px;
            margin-top: 10px;
            padding: 20px;
        }

        .table-font {
            font-size: 14px;
        }

        .no-surat {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .titik2 {
            width: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="print">
        <div class="box">
            <div class="sisi-1">
                <div class="logo-title">
                    <div class="wrap">
                        <p class="no-surat">No. <?= $data_transaksi['no_sertifikat'] ?></p>
                    </div>
                </div>
            </div>
            <div class="sisi-2">
                <div class="isi text-left"><br>
                    <h3>Salinan Surat Saham ini diberikan kepada:</h3>
                    <br>
                    <div style="margin-top: 3px; margin-bottom: 7px;">
                        <table>
                            <tr>
                                <td>No. Anggota</td>
                                <td class="titik2">:</td>
                                <td class="noid"><?= $data_transaksi['no_rekening'] ?></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td class="titik2">:</td>
                                <td class="name"><?= $data_transaksi['nik'] ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td class="titik2">:</td>
                                <td class="name"><?= ucwords($data_transaksi['nama']) ?></td>
                            </tr>
                            <tr>
                                <td>Tempat & Tanggal Lahir</td>
                                <td class="titik2">:</td>
                                <td class="ttl"><?= ucwords($data_transaksi['tgl_lahir'])  ?></td>

                            </tr>
                        </table>
                    </div>
                    <div style="margin-top: -8px; margin-bottom: 7px;">
                        <table>
                            <tr>
                                <td>Tanggal Transaksi</td>
                                <td class="titik2" style="padding-left: 50px;">:</td>
                                <td class="date"><?= $data_transaksi['tgl_transaksi'] ?></td>
                            </tr>
                            <tr>
                                <td>Nilai Investasi</td>
                                <td class="titik2" style="padding-left: 50px;">:</td>
                                <td class="value" style="font-size: 25px;"><b><?= 'Rp. ' . $data_transaksi['jml_transaksi'] ?><b></td>
                            </tr>
                        </table>
                    </div>
                    <div style="margin-top: 10px;">
                        <br>
                        <p><?= 'Sumenep, ' . date('d-m-Y'); ?></p>
                        <p>CV. DHARMA IAA</p>
                        <p><b>Direktur,</b></p>
                        <img src="<?= $base64qr ?>" style="width:15%; margin-top: 5px;">
                        <h4>A. KURDY KHAN</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>