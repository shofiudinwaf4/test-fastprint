<div class="container mt-5">
    <h3 class="mb-4"><?= $subtitle; ?></h3>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div><?= $error ?></div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="/store" method="post">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nama Produk</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control " name="namaProduk" id="namaProduk" placeholder="Nama Produk" value="<?= old('namaProduk'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga Produk" value="<?= old('harga'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="kategori" id="autoSizingSelect">
                            <option value="">pilih</option>
                            <?php foreach ($kategori as $kat) : ?>
                                <option value="<?= esc($kat['id_kategori']) ?>" <?= $kat['id_kategori'] == old('kategori') ? 'selected' : '' ?>><?= esc($kat['nama_kategori']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="status" id="autoSizingSelect">
                            <?php foreach ($status as $sta) : ?>
                                <option value="<?= esc($sta['id_status']) ?>" <?= $sta['id_status'] == old('status') ? 'selected' : '' ?>><?= esc($sta['nama_status']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>