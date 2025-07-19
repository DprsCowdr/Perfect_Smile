<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>

<div>
    <div>
        <a href="<?= base_url('admin/appointments') ?>">
            <i class="fas fa-arrow-left"></i> Back to Appointments
        </a>
        <h1><?= $title ?></h1>
    </div>

    <!-- Error Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($validation) && $validation->getErrors()): ?>
        <div>
            <ul>
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Appointment Form -->
    <form action="<?= base_url('admin/appointments/store') ?>" method="post">
        <?= csrf_field() ?>
        
        <!-- Basic Information -->
        <fieldset>
            <legend><strong>Basic Information</strong></legend>
            
            <div>
                <div>
                    <label for="patient_id"><strong>Patient *</strong></label>
                    <select id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        <?php foreach ($patients as $patient): ?>
                            <option value="<?= $patient['id'] ?>" <?= old('patient_id') == $patient['id'] ? 'selected' : '' ?>>
                                <?php if (isset($patient['first_name']) && isset($patient['last_name'])): ?>
                                    <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?> - <?= esc($patient['phone']) ?>
                                <?php elseif (isset($patient['patient_name'])): ?>
                                    <?= esc($patient['patient_name']) ?> - <?= esc($patient['phone']) ?>
                                <?php else: ?>
                                    Patient ID: <?= esc($patient['patient_id'] ?? $patient['id']) ?> - <?= esc($patient['phone']) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="doctor_id"><strong>Doctor</strong></label>
                    <select id="doctor_id" name="doctor_id">
                        <option value="">Select Doctor (Optional)</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>" <?= old('doctor_id') == $doctor['id'] ? 'selected' : '' ?>>
                                <?php if (isset($doctor['first_name']) && isset($doctor['last_name'])): ?>
                                    Dr. <?= esc($doctor['first_name'] . ' ' . $doctor['last_name']) ?>
                                <?php elseif (isset($doctor['username'])): ?>
                                    Dr. <?= esc($doctor['username']) ?>
                                <?php else: ?>
                                    Doctor ID: <?= esc($doctor['id']) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="appointment_date"><strong>Appointment Date *</strong></label>
                    <input type="date" id="appointment_date" name="appointment_date" 
                           value="<?= old('appointment_date') ?>" required
                           min="<?= date('Y-m-d') ?>">
                </div>

                <div>
                    <label for="appointment_time"><strong>Appointment Time *</strong></label>
                    <input type="time" id="appointment_time" name="appointment_time" 
                           value="<?= old('appointment_time') ?>" required>
                </div>

                <div>
                    <label for="duration"><strong>Duration (minutes)</strong></label>
                    <input type="number" id="duration" name="duration" 
                           value="<?= old('duration', 30) ?>" min="15" max="240" step="15">
                </div>

                <div>
                    <label for="appointment_type"><strong>Appointment Type *</strong></label>
                    <select id="appointment_type" name="appointment_type" required>
                        <option value="">Select Type</option>
                        <option value="consultation" <?= old('appointment_type') == 'consultation' ? 'selected' : '' ?>>Consultation</option>
                        <option value="cleaning" <?= old('appointment_type') == 'cleaning' ? 'selected' : '' ?>>Cleaning</option>
                        <option value="filling" <?= old('appointment_type') == 'filling' ? 'selected' : '' ?>>Filling</option>
                        <option value="extraction" <?= old('appointment_type') == 'extraction' ? 'selected' : '' ?>>Extraction</option>
                        <option value="root_canal" <?= old('appointment_type') == 'root_canal' ? 'selected' : '' ?>>Root Canal</option>
                        <option value="crown" <?= old('appointment_type') == 'crown' ? 'selected' : '' ?>>Crown</option>
                        <option value="bridge" <?= old('appointment_type') == 'bridge' ? 'selected' : '' ?>>Bridge</option>
                        <option value="implant" <?= old('appointment_type') == 'implant' ? 'selected' : '' ?>>Implant</option>
                        <option value="orthodontics" <?= old('appointment_type') == 'orthodontics' ? 'selected' : '' ?>>Orthodontics</option>
                        <option value="emergency" <?= old('appointment_type') == 'emergency' ? 'selected' : '' ?>>Emergency</option>
                        <option value="follow_up" <?= old('appointment_type') == 'follow_up' ? 'selected' : '' ?>>Follow-up</option>
                    </select>
                </div>

                <div>
                    <label for="status"><strong>Status</strong></label>
                    <select id="status" name="status">
                        <option value="scheduled" <?= old('status', 'scheduled') == 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                        <option value="confirmed" <?= old('status') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="in_progress" <?= old('status') == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="completed" <?= old('status') == 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= old('status') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        <option value="no_show" <?= old('status') == 'no_show' ? 'selected' : '' ?>>No Show</option>
                        <option value="rescheduled" <?= old('status') == 'rescheduled' ? 'selected' : '' ?>>Rescheduled</option>
                    </select>
                </div>

                <div>
                    <label for="priority"><strong>Priority</strong></label>
                    <select id="priority" name="priority">
                        <option value="normal" <?= old('priority', 'normal') == 'normal' ? 'selected' : '' ?>>Normal</option>
                        <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= old('priority') == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                    </select>
                </div>
            </div>
        </fieldset>

        <!-- Medical Information -->
        <fieldset>
            <legend><strong>Medical Information</strong></legend>
            
            <div>
                <div>
                    <label for="chief_complaint"><strong>Chief Complaint</strong></label>
                    <textarea id="chief_complaint" name="chief_complaint" rows="3"><?= old('chief_complaint') ?></textarea>
                </div>

                <div>
                    <label for="symptoms"><strong>Symptoms</strong></label>
                    <textarea id="symptoms" name="symptoms" rows="3"><?= old('symptoms') ?></textarea>
                </div>

                <div>
                    <label for="treatment_plan"><strong>Treatment Plan</strong></label>
                    <textarea id="treatment_plan" name="treatment_plan" rows="3"><?= old('treatment_plan') ?></textarea>
                </div>

                <div>
                    <label for="diagnosis"><strong>Diagnosis</strong></label>
                    <textarea id="diagnosis" name="diagnosis" rows="3"><?= old('diagnosis') ?></textarea>
                </div>
            </div>
        </fieldset>

        <!-- Payment Information -->
        <fieldset>
            <legend><strong>Payment Information</strong></legend>
            
            <div>
                <div>
                    <label for="payment_status"><strong>Payment Status</strong></label>
                    <select id="payment_status" name="payment_status">
                        <option value="pending" <?= old('payment_status', 'pending') == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="partial" <?= old('payment_status') == 'partial' ? 'selected' : '' ?>>Partial</option>
                        <option value="paid" <?= old('payment_status') == 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="refunded" <?= old('payment_status') == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                    </select>
                </div>

                <div>
                    <label for="amount"><strong>Amount</strong></label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" 
                           value="<?= old('amount') ?>">
                </div>

                <div>
                    <label for="discount"><strong>Discount</strong></label>
                    <input type="number" id="discount" name="discount" step="0.01" min="0" 
                           value="<?= old('discount', 0) ?>">
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="insurance_claim" value="1" 
                               <?= old('insurance_claim') ? 'checked' : '' ?>>
                        <strong>Insurance Claim</strong>
                    </label>
                </div>
            </div>
        </fieldset>

        <!-- Additional Information -->
        <fieldset>
            <legend><strong>Additional Information</strong></legend>
            
            <div>
                <div>
                    <label for="equipment_needed"><strong>Equipment Needed</strong></label>
                    <textarea id="equipment_needed" name="equipment_needed" rows="2"><?= old('equipment_needed') ?></textarea>
                </div>

                <div>
                    <label for="special_instructions"><strong>Special Instructions</strong></label>
                    <textarea id="special_instructions" name="special_instructions" rows="2"><?= old('special_instructions') ?></textarea>
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="follow_up_required" value="1" 
                               <?= old('follow_up_required') ? 'checked' : '' ?>>
                        <strong>Follow-up Required</strong>
                    </label>
                    <input type="date" name="follow_up_date" 
                           value="<?= old('follow_up_date') ?>">
                </div>
            </div>
        </fieldset>

        <!-- Submit Button -->
        <div>
            <button type="submit">
                <i class="fas fa-save"></i> Schedule Appointment
            </button>
            <a href="<?= base_url('admin/appointments') ?>">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
