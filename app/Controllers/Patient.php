<?php

namespace App\Controllers;

use App\Models\PatientModel;
use CodeIgniter\Controller;

class Patient extends BaseController
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    /**
     * Display list of patients
     */
    public function index()
    {
        $data = [
            'title' => 'Patient Management',
            'patients' => $this->patientModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('Admin/patients/index', $data);
    }

    /**
     * Show create patient form
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Patient',
            'validation' => \Config\Services::validation()
        ];

        return view('Admin/patients/create', $data);
    }

    /**
     * Store new patient
     */
    public function store()
    {
        // Debug: Check if this is a POST request
        if (!$this->request->getMethod() === 'post') {
            log_message('error', 'Store method called but not a POST request');
            return redirect()->back()->with('error', 'Invalid request method');
        }

        // Debug: Log that the method is being called
        log_message('info', 'Patient store method called');
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|is_unique[patient.email]',
            'phone' => 'required|min_length[10]|max_length[20]',
            'date_of_birth' => 'required|valid_date',
            'gender' => 'required|in_list[male,female,other]',
            'status' => 'in_list[active,inactive,suspended]',
            'blood_type' => 'in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown]',
            'marital_status' => 'in_list[single,married,divorced,widowed]',
            'preferred_appointment_time' => 'in_list[morning,afternoon,evening]'
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'nationality' => $this->request->getPost('nationality'),
            'occupation' => $this->request->getPost('occupation'),
            'marital_status' => $this->request->getPost('marital_status'),
            'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
            'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
            'emergency_contact_relationship' => $this->request->getPost('emergency_contact_relationship'),
            'blood_type' => $this->request->getPost('blood_type'),
            'allergies' => $this->request->getPost('allergies'),
            'medical_conditions' => $this->request->getPost('medical_conditions'),
            'current_medications' => $this->request->getPost('current_medications'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_number' => $this->request->getPost('insurance_number'),
            'dental_history' => $this->request->getPost('dental_history'),
            'previous_dentist' => $this->request->getPost('previous_dentist'),
            'referral_source' => $this->request->getPost('referral_source'),
            'preferred_appointment_time' => $this->request->getPost('preferred_appointment_time'),
            'status' => $this->request->getPost('status') ?: 'active',
            'preferred_language' => $this->request->getPost('preferred_language'),
            'special_needs' => $this->request->getPost('special_needs'),
            'notes' => $this->request->getPost('notes')
        ];

        log_message('info', 'Data to insert: ' . json_encode($data));

        try {
            $result = $this->patientModel->insert($data);
            if ($result) {
                log_message('info', 'Patient inserted successfully with ID: ' . $result);
                return redirect()->to('/admin/patients')->with('success', 'Patient added successfully!');
            } else {
                $errors = $this->patientModel->errors();
                log_message('error', 'Model insertion failed: ' . json_encode($errors));
                return redirect()->back()->withInput()->with('error', 'Failed to add patient: ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during patient insertion: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show patient details
     */
    public function show($id)
    {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }

        $data = [
            'title' => 'Patient Details',
            'patient' => $patient
        ];

        return view('Admin/patients/show', $data);
    }

    /**
     * Show edit patient form
     */
    public function edit($id)
    {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }

        $data = [
            'title' => 'Edit Patient',
            'patient' => $patient,
            'validation' => \Config\Services::validation()
        ];

        return view('Admin/patients/edit', $data);
    }

    /**
     * Update patient
     */
    public function update($id)
    {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }

        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[patient.email,id,{$id}]",
            'phone' => 'required|min_length[10]|max_length[20]',
            'date_of_birth' => 'required|valid_date',
            'gender' => 'required|in_list[male,female,other]',
            'status' => 'in_list[active,inactive,suspended]',
            'blood_type' => 'in_list[A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown]',
            'marital_status' => 'in_list[single,married,divorced,widowed]',
            'preferred_appointment_time' => 'in_list[morning,afternoon,evening]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'gender' => $this->request->getPost('gender'),
            'nationality' => $this->request->getPost('nationality'),
            'occupation' => $this->request->getPost('occupation'),
            'marital_status' => $this->request->getPost('marital_status'),
            'emergency_contact_name' => $this->request->getPost('emergency_contact_name'),
            'emergency_contact_phone' => $this->request->getPost('emergency_contact_phone'),
            'emergency_contact_relationship' => $this->request->getPost('emergency_contact_relationship'),
            'blood_type' => $this->request->getPost('blood_type'),
            'allergies' => $this->request->getPost('allergies'),
            'medical_conditions' => $this->request->getPost('medical_conditions'),
            'current_medications' => $this->request->getPost('current_medications'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_number' => $this->request->getPost('insurance_number'),
            'dental_history' => $this->request->getPost('dental_history'),
            'previous_dentist' => $this->request->getPost('previous_dentist'),
            'referral_source' => $this->request->getPost('referral_source'),
            'preferred_appointment_time' => $this->request->getPost('preferred_appointment_time'),
            'status' => $this->request->getPost('status'),
            'preferred_language' => $this->request->getPost('preferred_language'),
            'special_needs' => $this->request->getPost('special_needs'),
            'notes' => $this->request->getPost('notes')
        ];

        if ($this->patientModel->update($id, $data)) {
            return redirect()->to('/admin/patients')->with('success', 'Patient updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update patient. Please try again.');
        }
    }

    /**
     * Delete patient
     */
    public function delete($id)
    {
        $patient = $this->patientModel->find($id);

        if (!$patient) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Patient not found');
        }

        if ($this->patientModel->delete($id)) {
            return redirect()->to('/admin/patients')->with('success', 'Patient deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete patient. Please try again.');
        }
    }

    /**
     * Search patients
     */
    public function search()
    {
        $searchTerm = $this->request->getGet('search');
        
        if (empty($searchTerm)) {
            return redirect()->to('/admin/patients');
        }

        $patients = $this->patientModel->searchPatients($searchTerm);

        $data = [
            'title' => 'Search Results',
            'patients' => $patients,
            'searchTerm' => $searchTerm
        ];

        return view('Admin/patients/index', $data);
    }
}
