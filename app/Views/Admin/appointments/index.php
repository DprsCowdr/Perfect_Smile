<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>

<div>
    <h1><?= $title ?></h1>
    
    <!-- Success/Error Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Actions -->
    <div>
        <a href="<?= base_url('admin/appointments/create') ?>">
            <i class="fas fa-plus"></i> Schedule New Appointment
        </a>
        
        <a href="<?= base_url('admin/appointments/calendar') ?>">
            <i class="fas fa-calendar"></i> Calendar View
        </a>
    </div>

    <!-- Search -->
    <div>
        <form action="<?= base_url('admin/appointments/search') ?>" method="GET">
            <input type="text" name="search" placeholder="Search appointments..." 
                   value="<?= isset($searchTerm) ? esc($searchTerm) : '' ?>">
            <button type="submit">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
        
        <?php if (isset($searchTerm)): ?>
            <a href="<?= base_url('admin/appointments') ?>">
                <i class="fas fa-times"></i> Clear Search
            </a>
        <?php endif; ?>
    </div>

    <!-- Appointments Table -->
    <div>
        <table border="1">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date & Time</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= esc($appointment['appointment_id']) ?></td>
                            <td>
                                <?php if (isset($appointment['patient_first_name']) && isset($appointment['patient_last_name'])): ?>
                                    <?= esc($appointment['patient_first_name'] . ' ' . $appointment['patient_last_name']) ?>
                                <?php elseif (isset($appointment['patient_name'])): ?>
                                    <?= esc($appointment['patient_name']) ?>
                                <?php elseif (isset($appointment['patient_identifier'])): ?>
                                    Patient: <?= esc($appointment['patient_identifier']) ?>
                                <?php else: ?>
                                    Unknown Patient
                                <?php endif; ?>
                                <br>
                                <small><?= esc($appointment['patient_phone'] ?? 'No phone') ?></small>
                            </td>
                            <td>
                                <?php if (!empty($appointment['doctor_username'])): ?>
                                    Dr. <?= esc($appointment['doctor_username']) ?>
                                    <br>
                                    <small><?= esc($appointment['doctor_email']) ?></small>
                                    <?php if (isset($appointment['doctor_type'])): ?>
                                    <br>
                                    <small><?= ucfirst($appointment['doctor_type']) ?></small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span>Not assigned</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('M d, Y', strtotime($appointment['appointment_date'])) ?>
                                <br>
                                <small><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></small>
                            </td>
                            <td>
                                <span>
                                    <?= ucfirst(str_replace('_', ' ', $appointment['appointment_type'])) ?>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <?= ucfirst(str_replace('_', ' ', $appointment['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <?= ucfirst($appointment['priority']) ?>
                                </span>
                            </td>
                            <td><?= $appointment['duration'] ?> min</td>
                            <td>
                                <a href="<?= base_url('admin/appointments/show/' . $appointment['id']) ?>">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="<?= base_url('admin/appointments/edit/' . $appointment['id']) ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <?php if ($appointment['status'] !== 'cancelled'): ?>
                                    <a href="<?= base_url('admin/appointments/delete/' . $appointment['id']) ?>"
                                       onclick="return confirm('Are you sure you want to delete this appointment?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">
                            <?php if (isset($searchTerm)): ?>
                                No appointments found matching "<?= esc($searchTerm) ?>"
                            <?php else: ?>
                                No appointments scheduled yet.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Statistics -->
    <div>
        <h3>Quick Stats</h3>
        <p><strong>Total Appointments:</strong> <?= count($appointments) ?></p>
        <?php if (!empty($appointments)): ?>
            <?php
            $statusCounts = [];
            foreach ($appointments as $apt) {
                $statusCounts[$apt['status']] = ($statusCounts[$apt['status']] ?? 0) + 1;
            }
            ?>
            <?php foreach ($statusCounts as $status => $count): ?>
                <p><strong><?= ucfirst(str_replace('_', ' ', $status)) ?>:</strong> <?= $count ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
