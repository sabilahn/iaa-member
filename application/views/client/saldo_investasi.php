<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Saldo Investasi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Saldo</div>
                <div class="breadcrumb-item">Investasi</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Investasi</h2>
                <h4></h4>
            </div>
            <!-- <div class="form-group"> -->
            <div class="row" style="margin-left: 3%;">
                <label for="tahun">Tahun</label>
                <select class="custom-select col-sm-1" style="margin-left: 2%;width:auto;" id="tahun">
                    <?php
                    for ($i = date('Y'); $i >= date('Y') - 2; $i -= 1) {
                        echo "<option value='$i'> $i </option>";
                    }
                    ?>
                </select>
            </div>
            <!-- </div> -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1" width=100%>
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Nomor Rekening</th>
                                <th>Transaksi Investasi (Rp)</th>
                                <th>Penarikan Investasi (Rp)</th>
                                <th>Saldo Investasi (Rp)</th>
                                <th style="width: 20%;">Ket.</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        var no_rekening = '<?= $this->session->userdata('username'); ?>';
        
        var tahun = <?= date('Y') ?>;

        show_data(no_rekening, tahun);

        document.getElementById("tahun").onchange = function() {
            tahun = $('#tahun').val();
            show_data(no_rekening, tahun);
        };
    });

    function show_data(no_rekening, tahun) {
        var path = 'saldoInvestasi/' + no_rekening + '/' + tahun;

        var t = $('#table-1').DataTable({
            destroy: true,
            "ajax": {
                "type" : 'POST',    
                "dataType" : 'json',
                "url": '<?= base_url('curl/getRequest') ?>',
                "data": {
                    path:path
                },
                "dataSrc": ""
            },
            "columns": [{
                    "data": null,
                    "class": "text-center"
                },
                {
                    "data": "tanggal",
                    "class": "text-center"
                },
                {
                    "data": "jml_transaksi",
                    "class": "text-right"   
                },
                {
                    "data": "jml_penarikan",
                    "class": "text-right"
                },
                {
                    "data": "saldo",
                    "class": "text-right"
                },
                {
                    "data": "ket",
                    "class": "text-center"
                }
            ]
        });

        t.on('order.dt search.dt', function() {
            t.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    }
</script>