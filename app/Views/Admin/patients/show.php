<?= $this->extend('Templates/admin_layout') ?>

<?= $this->section('content') ?>
<div class="header">
    <a href="<?= base_url('admin/patients') ?>" class="btn">
        <i class="fas fa-arrow-left"></i> Back to Patients
    </a>
    <h1><?= $title ?></h1>
    <div>
        <a href="<?= base_url('admin/patients/edit/' . $patient['id']) ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Patient
        </a>
        <a href="<?= base_url('admin/patients/delete/' . $patient['id']) ?>" class="btn btn-danger"
           onclick="return confirm('Are you sure you want to delete this patient?')">
            <i class="fas fa-trash"></i> Delete
        </a>
    </div>
</div>

<!-- Patient Overview -->
<div class="card">
    <h2><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></h2>
    <p><strong>Patient ID:</strong> <?= esc($patient['patient_id']) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($patient['status']) ?></p>
</div>

<!-- Personal Information -->
<div class="card">
    <h3>Personal Information</h3>
    
    <div class="grid">
        <div>
            <strong>Email:</strong> <?= esc($patient['email']) ?>
        </div>
        <div>
            <strong>Phone:</strong> <?= esc($patient['phone']) ?>
        </div>
        <div>
            <strong>Date of Birth:</strong> 
            <?= $patient['date_of_birth'] ? date('F d, Y', strtotime($patient['date_of_birth'])) : 'Not specified' ?>
        </div>
        <div>
            <strong>Gender:</strong> <?= ucfirst($patient['gender']) ?>
        </div>
        <div>
            <strong>Nationality:</strong> <?= $patient['nationality'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Occupation:</strong> <?= $patient['occupation'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Marital Status:</strong> <?= $patient['marital_status'] ? ucfirst($patient['marital_status']) : 'Not specified' ?>
        </div>
        <div>
            <strong>Preferred Language:</strong> <?= $patient['preferred_language'] ?: 'Not specified' ?>
        </div>
    </div>
    
    <div>
        <strong>Address:</strong><br>
        <?= $patient['address'] ?: 'Not specified' ?>
    </div>
</div>

<!-- Emergency Contact -->
<div class="card">
    <h3>Emergency Contact</h3>
    
    <div class="grid">
        <div>
            <strong>Contact Name:</strong> <?= $patient['emergency_contact_name'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Contact Phone:</strong> <?= $patient['emergency_contact_phone'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Relationship:</strong> <?= $patient['emergency_contact_relationship'] ?: 'Not specified' ?>
        </div>
    </div>
</div>

<!-- Medical Information -->
<div class="card">
    <h3>Medical Information</h3>
    
    <div class="grid">
        <div>
            <strong>Blood Type:</strong> <?= $patient['blood_type'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Preferred Appointment Time:</strong> <?= $patient['preferred_appointment_time'] ? ucfirst($patient['preferred_appointment_time']) : 'Not specified' ?>
        </div>
    </div>
    
    <div>
        <strong>Allergies:</strong><br>
        <?= $patient['allergies'] ?: 'None specified' ?>
    </div>
    
    <div>
        <strong>Medical Conditions:</strong><br>
        <?= $patient['medical_conditions'] ?: 'None specified' ?>
    </div>
    
    <div>
        <strong>Current Medications:</strong><br>
        <?= $patient['current_medications'] ?: 'None specified' ?>
    </div>
</div>

<!-- Insurance Information -->
<div class="card">
    <h3>Insurance Information</h3>
    
    <div class="grid">
        <div>
            <strong>Insurance Provider:</strong> <?= $patient['insurance_provider'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Insurance Number:</strong> <?= $patient['insurance_number'] ?: 'Not specified' ?>
        </div>
    </div>
</div>

<!-- Dental History -->
<div class="card">
    <h3>Dental History</h3>
    
    <div class="grid">
        <div>
            <strong>Previous Dentist:</strong> <?= $patient['previous_dentist'] ?: 'Not specified' ?>
        </div>
        <div>
            <strong>Referral Source:</strong> <?= $patient['referral_source'] ?: 'Not specified' ?>
        </div>
    </div>
    
    <div>
        <strong>Dental History:</strong><br>
        <?= $patient['dental_history'] ?: 'No history recorded' ?>
    </div>
</div>

<!-- Additional Information -->
<div class="card">
    <h3>Additional Information</h3>
    
    <div>
        <strong>Special Needs:</strong><br>
        <?= $patient['special_needs'] ?: 'None specified' ?>
    </div>
    
    <div>
        <strong>Notes:</strong><br>
        <?= $patient['notes'] ?: 'No notes' ?>
    </div>
</div>

<!-- Record Information -->
<div class="card">
    <h3>Record Information</h3>
    
    <div class="grid">
        <div>
            <strong>Created At:</strong> 
            <?= $patient['created_at'] ? date('F d, Y g:i A', strtotime($patient['created_at'])) : 'Not available' ?>
        </div>
        <div>
            <strong>Last Updated:</strong> 
            <?= $patient['updated_at'] ? date('F d, Y g:i A', strtotime($patient['updated_at'])) : 'Never updated' ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
