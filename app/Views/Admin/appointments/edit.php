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
    <form action="<?= base_url('admin/appointments/update/' . $appointment['id']) ?>" method="post">
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
                            <option value="<?= $patient['id'] ?>" 
                                    <?= (old('patient_id', $appointment['patient_id']) == $patient['id']) ? 'selected' : '' ?>>
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
                            <option value="<?= $doctor['id'] ?>" 
                                    <?= (old('doctor_id', $appointment['doctor_id']) == $doctor['id']) ? 'selected' : '' ?>>
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
                           value="<?= old('appointment_date', $appointment['appointment_date']) ?>" required>
                </div>

                <div>
                    <label for="appointment_time"><strong>Appointment Time *</strong></label>
                    <input type="time" id="appointment_time" name="appointment_time" 
                           value="<?= old('appointment_time', $appointment['appointment_time']) ?>" required>
                </div>

                <div>
                    <label for="duration"><strong>Duration (minutes)</strong></label>
                    <input type="number" id="duration" name="duration" 
                           value="<?= old('duration', $appointment['duration']) ?>" min="15" max="240" step="15">
                </div>

                <div>
                    <label for="appointment_type"><strong>Appointment Type *</strong></label>
                    <select id="appointment_type" name="appointment_type" required>
                        <option value="">Select Type</option>
                        <option value="consultation" <?= (old('appointment_type', $appointment['appointment_type']) == 'consultation') ? 'selected' : '' ?>>Consultation</option>
                        <option value="cleaning" <?= (old('appointment_type', $appointment['appointment_type']) == 'cleaning') ? 'selected' : '' ?>>Cleaning</option>
                        <option value="filling" <?= (old('appointment_type', $appointment['appointment_type']) == 'filling') ? 'selected' : '' ?>>Filling</option>
                        <option value="extraction" <?= (old('appointment_type', $appointment['appointment_type']) == 'extraction') ? 'selected' : '' ?>>Extraction</option>
                        <option value="root_canal" <?= (old('appointment_type', $appointment['appointment_type']) == 'root_canal') ? 'selected' : '' ?>>Root Canal</option>
                        <option value="crown" <?= (old('appointment_type', $appointment['appointment_type']) == 'crown') ? 'selected' : '' ?>>Crown</option>
                        <option value="bridge" <?= (old('appointment_type', $appointment['appointment_type']) == 'bridge') ? 'selected' : '' ?>>Bridge</option>
                        <option value="implant" <?= (old('appointment_type', $appointment['appointment_type']) == 'implant') ? 'selected' : '' ?>>Implant</option>
                        <option value="orthodontics" <?= (old('appointment_type', $appointment['appointment_type']) == 'orthodontics') ? 'selected' : '' ?>>Orthodontics</option>
                        <option value="emergency" <?= (old('appointment_type', $appointment['appointment_type']) == 'emergency') ? 'selected' : '' ?>>Emergency</option>
                        <option value="follow_up" <?= (old('appointment_type', $appointment['appointment_type']) == 'follow_up') ? 'selected' : '' ?>>Follow-up</option>
                    </select>
                </div>

                <div>
                    <label for="status"><strong>Status</strong></label>
                    <select id="status" name="status">
                        <option value="scheduled" <?= (old('status', $appointment['status']) == 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
                        <option value="confirmed" <?= (old('status', $appointment['status']) == 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                        <option value="in_progress" <?= (old('status', $appointment['status']) == 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                        <option value="completed" <?= (old('status', $appointment['status']) == 'completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= (old('status', $appointment['status']) == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        <option value="no_show" <?= (old('status', $appointment['status']) == 'no_show') ? 'selected' : '' ?>>No Show</option>
                        <option value="rescheduled" <?= (old('status', $appointment['status']) == 'rescheduled') ? 'selected' : '' ?>>Rescheduled</option>
                    </select>
                </div>

                <div>
                    <label for="priority"><strong>Priority</strong></label>
                    <select id="priority" name="priority">
                        <option value="low" <?= (old('priority', $appointment['priority']) == 'low') ? 'selected' : '' ?>>Low</option>
                        <option value="normal" <?= (old('priority', $appointment['priority']) == 'normal') ? 'selected' : '' ?>>Normal</option>
                        <option value="high" <?= (old('priority', $appointment['priority']) == 'high') ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= (old('priority', $appointment['priority']) == 'urgent') ? 'selected' : '' ?>>Urgent</option>
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
                    <textarea id="chief_complaint" name="chief_complaint" rows="3"><?= old('chief_complaint', $appointment['chief_complaint']) ?></textarea>
                </div>

                <div>
                    <label for="symptoms"><strong>Symptoms</strong></label>
                    <textarea id="symptoms" name="symptoms" rows="3"><?= old('symptoms', $appointment['symptoms']) ?></textarea>
                </div>

                <div>
                    <label for="treatment_plan"><strong>Treatment Plan</strong></label>
                    <textarea id="treatment_plan" name="treatment_plan" rows="3"><?= old('treatment_plan', $appointment['treatment_plan']) ?></textarea>
                </div>

                <div>
                    <label for="diagnosis"><strong>Diagnosis</strong></label>
                    <textarea id="diagnosis" name="diagnosis" rows="3" 
                              style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('diagnosis', $appointment['diagnosis']) ?></textarea>
                </div>

                <div>
                    <label for="treatment_notes"><strong>Treatment Notes</strong></label>
                    <textarea id="treatment_notes" name="treatment_notes" rows="3" 
                              style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('treatment_notes', $appointment['treatment_notes']) ?></textarea>
                </div>

                <div>
                    <label for="prescription"><strong>Prescription</strong></label>
                    <textarea id="prescription" name="prescription" rows="3" 
                              style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('prescription', $appointment['prescription']) ?></textarea>
                </div>
            </div>
        </fieldset>

        <!-- Payment Information -->
        <fieldset style="border: 1px solid #ccc; padding: 20px; margin: 20px 0; border-radius: 4px;">
            <legend><strong>Payment Information</strong></legend>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div>
                    <label for="payment_status"><strong>Payment Status</strong></label>
                    <select id="payment_status" name="payment_status" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                        <option value="pending" <?= (old('payment_status', $appointment['payment_status']) == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="partial" <?= (old('payment_status', $appointment['payment_status']) == 'partial') ? 'selected' : '' ?>>Partial</option>
                        <option value="paid" <?= (old('payment_status', $appointment['payment_status']) == 'paid') ? 'selected' : '' ?>>Paid</option>
                        <option value="refunded" <?= (old('payment_status', $appointment['payment_status']) == 'refunded') ? 'selected' : '' ?>>Refunded</option>
                    </select>
                </div>

                <div>
                    <label for="amount"><strong>Amount</strong></label>
                    <input type="number" id="amount" name="amount" step="0.01" min="0" 
                           value="<?= old('amount', $appointment['amount']) ?>"
                           style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label for="discount"><strong>Discount</strong></label>
                    <input type="number" id="discount" name="discount" step="0.01" min="0" 
                           value="<?= old('discount', $appointment['discount']) ?>"
                           style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="insurance_claim" value="1" 
                               <?= old('insurance_claim', $appointment['insurance_claim']) ? 'checked' : '' ?>>
                        <strong>Insurance Claim</strong>
                    </label>
                </div>
            </div>
        </fieldset>

        <!-- Additional Information -->
        <fieldset style="border: 1px solid #ccc; padding: 20px; margin: 20px 0; border-radius: 4px;">
            <legend><strong>Additional Information</strong></legend>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <label for="room_number"><strong>Room Number</strong></label>
                    <input type="text" id="room_number" name="room_number" 
                           value="<?= old('room_number', $appointment['room_number']) ?>"
                           style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div>
                    <label for="equipment_needed"><strong>Equipment Needed</strong></label>
                    <textarea id="equipment_needed" name="equipment_needed" rows="2" 
                              style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('equipment_needed', $appointment['equipment_needed']) ?></textarea>
                </div>

                <div>
                    <label for="special_instructions"><strong>Special Instructions</strong></label>
                    <textarea id="special_instructions" name="special_instructions" rows="2" 
                              style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('special_instructions', $appointment['special_instructions']) ?></textarea>
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="follow_up_required" value="1" 
                               <?= old('follow_up_required', $appointment['follow_up_required']) ? 'checked' : '' ?>>
                        <strong>Follow-up Required</strong>
                    </label>
                    <input type="date" name="follow_up_date" 
                           value="<?= old('follow_up_date', $appointment['follow_up_date']) ?>"
                           style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; margin-top: 5px;">
                </div>
            </div>
        </fieldset>

        <!-- Cancellation Information (only if status is cancelled) -->
        <fieldset style="border: 1px solid #ccc; padding: 20px; margin: 20px 0; border-radius: 4px;">
            <legend><strong>Cancellation Information</strong></legend>
            
            <div>
                <label for="cancellation_reason"><strong>Cancellation Reason</strong></label>
                <textarea id="cancellation_reason" name="cancellation_reason" rows="3" 
                          placeholder="Enter reason if cancelling appointment..."
                          style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= old('cancellation_reason', $appointment['cancellation_reason']) ?></textarea>
            </div>
        </fieldset>

        <!-- Submit Button -->
        <div style="margin: 20px 0;">
            <button type="submit" style="background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                <i class="fas fa-save"></i> Update Appointment
            </button>
            <a href="<?= base_url('admin/appointments/show/' . $appointment['id']) ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                <i class="fas fa-eye"></i> View Details
            </a>
            <a href="<?= base_url('admin/appointments') ?>" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-left: 10px;">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
