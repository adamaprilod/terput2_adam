<?php
include 'header.php';
include 'conn.php';
if ($_SESSION['hak_akses'] != 'admin') {
    echo "
    <script>
        alert('Tidak Memiliki Akses, DILARANG MASUK!');
        document.location.href='index.php';
    </script>
    ";
}
if (isset($_POST['simpan'])) {
    $id_agama = htmlspecialchars($_POST['id_agama']);
    $nama_agama = htmlspecialchars($_POST['nama_agama']);
    $tgl_update = date('Y-m-d');
    $user_update = htmlspecialchars($_POST['user_update']);
    $id_user = htmlspecialchars($_POST['id_user']);
    $query = "UPDATE agama SET
            id_agama='$id_agama',
            nama_agama='$nama_agama',
            tgl_update='$tgl_update',
            user_update='$user_update',
            id_user='$id_user'
            WHERE id_agama='$id_agama'
            ";
    // var_dump($query);
    // exit();
    mysqli_query($conn, $query);
    if (mysqli_affected_rows($conn) > 0) {
        echo "
            <script>
                alert('Data Agama Berhasil DiUpdate');
                document.location.href='data_agama.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('Data Agama Gagal Update');
                document.location.href='data_agama.php';
            </script>
            ";
    }
}

$data = mysqli_query($conn, "SELECT *
FROM agama
LEFT JOIN user
ON agama.id_user = user.id_user WHERE id_agama='" . $_GET['id_agama'] . "'");
$edit = mysqli_fetch_assoc($data);
?>
<body id="page-top">
    <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-2 d-none d-lg-block "></div>
                <div class="col-lg-8">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Edit Agama</h1>
                        </div>
                        <form class="user" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="id_agama"
                                placeholder="Id Agama" name="id_agama" value="<?= $edit['id_agama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama_agama"
                                    placeholder="Nama Agama" name="nama_agama" required value="<?= $edit['nama_agama']; ?>">
                            </div>
                            <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="user_update"
                                    placeholder="User Update" name="user_update" required value="<?= $edit['user_input']; ?>">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="id_user" id="id_user" >
                                <option value="<?= $edit['id_user'] ?>"><?= $edit['hak_akses'] ?> (<?= $edit['username'] ?>)</option>
                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE hak_akses = '$status' AND id_user='$_SESSION[id_user];'");
                                    while ($data = mysqli_fetch_assoc($sql)) {
                                    ?>
                                        <option value="<?= $data['id_user'] ?>"><?= $data['hak_akses'] ?> (<?= $data['username'] ?>)</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <button class="btn btn-danger" type="reset">Reset</button>
                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>