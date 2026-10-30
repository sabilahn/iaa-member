<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dividen</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Dividen Persero</div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Dividen Persero</h2>
                <h4></h4>
            </div>
            <div class="card-body">
                <div id="error-message"></div>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1" width=100%>
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>Tahun</th>
                                <th>Saham Persero (Rp)</th>
                                <th>Sisa Hasil Usaha (Rp)</th>
                                <th>Dividen (Rp)</th>
                                <th>Aksi</th>
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

<!-- Update -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Investasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary">
                    <br>
                    <p>Yakin untuk menambahkan transaksi ?</p>
                    <div class="modal-footer" id="addBtn">
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button> -->
                        <!-- <button class="btn btn-primary">Perbarui</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var no_rekening = '<?= $this->session->userdata('username'); ?>';
        var path = 'devidenId/' + no_rekening;

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
                    "data": "saham_persero",
                    "class": "text-right"
                },
                {
                    "data": "shu",
                    "class": "text-right"
                },
                {
                    "data": "bagi_hasil",
                    "class": "text-right"
                },
                {
                    "data": "tahun",
                    "render": function(data, type, row) {
                        // var html = '';
                        var  html = '<div class="text-center"><button class="btn btn-sm btn-info"disabled><i class="fa fa-arrow-right"></i></button>' +
                                '</div>';

                        // if (row.tahun < <?= date('Y') - 1 ?>) {
                        //     html = '<div class="text-center"><button class="btn btn-sm btn-info"disabled><i class="fa fa-arrow-right"></i></button>' +
                        //         '</div>';
                        // } else {
                        //     html = '<div class="text-center"><button class="btn btn-sm btn-info" onClick=add(' + row.tahun + ',' + row.bagi_hasil + ');><i class="fa fa-arrow-right"></i></button>' +
                        //         '</div>';
                        // }
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

    function add(tahun, bagi_hasil) {
        var deviden = Math.round(bagi_hasil)

        // console.log(deviden);
        var rowBtn = '<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>' +
            '<button onclick="add_transaksi(' + tahun + ',' + deviden + ')" class="btn btn-primary">Tambah</button>';
        $('#addBtn').html(rowBtn);
        $('#addModal').modal('show');

    }

    function add_transaksi(tahun, deviden) {
        $.ajax({
            type: 'POST',
            data: 'tahun=' + tahun + '&deviden=' + deviden,
            url: '<?= base_url() ?>deviden/tambah_transaksi',
            dataType: 'json',
            success: function(data) {
                $('#addModal').modal('hide');

                var html = '<div class="alert alert-success alert-dismissible show fade">' +
                    '<div class="alert-body text-center">' +
                    '<button class="close" data-dismiss="alert">' +
                    '<span>&times;</span></button>' +
                    '<b>Sukses! Data berhasil disimpan</b></div></div>'

                $('#error-message').html(html);

            }
        });

    }
</script>