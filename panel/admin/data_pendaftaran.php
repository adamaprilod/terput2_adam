<?php include "header.php";
if ($_SESSION['hak_akses'] != 'admin') {
    echo "
    <script>
        alert('Tidak Memiliki Akses, DILARANG MASUK!');
        document.location.href='index.php';
    </script>
    ";
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<body id="page-top">
    <div class="container">
        <div class="x_title">
            <h2>Data <small>Jurusan</small></h2>
    </div>
    <div class="text-muted font-12 m-b-30 mb-2">
        <a href="form_pendaftaran.php" type="button" class="btn btn-round btn-primary ml-2"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</a>
    </div>
    
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Detail</th>
                <th>Update</th>
                <th>Delete</th>
                <th>Cetak</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include 'conn.php';
            $no = 1;
            if ($status == 'admin') {
                $query = "SELECT pendaftaran.nis,pendaftaran.nama_siswa,pendaftaran.alamat,pendaftaran.jenis_kelamin,pendaftaran.tempat_lahir,pendaftaran.tgl_lahir,pendaftaran.status,kewarganegaraan.id_negara,kewarganegaraan.nama_negara,agama.id_agama,agama.nama_agama,jurusan.id_jurusan, CONCAT(jenjang.nama_jenjang,' ',jurusan.nama_jurusan) as kelas, pendaftaran.tgl_input,pendaftaran.user_input,pendaftaran.tgl_update,pendaftaran.user_update,CONCAT(user.hak_akses,' (',user.nama,')') as akses FROM pendaftaran INNER JOIN kewarganegaraan ON pendaftaran.id_negara = kewarganegaraan.id_negara JOIN user ON pendaftaran.id_user = user.id_user JOIN agama ON pendaftaran.id_agama = agama.id_agama JOIN jurusan ON pendaftaran.id_jurusan = jurusan.id_jurusan JOIN jenjang ON jurusan.id_jenjang = jenjang.id_jenjang";
            } else {
                $query = "SELECT pendaftaran.nis,pendaftaran.nama_siswa,pendaftaran.alamat,pendaftaran.jenis_kelamin,pendaftaran.tempat_lahir,pendaftaran.tgl_lahir,pendaftaran.status,kewarganegaraan.id_negara,kewarganegaraan.nama_negara,agama.id_agama,agama.nama_agama,jurusan.id_jurusan, CONCAT(jenjang.nama_jenjang,' ',jurusan.nama_jurusan) as kelas, pendaftaran.tgl_input,pendaftaran.user_input,pendaftaran.tgl_update,pendaftaran.user_update,CONCAT(user.hak_akses,' (',user.nama,')') as akses FROM pendaftaran INNER JOIN kewarganegaraan ON pendaftaran.id_negara = kewarganegaraan.id_negara JOIN user ON pendaftaran.id_user = user.id_user JOIN agama ON pendaftaran.id_agama = agama.id_agama JOIN jurusan ON pendaftaran.id_jurusan = jurusan.id_jurusan JOIN jenjang ON jurusan.id_jenjang = jenjang.id_jenjang WHERE user.hak_akses = '$status' AND user.id_user='$_SESSION[id_user];'";
            }
            // var_dump($query);
            // exit;
            $sql = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_assoc($sql)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nis']; ?></td>
                    <td><?= $data['nama_siswa']; ?></td>
                    <td><?= $data['kelas']; ?></td>
                    <td><?= $data['alamat']; ?></td>
                    <td><?= $data['jenis_kelamin']; ?></td>
                    <!-- <td align="center"><a class="btn btn-primary" type="button" name="view" value="View" data-id="<?php echo $data["nis"]; ?>" class="btn btn-info btn-xs view_data"><i class="fa fa-bars"></i></a></td> -->
                    <td><a data-toggle="modal" data-target="#detailDaftar" data-id="<?= $data['nis']; ?>" type="submit" class="btn btn-warning btn-sm Detai_Pendaftaran">view</a></td>
                    <td align="center"><a class="btn btn-primary btn-sm" type="button" href="edit_pendaftaran.php?nis=<?= $data['nis']; ?>"><i class="fas fa-pen-square" style="color: #ffffff;"></i></a></td>
                    <td align="center"><a class="btn btn-danger btn-sm" type="button" onclick="return confirm('Data akan di Hapus?')" href="hapus_pendaftaran.php?nis=<?= $data['nis']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                    <td> <a href="cetak_surat/surat.php?nis=<?= $data['nis']; ?>" target="_blank" type="button" name="cetak" class="btn btn-success btn-sm text-white" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i></a></td>
                </tr>
        <?php
        }
        ?>
        </tbody>
    </table><br><br><br>
    </div>
    <!-- script -->
    <script>
        $(document).ready(function(){
        new DataTable('#example');
    })
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    
<?php include "footer.php";?>

