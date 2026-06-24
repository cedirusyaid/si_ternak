<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $title ?></h3>
            </div>
            <div class="box-body">
                <?php if(session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <p>Silakan pilih file ZIP laporan vaksinasi untuk diunggah. Sistem akan secara otomatis mengekstrak dan memfilter data untuk <b>Kabupaten Sinjai</b>.</p>
                <hr>
                <?= form_open_multipart('vaksinasi/process_upload') ?>
                    <div class="form-group">
                        <label for="zip_file">Pilih File ZIP</label>
                        <input type="file" name="zip_file" id="zip_file" required accept=".zip">
                        <p class="help-block">Ukuran file tidak dibatasi. Format file: .zip</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload dan Proses</button>
                </form>
            </div>
        </div>
    </div>
</div>
