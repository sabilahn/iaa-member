<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Surat Saham</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Surat Saham</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Data Transaksi</h2>
                <h4></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1" width=100%>
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tgl. Transaksi</th>
                                <th>No. Sertifikat</th>
                                <th>Jml. Transaksi (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div id="detail"></div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        
        $('#detail').hide();
        
        var no_rekening = '<?= $this->session->userdata('username'); ?>';
        var path = 'transaksiId/' + no_rekening;

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
                    "data": "tgl_transaksi",
                    "class": "text-center"
                },
                {
                    "data": "no_sertifikat",
                    "class": "text-center"
                },
                {
                    "data": "jml_transaksi",
                    "class": "text-right"
                },
                {
                    "data": "no_sertifikat",
                    "render": function(data, type, row) {
                        var substr = row.no_sertifikat.substring(4, 8);

                        if (substr == '0101') {
                            var html = '<div class="text-center"><p>Dokumen tidak dapat dicetak</p></div>';
                        } else {
                            var html = '<div class="text-center"><button class="btn btn-sm btn-info" onClick=cetak_surat_saham(' + row.no_sertifikat + ');><i class="fa fa-print"></i></button>' +
                                '</div>';
                            // var html = '<div class="text-center"><button class="btn btn-sm btn-info" onClick=get_data(' + row.no_sertifikat + ');><i class="fa fa-print"></i></button>' +
                            //     '</div>';
                        }
                        return html
                    }
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

    function cetak_surat_saham(no_sertifikat){
        window.open("<?= site_url('Copy_of_surat_saham/surat_saham?no_sertifikat="+ no_sertifikat +"') ?>", "_blank");
    }
</script>