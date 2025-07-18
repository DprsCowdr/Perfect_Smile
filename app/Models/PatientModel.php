<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'patient_id', 'first_name', 'last_name', 'email', 'phone', 'address',
        'date_of_birth', 'gender', 'nationality', 'occupation', 'marital_status',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship',
        'blood_type', 'allergies', 'medical_conditions', 'current_medications',
        'insurance_provider', 'insurance_number', 'dental_history', 'previous_dentist',
        'referral_source', 'preferred_appointment_time', 'status', 'preferred_language',
        'special_needs', 'notes', 'created_by', 'updated_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'first_name' => 'required|min_length[2]|max_length[100]',
        'last_name' => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|is_unique[patient.email,id,{id}]',
        'phone' => 'required|min_length[10]|max_length[20]',
        'date_of_birth' => 'required|valid_date',
        'gender' => 'required|in_list[male,female,other]',
        'status' => 'in_list[active,inactive,suspended]',
        'blood_type' => 'in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown]',
        'marital_status' => 'in_list[single,married,divorced,widowed]',
        'preferred_appointment_time' => 'in_list[morning,afternoon,evening]'
    ];

    protected $validationMessages = [
        'first_name' => [
            'required' => 'First name is required',
            'min_length' => 'First name must be at least 2 characters long'
        ],
        'last_name' => [
            'required' => 'Last name is required',
            'min_length' => 'Last name must be at least 2 characters long'
        ],
        'email' => [
            'required' => 'Email is required',
            'valid_email' => 'Please enter a valid email address',
            'is_unique' => 'This email is already registered'
        ],
        'phone' => [
            'required' => 'Phone number is required',
            'min_length' => 'Phone number must be at least 10 digits'
        ],
        'date_of_birth' => [
            'required' => 'Date of birth is required',
            'valid_date' => 'Please enter a valid date'
        ],
        'gender' => [
            'required' => 'Gender is required',
            'in_list' => 'Please select a valid gender'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generatePatientId', 'setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];

    /**
     * Generate unique patient ID before insert
     */
    protected function generatePatientId(array $data)
    {
        if (!isset($data['data']['patient_id'])) {
            $lastPatient = $this->orderBy('id', 'DESC')->first();
            $nextNumber = $lastPatient ? (intval(substr($lastPatient['patient_id'], 4)) + 1) : 1;
            $data['data']['patient_id'] = 'PAT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        return $data;
    }

    /**
     * Set created_by field
     */
    protected function setCreatedBy(array $data)
    {
        if (session()->has('user')) {
            $data['data']['created_by'] = session('user')['id'];
        }
        return $data;
    }

    /**
     * Set updated_by field
     */
    protected function setUpdatedBy(array $data)
    {
        if (session()->has('user')) {
            $data['data']['updated_by'] = session('user')['id'];
        }
        return $data;
    }

    /**
     * Get patient by email
     */
    public function getPatientByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get patient by patient ID
     */
    public function getPatientByPatientId($patientId)
    {
        return $this->where('patient_id', $patientId)->first();
    }

    /**
     * Get active patients
     */
    public function getActivePatients()
    {
        return $this->where('status', 'active')->findAll();
    }

    /**
     * Search patients by name, email, or patient ID
     */
    public function searchPatients($searchTerm)
    {
        return $this->groupStart()
                    ->like('first_name', $searchTerm)
                    ->orLike('last_name', $searchTerm)
                    ->orLike('email', $searchTerm)
                    ->orLike('patient_id', $searchTerm)
                    ->orLike('phone', $searchTerm)
                    ->groupEnd()
                    ->where('status', 'active')
                    ->findAll();
    }

    /**
     * Get patients with medical conditions
     */
    public function getPatientsWithConditions()
    {
        return $this->where('medical_conditions IS NOT NULL')
                    ->where('medical_conditions !=', '')
                    ->findAll();
    }

    /**
     * Get patients by age range
     */
    public function getPatientsByAgeRange($minAge, $maxAge)
    {
        return $this->where('age >=', $minAge)
                    ->where('age <=', $maxAge)
                    ->findAll();
    }

    /**
     * Get patient statistics
     */
    public function getPatientStats()
    {
        return [
            'total' => $this->countAll(),
            'active' => $this->where('status', 'active')->countAllResults(),
            'inactive' => $this->where('status', 'inactive')->countAllResults(),
            'male' => $this->where('gender', 'male')->countAllResults(),
            'female' => $this->where('gender', 'female')->countAllResults(),
        ];
    }
}