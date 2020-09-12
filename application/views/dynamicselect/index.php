<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title><?= $title; ?></title>
</head>

<body>
    <div class="container">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="<?= base_url('select/add'); ?>" class="btn btn-primary mb-2">Tambah Data</a>
                        <a href="<?= base_url('select/autocomplete'); ?>" class="btn btn-primary mb-2">Tambah Data Autocomplete</a>
                        <a href="<?= base_url('select/ajaxremote'); ?>" class="btn btn-primary mb-2">Tambah Data Select2 ajax Remote</a>
                        <a href="<?= base_url('select/multiple'); ?>" class="btn btn-primary mb-2">Multiple select</a>

                        <?= $this->session->flashdata('status'); ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Alamat Lengkap</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($customers as $customer) : ?>
                                    <tr>
                                        <th scope="row"><?= $i; ?></th>
                                        <td><?= $customer['customer'] ?></td>
                                        <td><?= $customer['alamat'] . ", Desa " . $customer['desa'] . ", Kecamatan" . $customer['kecamatan'] . ", Kabupaten " . $customer['kabupaten'] . ", Provinsi " . $customer['provinsi']; ?></td>
                                        <td>
                                            <a href="<?= base_url('select/getById/' . $customer['id'] . '/edit'); ?>" class="btn btn-success">Edit</a>
                                            <a href="<?= base_url('select/getById/' . $customer['id'] . '/delete'); ?>" class="btn btn-danger" onclick="return confirm('Yakin ??')">Delete</a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>