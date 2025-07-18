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

<form action="<?= base_url('admin/patients/update/' . $patient['id']) ?>" method="post">
    <?= csrf_field() ?>
    
    <!-- Personal Information -->
    <div class="card">
        <h3>Personal Information</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="first_name">First Name *</label>
                <input type="text" id="first_name" name="first_name" value="<?= old('first_name', $patient['first_name']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name *</label>
                <input type="text" id="last_name" name="last_name" value="<?= old('last_name', $patient['last_name']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?= old('email', $patient['email']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="tel" id="phone" name="phone" value="<?= old('phone', $patient['phone']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth *</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth', $patient['date_of_birth']) ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender *</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male" <?= old('gender', $patient['gender']) === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= old('gender', $patient['gender']) === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= old('gender', $patient['gender']) === 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="active" <?= old('status', $patient['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= old('status', $patient['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="suspended" <?= old('status', $patient['status']) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" class="form-control"><?= old('address', $patient['address']) ?></textarea>
        </div>
    </div>

    <!-- Contact & Emergency -->
    <div class="card">
        <h3>Emergency Contact</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="emergency_contact_name">Contact Name</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?= old('emergency_contact_name', $patient['emergency_contact_name']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="emergency_contact_phone">Contact Phone</label>
                <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" value="<?= old('emergency_contact_phone', $patient['emergency_contact_phone']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="emergency_contact_relationship">Relationship</label>
                <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" value="<?= old('emergency_contact_relationship', $patient['emergency_contact_relationship']) ?>" class="form-control">
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
                    <option value="A+" <?= old('blood_type', $patient['blood_type']) === 'A+' ? 'selected' : '' ?>>A+</option>
                    <option value="A-" <?= old('blood_type', $patient['blood_type']) === 'A-' ? 'selected' : '' ?>>A-</option>
                    <option value="B+" <?= old('blood_type', $patient['blood_type']) === 'B+' ? 'selected' : '' ?>>B+</option>
                    <option value="B-" <?= old('blood_type', $patient['blood_type']) === 'B-' ? 'selected' : '' ?>>B-</option>
                    <option value="AB+" <?= old('blood_type', $patient['blood_type']) === 'AB+' ? 'selected' : '' ?>>AB+</option>
                    <option value="AB-" <?= old('blood_type', $patient['blood_type']) === 'AB-' ? 'selected' : '' ?>>AB-</option>
                    <option value="O+" <?= old('blood_type', $patient['blood_type']) === 'O+' ? 'selected' : '' ?>>O+</option>
                    <option value="O-" <?= old('blood_type', $patient['blood_type']) === 'O-' ? 'selected' : '' ?>>O-</option>
                    <option value="Unknown" <?= old('blood_type', $patient['blood_type']) === 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                </select>
            </div>

            <div class="form-group">
                <label for="preferred_appointment_time">Preferred Appointment Time</label>
                <select id="preferred_appointment_time" name="preferred_appointment_time" class="form-control">
                    <option value="">Select Time</option>
                    <option value="morning" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'morning' ? 'selected' : '' ?>>Morning</option>
                    <option value="afternoon" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'afternoon' ? 'selected' : '' ?>>Afternoon</option>
                    <option value="evening" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'evening' ? 'selected' : '' ?>>Evening</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="allergies">Allergies</label>
            <textarea id="allergies" name="allergies" rows="2" class="form-control"><?= old('allergies', $patient['allergies']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="medical_conditions">Medical Conditions</label>
            <textarea id="medical_conditions" name="medical_conditions" rows="2" class="form-control"><?= old('medical_conditions', $patient['medical_conditions']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="current_medications">Current Medications</label>
            <textarea id="current_medications" name="current_medications" rows="2" class="form-control"><?= old('current_medications', $patient['current_medications']) ?></textarea>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="card">
        <h3>Additional Information</h3>
        
        <div class="grid">
            <div class="form-group">
                <label for="insurance_provider">Insurance Provider</label>
                <input type="text" id="insurance_provider" name="insurance_provider" value="<?= old('insurance_provider', $patient['insurance_provider']) ?>" class="form-control">
            </div>

            <div class="form-group">
                <label for="insurance_number">Insurance Number</label>
                <input type="text" id="insurance_number" name="insurance_number" value="<?= old('insurance_number', $patient['insurance_number']) ?>" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="form-control"><?= old('notes', $patient['notes']) ?></textarea>
        </div>
    </div>

    <!-- Form Actions -->
    <div>
        <a href="<?= base_url('admin/patients') ?>" class="btn">Cancel</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Patient
        </button>
    </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="<?= base_url('admin/patients') ?>" 
               class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
        </div>

        <!-- Error Messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if ($validation && $validation->getErrors()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    <?php foreach ($validation->getErrors() as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/patients/update/' . $patient['id']) ?>" method="post" class="space-y-6">
            <?= csrf_field() ?>
            
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="first_name" 
                               name="first_name" 
                               value="<?= old('first_name', $patient['first_name']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="last_name" 
                               name="last_name" 
                               value="<?= old('last_name', $patient['last_name']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?= old('email', $patient['email']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="<?= old('phone', $patient['phone']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                            Date of Birth <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="<?= old('date_of_birth', $patient['date_of_birth']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <select id="gender" 
                                name="gender" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">Select Gender</option>
                            <option value="male" <?= old('gender', $patient['gender']) === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= old('gender', $patient['gender']) === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= old('gender', $patient['gender']) === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">
                            Nationality
                        </label>
                        <input type="text" 
                               id="nationality" 
                               name="nationality" 
                               value="<?= old('nationality', $patient['nationality']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">
                            Occupation
                        </label>
                        <input type="text" 
                               id="occupation" 
                               name="occupation" 
                               value="<?= old('occupation', $patient['occupation']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Marital Status
                        </label>
                        <select id="marital_status" 
                                name="marital_status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Status</option>
                            <option value="single" <?= old('marital_status', $patient['marital_status']) === 'single' ? 'selected' : '' ?>>Single</option>
                            <option value="married" <?= old('marital_status', $patient['marital_status']) === 'married' ? 'selected' : '' ?>>Married</option>
                            <option value="divorced" <?= old('marital_status', $patient['marital_status']) === 'divorced' ? 'selected' : '' ?>>Divorced</option>
                            <option value="widowed" <?= old('marital_status', $patient['marital_status']) === 'widowed' ? 'selected' : '' ?>>Widowed</option>
                        </select>
                    </div>

                    <div>
                        <label for="preferred_language" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Language
                        </label>
                        <input type="text" 
                               id="preferred_language" 
                               name="preferred_language" 
                               value="<?= old('preferred_language', $patient['preferred_language']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Address
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('address', $patient['address']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Emergency Contact</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Contact Name
                        </label>
                        <input type="text" 
                               id="emergency_contact_name" 
                               name="emergency_contact_name" 
                               value="<?= old('emergency_contact_name', $patient['emergency_contact_name']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Contact Phone
                        </label>
                        <input type="tel" 
                               id="emergency_contact_phone" 
                               name="emergency_contact_phone" 
                               value="<?= old('emergency_contact_phone', $patient['emergency_contact_phone']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700 mb-2">
                            Relationship
                        </label>
                        <input type="text" 
                               id="emergency_contact_relationship" 
                               name="emergency_contact_relationship" 
                               value="<?= old('emergency_contact_relationship', $patient['emergency_contact_relationship']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="e.g., Spouse, Parent, Sibling">
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Medical Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="blood_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Blood Type
                        </label>
                        <select id="blood_type" 
                                name="blood_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Blood Type</option>
                            <option value="A+" <?= old('blood_type', $patient['blood_type']) === 'A+' ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= old('blood_type', $patient['blood_type']) === 'A-' ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= old('blood_type', $patient['blood_type']) === 'B+' ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= old('blood_type', $patient['blood_type']) === 'B-' ? 'selected' : '' ?>>B-</option>
                            <option value="AB+" <?= old('blood_type', $patient['blood_type']) === 'AB+' ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= old('blood_type', $patient['blood_type']) === 'AB-' ? 'selected' : '' ?>>AB-</option>
                            <option value="O+" <?= old('blood_type', $patient['blood_type']) === 'O+' ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= old('blood_type', $patient['blood_type']) === 'O-' ? 'selected' : '' ?>>O-</option>
                            <option value="Unknown" <?= old('blood_type', $patient['blood_type']) === 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                        </select>
                    </div>

                    <div>
                        <label for="preferred_appointment_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Preferred Appointment Time
                        </label>
                        <select id="preferred_appointment_time" 
                                name="preferred_appointment_time" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Time</option>
                            <option value="morning" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'morning' ? 'selected' : '' ?>>Morning</option>
                            <option value="afternoon" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'afternoon' ? 'selected' : '' ?>>Afternoon</option>
                            <option value="evening" <?= old('preferred_appointment_time', $patient['preferred_appointment_time']) === 'evening' ? 'selected' : '' ?>>Evening</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">
                            Allergies
                        </label>
                        <textarea id="allergies" 
                                  name="allergies" 
                                  rows="3"
                                  placeholder="List any known allergies..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('allergies', $patient['allergies']) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="medical_conditions" class="block text-sm font-medium text-gray-700 mb-2">
                            Medical Conditions
                        </label>
                        <textarea id="medical_conditions" 
                                  name="medical_conditions" 
                                  rows="3"
                                  placeholder="List any current medical conditions..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('medical_conditions', $patient['medical_conditions']) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="current_medications" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Medications
                        </label>
                        <textarea id="current_medications" 
                                  name="current_medications" 
                                  rows="3"
                                  placeholder="List current medications and dosages..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('current_medications', $patient['current_medications']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Insurance Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Insurance Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="insurance_provider" class="block text-sm font-medium text-gray-700 mb-2">
                            Insurance Provider
                        </label>
                        <input type="text" 
                               id="insurance_provider" 
                               name="insurance_provider" 
                               value="<?= old('insurance_provider', $patient['insurance_provider']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="insurance_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Insurance Number
                        </label>
                        <input type="text" 
                               id="insurance_number" 
                               name="insurance_number" 
                               value="<?= old('insurance_number', $patient['insurance_number']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Dental History -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Dental History</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="previous_dentist" class="block text-sm font-medium text-gray-700 mb-2">
                            Previous Dentist
                        </label>
                        <input type="text" 
                               id="previous_dentist" 
                               name="previous_dentist" 
                               value="<?= old('previous_dentist', $patient['previous_dentist']) ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="referral_source" class="block text-sm font-medium text-gray-700 mb-2">
                            Referral Source
                        </label>
                        <input type="text" 
                               id="referral_source" 
                               name="referral_source" 
                               value="<?= old('referral_source', $patient['referral_source']) ?>"
                               placeholder="How did you hear about us?"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label for="dental_history" class="block text-sm font-medium text-gray-700 mb-2">
                            Dental History
                        </label>
                        <textarea id="dental_history" 
                                  name="dental_history" 
                                  rows="4"
                                  placeholder="Previous dental treatments, procedures, etc..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('dental_history', $patient['dental_history']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Additional Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active" <?= old('status', $patient['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status', $patient['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= old('status', $patient['status']) === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="special_needs" class="block text-sm font-medium text-gray-700 mb-2">
                            Special Needs
                        </label>
                        <textarea id="special_needs" 
                                  name="special_needs" 
                                  rows="3"
                                  placeholder="Any special accommodations needed..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('special_needs', $patient['special_needs']) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="4"
                                  placeholder="Additional notes about the patient..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"><?= old('notes', $patient['notes']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="<?= base_url('admin/patients') ?>" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>Update Patient
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
