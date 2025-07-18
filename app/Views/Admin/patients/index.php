<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="header">
    <h1><?= $title ?></h1>
    <a href="<?= base_url('admin/patients/create') ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Patient
    </a>
</div>

<!-- Search Form -->
<div class="card">
    <form action="<?= base_url('admin/patients/search') ?>" method="get">
        <div class="form-group">
            <input type="text" 
                   name="search" 
                   placeholder="Search by name, email, phone, or patient ID..." 
                   value="<?= isset($searchTerm) ? esc($searchTerm) : '' ?>"
                   class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-search"></i> Search
        </button>
        <?php if (isset($searchTerm)): ?>
            <a href="<?= base_url('admin/patients') ?>" class="btn">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Success/Error Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Patients Table -->
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Info</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></strong><br>
                                    <small><?= esc($patient['patient_id']) ?></small>
                                </td>
                                <td>
                                    <?= esc($patient['email']) ?><br>
                                    <small><?= esc($patient['phone']) ?></small>
                                </td>
                                <td><?= ucfirst($patient['status']) ?></td>
                                <td><?= date('M d, Y', strtotime($patient['created_at'])) ?></td>
                                <td>
                                    <a href="<?= base_url('admin/patients/show/' . $patient['id']) ?>" class="btn" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/patients/edit/' . $patient['id']) ?>" class="btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/patients/delete/' . $patient['id']) ?>" class="btn btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this patient?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <?php if (isset($searchTerm)): ?>
                                    No patients found matching your search criteria.
                                <?php else: ?>
                                    No patients found. <a href="<?= base_url('admin/patients/create') ?>">Add the first patient</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
