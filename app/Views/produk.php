<div class="container mt-5">
    <h3 class="mb-4"><?= $subtitle; ?></h3>
    <a href="/add" class="btn btn-primary mb-2">Tambah Produk</a>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produk)) : ?>
                        <tr>
                            <td colspan="5" class="text-center">Data belum tersedia</td>
                        </tr>
                        <?php else :
                        $no = 1;
                        foreach ($produk as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['nama_produk']) ?></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                <td><?= esc($row['nama_kategori']) ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= esc($row['nama_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/edit/<?= $row['id_produk'] ?>" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <a href="/delete/<?= $row['id_produk'] ?>"
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                        class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>