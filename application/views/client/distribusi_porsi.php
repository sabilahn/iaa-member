<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Distribusi dan Porsi SHU</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= site_url() ?>dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Distribusi dan Porsi SHU</div>
            </div>
        </div>
        <!-- <div class="card card-primary">
            <div class="card-body">
                <div class="form-group col-md-4 col-lg-4">
                    <label>Tahun</label>
                    <div class="input-group">
                        <select class="custom-select" id="tahun" name="tahun">
                            <option value="">--Pilih Tahun--</option>
                            <?php
                            $thn_skr = date('Y');
                            for ($x = $thn_skr; $x >= $thn_skr - 5; $x--) {
                            ?>
                                <option value="<?= $x ?>"><?= $x ?></option>
                            <?php
                            } ?>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" onclick="get_data()">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card card-primary">
            <div class="card-header">
                <h2 class="section-title">Daftar Distribusi</h2>
                <h4></h4>
            </div>
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
            <div class="card">
                <div class="card-body"> 
                    <div class="table-responsive">
                        <table class="table table-striped" id="dispenList">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10%;">No.</th>
                                    <th style="width: 25%;">Porsi (Rp)</th>
                                    <th style="width: 25%;">Uraian</th>
                                    <th style="width: 20%;">SHU (Rp)</th>
                                    <th style="width: 20%;">Jumlah (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="disdaList">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 10%;">No.</th>
                                    <th style="width: 25%;">Porsi (Rp)</th>
                                    <th style="width: 25%;">Uraian</th>
                                    <th style="width: 20%;">Menejemen (Rp)</th>
                                    <th style="width: 20%;">Jumlah (Rp)</th>
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
    var tahun = '';
    $(document).ready(function() {
        // document.getElementById('tahun').value = new Date().getFullYear();
        var tahun = <?= date('Y') ?>;

        show_data_dispen(tahun);
        show_data_disda(tahun);

        document.getElementById("tahun").onchange = function() {
            tahun = $('#tahun').val();
            show_data_dispen(tahun);
            show_data_disda(tahun);
        };
    });

    function show_data_dispen(tahun) {
        var path = 'dispen/' + tahun;

        $('#dispenList').DataTable({
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
                    "className": "text-center",
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "porsi",
                    "className": "text-center"
                },
                {
                    "data": "uraian"
                },
                {
                    "data": "nilai",
                    "className": "text-right"
                },
                {
                    "data": "jumlah",
                    "className": "text-right"
                }
            ]
        });
    }
    function show_data_disda(tahun) {
        var path = 'disda/' + tahun;

        $('#disdaList').DataTable({
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
                    "className": "text-center",
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "porsi",
                    "className": "text-center"
                },
                {
                    "data": "uraian"
                },
                {
                    "data": "nilai",
                    "className": "text-right",
                    "render": $.fn.dataTable.render.number('.', ',', 2),
                },
                {
                    "data": "jumlah",
                    "className": "text-right",
                    "render": $.fn.dataTable.render.number('.', ',', 2),
                }
            ]
        });
    }

    function get_data(){
        tahun = $('#tahun').val();

        show_data_dispen(tahun);
        show_data_disda(tahun);        
    }

</script>