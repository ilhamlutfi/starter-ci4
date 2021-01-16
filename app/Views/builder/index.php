<?= $this->extend('layout/templates'); ?>

<?= $this->Section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4"><i class="fas fa-database"></i> CRUD Query Builder</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><?= $title; ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Employees Table
                </div>
                <div class="card-body">
                    <a href="" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-square"></i> Add data</a>

                    <?php
                    $errors = session()->getFlashdata('failed');
                    if (!empty($errors)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-times"></i> Failed</strong> data not added to database.
                            <ul>
                                <?php foreach ($errors as $e) { ?>
                                    <li><?= esc($e); ?></li>
                                <?php } ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashData('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fas fa-check"></i> Success</strong> <?= session()->getFlashData('success'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Position</th>
                                    <th>Age</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($all_data as $datas) : ?>
                                    <tr>
                                        <td width="1%"><?= $no++; ?></td>
                                        <td><?= esc($datas->name); ?></td>
                                        <td><?= esc($datas->department); ?></td>
                                        <td><?= esc($datas->position); ?></td>
                                        <td><?= esc($datas->age); ?> years</td>
                                        <td class="text-center" width="20%">
                                            <a href="" class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#updateModal<?= $datas->id; ?>">
                                                Update
                                            </a>
                                            <a href="" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#deleteModal<?= $datas->id; ?>">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-square"></i> Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= form_open('builder/add_data'); ?>
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="dept">Department</label>
                        <select name="department" id="dept" class="form-control">
                            <option value="">- Select -</option>
                            <option value="Finance">Finance</option>
                            <option value="Public relations">Public relations</option>
                            <option value="Information Technology">Information Technology</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" name="position" id="position" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" name="age" id="age" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Update modal -->
    <?php foreach ($all_data as $datas) : ?>
        <div class="modal fade" id="updateModal<?= $datas->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"></i> Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?= form_open('builder/update_data/' . $datas->id); ?>
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $datas->id; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?= $datas->name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <select name="department" id="dept" class="form-control">
                                <?php if ($dept = $datas->department ?? $datas->department) : ?>
                                    <option value="">- Select -</option>
                                    <option value="Finance" <?= $dept == 'Finance' ? 'selected' : null ?>>
                                        Finance
                                    </option>
                                    <option value="Public relations" <?= $dept == 'Public relations' ? 'selected' : null ?>>
                                        Public relations
                                    </option>
                                    <option value="Information Technology" <?= $dept == 'Information Technology' ? 'selected' : null ?>>
                                        Information Technology
                                    </option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" name="position" id="position" class="form-control" value="<?= $datas->position; ?>">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="text" name="age" id="age" class="form-control" value="<?= $datas->age; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Delete modal -->
    <?php foreach ($all_data as $datas) : ?>
        <div class="modal fade" id="deleteModal<?= $datas->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i> Delete Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?= form_open('builder/delete_data/' . $datas->id); ?>
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= $datas->id; ?>">
                        <p>Click the submit button to delete data (<?= $datas->name; ?>)..!!!</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?= $this->endSection(); ?>