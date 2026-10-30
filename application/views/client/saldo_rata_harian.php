<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Saldo Rata-rata Harian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Saldo</div>
                <div class="breadcrumb-item">Rata-rata Harian</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Rata-rata Harian</h2>
                <h4></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1" width=100%>
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tahun</th>
                                <th>Nilai Investasi (Rp)</th>
                                <th>Total Rata-rata Harian (Rp)</th>
                                <th>Total Rata-rata/Tahun (Rp)</th>
                            </tr>
                        </thead>
                        <tbody id="saldo_table">

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
        var path = 'saldoHarianId/' + no_rekening;

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
                    "data": "tahun",
                    "class": "text-center"
                },
                {
                    "data": "nilai_investasi",
                    "class": "text-right"
                },
                {
                    "data": "nilai_rata_harian",
                    "class": "text-right"
                },
                {
                    "data": "nilai_rata_tahun",
                    "class": "text-right"
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

    });

    // const rupiah = (number) => {
    //     return new Intl.NumberFormat("id-ID", {
    //         style: "currency",
    //         currency: "IDR"
    //     }).format(number);
    // }
</script>