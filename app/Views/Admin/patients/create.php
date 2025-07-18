<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="header">
    <a href="<?= base_url('admin/patients') ?>" class="btn">
        <i class="fas fa-arrow-left"></i> Back to Patients
    </a>
    <h1><?= $title ?></h1>
</div>

<!-- Error Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if ($validation && $validation->getErrors()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($validation->getErrors() as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/patients/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <!-- Debug form submission -->
    <input type="hidden" name="debug" value="1">
    
    <!-- Personal Information -->
    <div class="card">
        <h3>Personal Information</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="first_name">First Name *</label>
                <input type="text" id="first_name" name="first_name" value="<?= old('first_name') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name *</label>
                <input type="text" id="last_name" name="last_name" value="<?= old('last_name') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="tel" id="phone" name="phone" value="<?= old('phone') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth *</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender *</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= old('gender') === 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" id="nationality" name="nationality" value="<?= old('nationality') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" id="occupation" name="occupation" value="<?= old('occupation') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="marital_status">Marital Status</label>
                <select id="marital_status" name="marital_status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="single" <?= old('marital_status') === 'single' ? 'selected' : '' ?>>Single</option>
                    <option value="married" <?= old('marital_status') === 'married' ? 'selected' : '' ?>>Married</option>
                    <option value="divorced" <?= old('marital_status') === 'divorced' ? 'selected' : '' ?>>Divorced</option>
                    <option value="widowed" <?= old('marital_status') === 'widowed' ? 'selected' : '' ?>>Widowed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="preferred_language">Preferred Language</label>
                <input type="text" id="preferred_language" name="preferred_language" value="<?= old('preferred_language') ?>" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" class="form-control"><?= old('address') ?></textarea>
        </div>
    </div>

    <!-- Emergency Contact -->
    <div class="card">
        <h3>Emergency Contact</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="emergency_contact_name">Contact Name</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?= old('emergency_contact_name') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="emergency_contact_phone">Contact Phone</label>
                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?= old('emergency_contact_phone') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="emergency_contact_relationship">Relationship</label>
                <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" value="<?= old('emergency_contact_relationship') ?>" class="form-control" placeholder="e.g., Spouse, Parent, Sibling">
            </div>
        </div>
    </div>

    <!-- Medical Information -->
    <div class="card">
        <h3>Medical Information</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="blood_type">Blood Type</label>
                <select id="blood_type" name="blood_type" class="form-control">
                    <option value="">Select Blood Type</option>
                    <option value="A+" <?= old('blood_type') === 'A+' ? 'selected' : '' ?>>A+</option>
                    <option value="A-" <?= old('blood_type') === 'A-' ? 'selected' : '' ?>>A-</option>
                    <option value="B+" <?= old('blood_type') === 'B+' ? 'selected' : '' ?>>B+</option>
                    <option value="B-" <?= old('blood_type') === 'B-' ? 'selected' : '' ?>>B-</option>
                    <option value="AB+" <?= old('blood_type') === 'AB+' ? 'selected' : '' ?>>AB+</option>
                    <option value="AB-" <?= old('blood_type') === 'AB-' ? 'selected' : '' ?>>AB-</option>
                    <option value="O+" <?= old('blood_type') === 'O+' ? 'selected' : '' ?>>O+</option>
                    <option value="O-" <?= old('blood_type') === 'O-' ? 'selected' : '' ?>>O-</option>
                    <option value="Unknown" <?= old('blood_type') === 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                </select>
            </div>

            <div class="form-group">
                <label for="preferred_appointment_time">Preferred Appointment Time</label>
                <select id="preferred_appointment_time" name="preferred_appointment_time" class="form-control">
                    <option value="">Select Time</option>
                    <option value="morning" <?= old('preferred_appointment_time') === 'morning' ? 'selected' : '' ?>>Morning</option>
                    <option value="afternoon" <?= old('preferred_appointment_time') === 'afternoon' ? 'selected' : '' ?>>Afternoon</option>
                    <option value="evening" <?= old('preferred_appointment_time') === 'evening' ? 'selected' : '' ?>>Evening</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea id="allergies" name="allergies" rows="3" placeholder="List any known allergies..." class="form-control"><?= old('allergies') ?></textarea>
        </div>

        <div class="form-group">
            <label for="medical_conditions">Medical Conditions</label>
            <textarea id="medical_conditions" name="medical_conditions" rows="3" placeholder="List any current medical conditions..." class="form-control"><?= old('medical_conditions') ?></textarea>
        </div>

        <div class="form-group">
            <label for="current_medications">Current Medications</label>
            <textarea id="current_medications" name="current_medications" rows="3" placeholder="List current medications and dosages..." class="form-control"><?= old('current_medications') ?></textarea>
        </div>
    </div>

    <!-- Insurance Information -->
    <div class="card">
        <h3>Insurance Information</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="insurance_provider">Insurance Provider</label>
                <input type="text" id="insurance_provider" name="insurance_provider" value="<?= old('insurance_provider') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="insurance_number">Insurance Number</label>
                <input type="text" id="insurance_number" name="insurance_number" value="<?= old('insurance_number') ?>" class="form-control">
            </div>
        </div>
    </div>

    <!-- Dental History -->
    <div class="card">
        <h3>Dental History</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="previous_dentist">Previous Dentist</label>
                <input type="text" id="previous_dentist" name="previous_dentist" value="<?= old('previous_dentist') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="referral_source">Referral Source</label>
                <input type="text" id="referral_source" name="referral_source" value="<?= old('referral_source') ?>" placeholder="How did you hear about us?" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="dental_history">Dental History</label>
            <textarea id="dental_history" name="dental_history" rows="4" placeholder="Previous dental treatments, procedures, etc..." class="form-control"><?= old('dental_history') ?></textarea>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="card">
        <h3>Additional Information</h3>
        
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="active" <?= old('status') === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="suspended" <?= old('status') === 'suspended' ? 'selected' : '' ?>>Suspended</option>
            </select>
        </div>

        <div class="form-group">
            <label for="special_needs">Special Needs</label>
            <textarea id="special_needs" name="special_needs" rows="3" placeholder="Any special accommodations needed..." class="form-control"><?= old('special_needs') ?></textarea>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" rows="4" placeholder="Additional notes about the patient..." class="form-control"><?= old('notes') ?></textarea>
        </div>
    </div>

    <!-- Form Actions -->
    <div>
        <a href="<?= base_url('admin/patients') ?>" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Patient
        </button>
    </div>
</form>
<?= $this->endSection() ?>
