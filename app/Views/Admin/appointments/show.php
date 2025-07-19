<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>

<div>
    <div>
        <a href="<?= base_url('admin/appointments') ?>">
            <i class="fas fa-arrow-left"></i> Back to Appointments
        </a>
        
        <div>
            <a href="<?= base_url('admin/appointments/edit/' . $appointment['id']) ?>">
                <i class="fas fa-edit"></i> Edit Appointment
            </a>
            
            <?php if ($appointment['status'] !== 'cancelled'): ?>
                <a href="<?= base_url('admin/appointments/delete/' . $appointment['id']) ?>"
                   onclick="return confirm('Are you sure you want to delete this appointment?')">
                    <i class="fas fa-trash"></i> Delete Appointment
                </a>
            <?php endif; ?>
        </div>
        
        <h1><?= $title ?></h1>
    </div>

    <!-- Appointment Overview -->
    <div>
        <h2>Appointment Overview</h2>
        
        <div>
            <div>
                <strong>Appointment ID:</strong><br>
                <span><?= esc($appointment['appointment_id']) ?></span>
            </div>
            
            <div>
                <strong>Date & Time:</strong><br>
                <?= date('l, F j, Y', strtotime($appointment['appointment_date'])) ?><br>
                <span><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></span>
            </div>
            
            <div>
                <strong>Type:</strong><br>
                <span>
                    <?= ucfirst(str_replace('_', ' ', $appointment['appointment_type'])) ?>
                </span>
            </div>
            
            <div>
                <strong>Status:</strong><br>
                <span>
                    <?= ucfirst(str_replace('_', ' ', $appointment['status'])) ?>
                </span>
            </div>
            
            <div>
                <strong>Priority:</strong><br>
                <span>
                    <?= ucfirst($appointment['priority']) ?>
                </span>
            </div>
            
            <div>
                <strong>Duration:</strong><br>
                <?= $appointment['duration'] ?> minutes
            </div>
        </div>
    </div>

    <!-- Patient Information -->
    <div>
        <h3>
            Patient Information
        </h3>
        <div>
            <?php if ($patient): ?>
                <div>
                    <div>
                        <strong>Name:</strong><br>
                        <?php if (isset($patient['first_name']) && isset($patient['last_name'])): ?>
                            <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?>
                        <?php elseif (isset($patient['patient_name'])): ?>
                            <?= esc($patient['patient_name']) ?>
                        <?php elseif (isset($patient['patient_id'])): ?>
                            Patient: <?= esc($patient['patient_id']) ?>
                        <?php else: ?>
                            Unknown Patient
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong>Patient ID:</strong><br>
                        <?= esc($patient['patient_id']) ?>
                    </div>
                    <div>
                        <strong>Phone:</strong><br>
                        <?= esc($patient['phone']) ?>
                    </div>
                    <div>
                        <strong>Email:</strong><br>
                        <?= esc($patient['email']) ?>
                    </div>
                    <div>
                        <strong>Date of Birth:</strong><br>
                        <?= date('M j, Y', strtotime($patient['date_of_birth'])) ?>
                    </div>
                    <div>
                        <strong>Gender:</strong><br>
                        <?= ucfirst($patient['gender']) ?>
                    </div>
                </div>
                
                <?php if ($patient['address']): ?>
                    <div>
                        <strong>Address:</strong><br>
                        <?= esc($patient['address']) ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p>Patient information not found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Doctor Information -->
    <div>
        <h3>
            Doctor Information
        </h3>
        <div>
            <?php if ($doctor): ?>
                <div>
                    <div>
                        <strong>Name:</strong><br>
                        <?php if (isset($doctor['first_name']) && isset($doctor['last_name'])): ?>
                            Dr. <?= esc($doctor['first_name'] . ' ' . $doctor['last_name']) ?>
                        <?php elseif (isset($doctor['username'])): ?>
                            Dr. <?= esc($doctor['username']) ?>
                        <?php elseif (isset($doctor['email'])): ?>
                            Dr. <?= esc($doctor['email']) ?>
                        <?php else: ?>
                            Unknown Doctor
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong>Email:</strong><br>
                        <?= esc($doctor['email']) ?>
                    </div>
                    <div>
                        <strong>Phone:</strong><br>
                        <?= esc($doctor['phone'] ?? 'Not provided') ?>
                    </div>
                </div>
            <?php else: ?>
                <p>No doctor assigned to this appointment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Medical Information -->
    <div>
        <h3>
            Medical Information
        </h3>
        <div>
            <div>
                <?php if ($appointment['chief_complaint']): ?>
                    <div>
                        <strong>Chief Complaint:</strong><br>
                        <?= nl2br(esc($appointment['chief_complaint'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['symptoms']): ?>
                    <div>
                        <strong>Symptoms:</strong><br>
                        <?= nl2br(esc($appointment['symptoms'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['diagnosis']): ?>
                    <div>
                        <strong>Diagnosis:</strong><br>
                        <?= nl2br(esc($appointment['diagnosis'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['treatment_plan']): ?>
                    <div>
                        <strong>Treatment Plan:</strong><br>
                        <?= nl2br(esc($appointment['treatment_plan'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['treatment_notes']): ?>
                    <div>
                        <strong>Treatment Notes:</strong><br>
                        <?= nl2br(esc($appointment['treatment_notes'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['prescription']): ?>
                    <div>
                        <strong>Prescription:</strong><br>
                        <?= nl2br(esc($appointment['prescription'])) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Payment Information -->
    <div>
        <h3>
            Payment Information
        </h3>
        <div>
            <div>
                <div>
                    <strong>Payment Status:</strong><br>
                    <span>
                        <?= ucfirst($appointment['payment_status']) ?>
                    </span>
                </div>
                
                <?php if ($appointment['amount']): ?>
                    <div>
                        <strong>Amount:</strong><br>
                        $<?= number_format($appointment['amount'], 2) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['discount'] > 0): ?>
                    <div>
                        <strong>Discount:</strong><br>
                        $<?= number_format($appointment['discount'], 2) ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <strong>Insurance Claim:</strong><br>
                    <?= $appointment['insurance_claim'] ? 'Yes' : 'No' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div>
        <h3>
            Additional Information
        </h3>
        <div>
            <div>
                <?php if ($appointment['room_number']): ?>
                    <div>
                        <strong>Room Number:</strong><br>
                        <?= esc($appointment['room_number']) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['equipment_needed']): ?>
                    <div>
                        <strong>Equipment Needed:</strong><br>
                        <?= nl2br(esc($appointment['equipment_needed'])) ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($appointment['special_instructions']): ?>
                    <div>
                        <strong>Special Instructions:</strong><br>
                        <?= nl2br(esc($appointment['special_instructions'])) ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <strong>Follow-up Required:</strong><br>
                    <?= $appointment['follow_up_required'] ? 'Yes' : 'No' ?>
                    <?php if ($appointment['follow_up_required'] && $appointment['follow_up_date']): ?>
                        <br><small>Date: <?= date('M j, Y', strtotime($appointment['follow_up_date'])) ?></small>
                    <?php endif; ?>
                </div>
                
                <div>
                    <strong>Reminder Sent:</strong><br>
                    <?= $appointment['reminder_sent'] ? 'Yes' : 'No' ?>
                    <?php if ($appointment['reminder_sent'] && $appointment['reminder_date']): ?>
                        <br><small>Date: <?= date('M j, Y g:i A', strtotime($appointment['reminder_date'])) ?></small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancellation Information -->
    <?php if ($appointment['status'] === 'cancelled'): ?>
        <div>
            <h3>
                Cancellation Information
            </h3>
            <div>
                <?php if ($appointment['cancelled_at']): ?>
                    <p><strong>Cancelled On:</strong> <?= date('M j, Y g:i A', strtotime($appointment['cancelled_at'])) ?></p>
                <?php endif; ?>
                
                <?php if ($appointment['cancellation_reason']): ?>
                    <p><strong>Reason:</strong> <?= nl2br(esc($appointment['cancellation_reason'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Record Information -->
    <div>
        <p><strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($appointment['created_at'])) ?></p>
        <?php if ($appointment['updated_at'] && $appointment['updated_at'] !== $appointment['created_at']): ?>
            <p><strong>Last Updated:</strong> <?= date('M j, Y g:i A', strtotime($appointment['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