<!-- modal -->
<div class="modal fade" id="detailDaftar" tabindex="-1" aria-labelledby="judulKelas" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulKelas">Data Detail Pendaftaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post">
                        <div class="form-group row">
                            <label for="nis" class="col-md-2 col-form-label col-form-label-sm">NIS</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="nis" id="nis" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_siswa" class="col-md-2 col-form-label col-form-label-sm">Nama Siswa</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="nama_siswa" id="nama_siswa" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-2 col-form-label col-form-label-sm">Alamat</label>
                            <div class="col-md-9">
                                <textarea type="text" class="form-control form-control-sm" name="alamat" id="alamat" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_kelamin" class="col-md-2 col-form-label col-form-label-sm">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="jenis_kelamin" id="jenis_kelamin" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tempat_lahir" class="col-md-2 col-form-label col-form-label-sm">Tempat Lahir</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="tempat_lahir" id="tempat_lahir" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_lahir" class="col-md-2 col-form-label col-form-label-sm">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="tgl_lahir" id="tgl_lahir" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label col-form-label-sm">Agama</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="agama" id="agama" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-md-2 col-form-label col-form-label-sm">Status</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="status" id="status" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama_negara" class="col-md-2 col-form-label col-form-label-sm">Nama Negara</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="nama_negara" id="nama_negara" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kelas" class="col-md-2 col-form-label col-form-label-sm">Kelas</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="kelas" id="kelas" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_input" class="col-md-2 col-form-label col-form-label-sm">Tanggal Input</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="tgl_input" id="tgl_input" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_input" class="col-md-2 col-form-label col-form-label-sm">User Input</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="user_input" id="user_input" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl_update" class="col-md-2 col-form-label col-form-label-sm">Tanggal Update</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="tgl_update" id="tgl_update" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="akses" class="col-md-2 col-form-label col-form-label-sm">Akses</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm" name="akses" id="akses" readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="reset" name="kembali" class="btn btn-primary btn-sm" data-dismiss="modal">Kembali</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- javascript -->
<script>
    $(function() {
        // $('.tambahKelas').on('click', function() {
        //     $('#judulKelas').html('Tambah Data Kelas');
        //     $('.modal-footer button[type=submit]').html('Simpan');
        //     $('#jenjang').val("--Pilih Jenjang--");
        //     $('#jurusan').val("--Pilih Jurusan--");
        //     $('#jmlh').val("");
        //     $('#nis').val("");
        // });

        $('.Detai_Pendaftaran').on('click', function() {
            // $('#judulKelas').html('Edit Data Kelas');
            // $('.modal-footer button[type=submit]').html('Edit');
            // $('.modal-body form').attr('action', 'edit_kelas.php');
            const nis = $(this).data('id');
            // console.log(id);

            $.ajax({
                url: 'proses_detail.php',
                data: {
                    id: nis
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $('#nis').val(data.nis);
                    $('#nama_siswa').val(data.nama_siswa);
                    $('#alamat').val(data.alamat);
                    $('#jenis_kelamin').val(data.jenis_kelamin);
                    $('#tempat_lahir').val(data.tempat_lahir);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#agama').val(data.nama_agama);
                    $('#status').val(data.status);
                    $('#nama_negara').val(data.nama_negara);
                    $('#kelas').val(data.kelas);
                    $('#tgl_input').val(data.tgl_input);
                    $('#user_input').val(data.user_input);
                    $('#tgl_update').val(data.tgl_update);
                    $('#user_update').val(data.user_update);
                    $('#akses').val(data.akses);

                }
            });
        });

    });
</script>