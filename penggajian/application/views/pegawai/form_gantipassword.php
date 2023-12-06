<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>                        
    </div>

    <div class="card">
        <div class="card-body" style="width: 50%;">
            <form action="<?php echo base_url('pegawai/ganti_password/ganti_password_aksi') ?>" method="POST">
                <div class="form-group">
                    <label for="">Password Baru</label>
                    <input type="password" name="passbaru" class="form-control">
                    <?php echo form_error('passbaru','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                    <label for="">Ulangi Password Baru</label>
                    <input type="password" name="ulangpassbaru" class="form-control">
                    <?php echo form_error('ulangpassbaru','<div class="text-small text-danger"></div>') ?>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>