<?php
header('Content-Type: application/json; charset=utf8');

// Cross Origin Request
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "pabw_pemesanan");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data TO DO: Buat lebih spesifik (Untuk POSTMAN)
    $sql = "SELECT * FROM pemesanan";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id = $_POST['id']; // All Required since it's a new data
    $nama = $_POST['nama'];
    $nomor = $_POST['nomor'];
    $alamat = $_POST['alamat'];
    $alasan = $_POST['alasan'];
    $sql = "INSERT INTO pemesanan (id, nama, nomor, alamat, alasan) VALUES ('$id', '$nama', '$nomor', '$alamat', '$alasan')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Bisaa YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tydakk"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id = $_GET['id'];
    $sql = "DELETE FROM pemesanan WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "ヾ(≧▽≦*)o YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "(っ °Д °;)っ NAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id_update'];
    $new_id = $_PUT['new_id'];

    // Check if a new ID was provided and use it if available
    if (isset($_PUT['new_id']) && !empty($_PUT['new_id'])) {
        // Update the ID in the database
        $sql_update_id = "UPDATE pemesanan SET id='$new_id' WHERE id='$id'";
        $cek_update_id = mysqli_query($koneksi, $sql_update_id);

        // Update the ID variable if the update was successful
        if ($cek_update_id) {
            $id = $new_id;
        }
    }

    $nama_pemesan = $_PUT['nama_pemesan_update'];
    $nomor_upd = $_PUT['nomor_update'];
    $alamat_upd = $_PUT['alamat_update'];
    $alasan_upd = $_PUT['alasan_update'];

    $sql = "UPDATE pemesanan SET nama_pemesan='$nama_pemesan', nomor='$nomor_upd', alamat='$alamat_upd', alasan='$alasan_upd' WHERE id='$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "ヾ(≧▽≦*)o YAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "(っ °Д °;)っ NAY"
        ];
        echo json_encode([$data], JSON_PRETTY_PRINT);
    }
}
?>