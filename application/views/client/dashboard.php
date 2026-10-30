<?php $no_rekening = $this->session->userdata('username'); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Sistem Investasi</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card card-primary">
                        <h4 class="card-header" style="color: black;"><?= $no_rekening ?></h4>
                        <div class="card-body">
                            <table style="color: black;" width=100%; id="profile_table" name="profile_table">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    $(document).ready(function() {
        var no_rekening = '<?= $this->session->userdata('username'); ?>';
        var path = 'clientId/'+ no_rekening;;

        $.ajax({
            type: 'POST',
            url: '<?= base_url('curl/getRequest') ?>',
            data:'path=' + path,
            success: function(response) {
                var data = JSON.parse(response);
                var profile = '';
                
                $.each(data, function(i, item) {
                    console.log(item.nik);
                    profile += '<tr>' +
                        '<td style = "width: 10%;"> NIK </td>' +
                        '<td>: </td>' +
                        '<td>' + item.nik + '</td>' +
                        '</tr><tr>' +
                        '<td> Nama </td>' +
                        '<td>: </td>' +
                        '<td>' + item.nama + '</td>' +
                        '</tr><tr>' +
                        '<td> Tgl. Lahir </td>' +
                        '<td>: </td>' +
                        '<td>' + item.tgl_lahir + '</td>' +
                        '</tr><tr>' +
                        '<td> Alamat </td>' +
                        '<td>: </td>' +
                        '<td>' + item.alamat + '</td>' +
                        '</tr><tr>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td>' + item.kec_kab + '</td>' +
                        '</tr><tr>' +
                        '<td>Tgl. Terdaftar</td>' +
                        '<td>: </td>' +
                        '<td>' + item.tgl_daftar + '</td>' +
                        '</tr>';
                });

                $('#profile_table').html(profile);
            }
        });
    });
</script>