<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="font-size:64px; color:'#dddddd'"><i>LAPORAN</i></div>
    <p>
        Tanggal : <?= date('Y-m-d') ?><br>
    </p>
    <table cellpadding="6">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jenis</th>
                <th>Titik Kontrol</th>
                <th>Foto</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if (isset($dtInspeksi)) {
                foreach ($dtInspeksi as $row) {
                    $rowId = $row['id'];
                    $explTgl = explode(' ', $row['tanggal']); ?>
                    <tr>
                        <td><?= $no; ?>.</td>
                        <td><?= $explTgl[0]; ?></td>
                        <td><?= $explTgl[1]; ?></td>
                        <td><?= $row['jenis']; ?></td>
                        <td><?= $row['titik']; ?></td>
                        <td><img src="<?= '../uploads/inspeksi/' . $row['foto']; ?>" alt="" class="foto"></td>
                        <td><?= $row['kondisi']; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                        <td><?= $row['petugas_id']; ?></td>
                    </tr>
            <?php
                    $no++;
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>