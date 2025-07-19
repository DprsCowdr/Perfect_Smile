<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PatientModel;
use App\Models\UserModel;

class Appointment extends BaseController
{
    protected $appointmentModel;
    protected $patientModel;
    protected $userModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->patientModel = new PatientModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display list of appointments
     */
    public function index()
    {
        $data = [
            'title' => 'Appointment Management',
            'appointments' => $this->appointmentModel->getAppointmentsWithDetails()
        ];

        return view('Admin/appointments/index', $data);
    }

    /**
     * Show create appointment form
     */
    public function create()
    {
        $data = [
            'title' => 'Schedule New Appointment',
            'patients' => $this->patientModel->orderBy('first_name', 'ASC')->findAll(),
            'doctors' => $this->userModel->where('user_type', 'doctor')->orderBy('username', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('Admin/appointments/create', $data);
    }

    /**
     * Store new appointment
     */
    public function store()
    {
        log_message('info', 'Appointment store method called');
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        
        $rules = [
            'patient_id' => 'required|integer',
            'appointment_date' => 'required|valid_date',
            'appointment_time' => 'required',
            'appointment_type' => 'required|in_list[consultation,cleaning,filling,extraction,root_canal,crown,bridge,implant,orthodontics,emergency,follow_up]',
            'duration' => 'integer|greater_than[0]',
            'status' => 'in_list[scheduled,confirmed,in_progress,completed,cancelled,no_show,rescheduled]',
            'priority' => 'in_list[low,normal,high,urgent]',
            'payment_status' => 'in_list[pending,partial,paid,refunded]',
            'amount' => 'decimal',
            'discount' => 'decimal'
        ];

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Check for appointment conflicts if doctor is assigned
        $doctorId = $this->request->getPost('doctor_id');
        $appointmentDate = $this->request->getPost('appointment_date');
        $appointmentTime = $this->request->getPost('appointment_time');
        $duration = $this->request->getPost('duration') ?: 30;

        if ($doctorId) {
            $conflict = $this->appointmentModel->checkAppointmentConflict($doctorId, $appointmentDate, $appointmentTime, $duration);
            if ($conflict) {
                return redirect()->back()->withInput()->with('error', 'Time slot conflicts with existing appointment: ' . $conflict['appointment_id']);
            }
        }

        $data = [
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $this->request->getPost('doctor_id'),
            'appointment_date' => $this->request->getPost('appointment_date'),
            'appointment_time' => $this->request->getPost('appointment_time'),
            'duration' => $duration,
            'appointment_type' => $this->request->getPost('appointment_type'),
            'status' => $this->request->getPost('status') ?: 'scheduled',
            'priority' => $this->request->getPost('priority') ?: 'normal',
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'symptoms' => $this->request->getPost('symptoms'),
            'treatment_plan' => $this->request->getPost('treatment_plan'),
            'diagnosis' => $this->request->getPost('diagnosis'),
            'treatment_notes' => $this->request->getPost('treatment_notes'),
            'prescription' => $this->request->getPost('prescription'),
            'follow_up_required' => $this->request->getPost('follow_up_required') ? 1 : 0,
            'follow_up_date' => $this->request->getPost('follow_up_date'),
            'payment_status' => $this->request->getPost('payment_status') ?: 'pending',
            'amount' => $this->request->getPost('amount'),
            'discount' => $this->request->getPost('discount') ?: 0,
            'insurance_claim' => $this->request->getPost('insurance_claim') ? 1 : 0,
            'equipment_needed' => $this->request->getPost('equipment_needed'),
            'special_instructions' => $this->request->getPost('special_instructions')
        ];

        log_message('info', 'Data to insert: ' . json_encode($data));

        try {
            $result = $this->appointmentModel->insert($data);
            if ($result) {
                log_message('info', 'Appointment scheduled successfully with ID: ' . $result);
                return redirect()->to('/admin/appointments')->with('success', 'Appointment scheduled successfully!');
            } else {
                $errors = $this->appointmentModel->errors();
                log_message('error', 'Model insertion failed: ' . json_encode($errors));
                return redirect()->back()->withInput()->with('error', 'Failed to schedule appointment: ' . implode(', ', $errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during appointment creation: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show appointment details
     */
    public function show($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Appointment not found');
        }

        // Get related data
        $patient = $this->patientModel->find($appointment['patient_id']);
        $doctor = $appointment['doctor_id'] ? $this->userModel->find($appointment['doctor_id']) : null;

        $data = [
            'title' => 'Appointment Details',
            'appointment' => $appointment,
            'patient' => $patient,
            'doctor' => $doctor
        ];

        return view('Admin/appointments/show', $data);
    }

    /**
     * Show edit appointment form
     */
    public function edit($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Appointment not found');
        }

        $data = [
            'title' => 'Edit Appointment',
            'appointment' => $appointment,
            'patients' => $this->patientModel->orderBy('first_name', 'ASC')->findAll(),
            'doctors' => $this->userModel->where('user_type', 'doctor')->orderBy('username', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('Admin/appointments/edit', $data);
    }

    /**
     * Update appointment
     */
    public function update($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Appointment not found');
        }

        $rules = [
            'patient_id' => 'required|integer',
            'appointment_date' => 'required|valid_date',
            'appointment_time' => 'required',
            'appointment_type' => 'required|in_list[consultation,cleaning,filling,extraction,root_canal,crown,bridge,implant,orthodontics,emergency,follow_up]',
            'duration' => 'integer|greater_than[0]',
            'status' => 'in_list[scheduled,confirmed,in_progress,completed,cancelled,no_show,rescheduled]',
            'priority' => 'in_list[low,normal,high,urgent]',
            'payment_status' => 'in_list[pending,partial,paid,refunded]',
            'amount' => 'decimal',
            'discount' => 'decimal'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Check for appointment conflicts if doctor is assigned
        $doctorId = $this->request->getPost('doctor_id');
        $appointmentDate = $this->request->getPost('appointment_date');
        $appointmentTime = $this->request->getPost('appointment_time');
        $duration = $this->request->getPost('duration') ?: 30;

        if ($doctorId) {
            $conflict = $this->appointmentModel->checkAppointmentConflict($doctorId, $appointmentDate, $appointmentTime, $duration, $id);
            if ($conflict) {
                return redirect()->back()->withInput()->with('error', 'Time slot conflicts with existing appointment: ' . $conflict['appointment_id']);
            }
        }

        $data = [
            'patient_id' => $this->request->getPost('patient_id'),
            'doctor_id' => $this->request->getPost('doctor_id'),
            'appointment_date' => $this->request->getPost('appointment_date'),
            'appointment_time' => $this->request->getPost('appointment_time'),
            'duration' => $duration,
            'appointment_type' => $this->request->getPost('appointment_type'),
            'status' => $this->request->getPost('status'),
            'priority' => $this->request->getPost('priority'),
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'symptoms' => $this->request->getPost('symptoms'),
            'treatment_plan' => $this->request->getPost('treatment_plan'),
            'diagnosis' => $this->request->getPost('diagnosis'),
            'treatment_notes' => $this->request->getPost('treatment_notes'),
            'prescription' => $this->request->getPost('prescription'),
            'follow_up_required' => $this->request->getPost('follow_up_required') ? 1 : 0,
            'follow_up_date' => $this->request->getPost('follow_up_date'),
            'payment_status' => $this->request->getPost('payment_status'),
            'amount' => $this->request->getPost('amount'),
            'discount' => $this->request->getPost('discount') ?: 0,
            'insurance_claim' => $this->request->getPost('insurance_claim') ? 1 : 0,
            'room_number' => $this->request->getPost('room_number'),
            'equipment_needed' => $this->request->getPost('equipment_needed'),
            'special_instructions' => $this->request->getPost('special_instructions'),
            'cancellation_reason' => $this->request->getPost('cancellation_reason')
        ];

        if ($this->appointmentModel->update($id, $data)) {
            return redirect()->to('/admin/appointments')->with('success', 'Appointment updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update appointment. Please try again.');
        }
    }

    /**
     * Delete appointment
     */
    public function delete($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Appointment not found');
        }

        if ($this->appointmentModel->delete($id)) {
            return redirect()->to('/admin/appointments')->with('success', 'Appointment deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete appointment. Please try again.');
        }
    }

    /**
     * Cancel appointment
     */
    public function cancel($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Appointment not found');
        }

        $data = [
            'status' => 'cancelled',
            'cancelled_by' => session('user_id'),
            'cancelled_at' => date('Y-m-d H:i:s'),
            'cancellation_reason' => $this->request->getPost('cancellation_reason')
        ];

        if ($this->appointmentModel->update($id, $data)) {
            return redirect()->to('/admin/appointments')->with('success', 'Appointment cancelled successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to cancel appointment. Please try again.');
        }
    }

    /**
     * Search appointments
     */
    public function search()
    {
        $searchTerm = $this->request->getGet('search');
        
        if (empty($searchTerm)) {
            return redirect()->to('/admin/appointments');
        }

        $appointments = $this->appointmentModel->searchAppointments($searchTerm);

        $data = [
            'title' => 'Search Results',
            'appointments' => $appointments,
            'searchTerm' => $searchTerm
        ];

        return view('Admin/appointments/index', $data);
    }

    /**
     * Get appointments calendar data (AJAX)
     */
    public function calendar()
    {
        $appointments = $this->appointmentModel->getAppointmentsWithDetails();
        $events = [];

        foreach ($appointments as $appointment) {
            $events[] = [
                'id' => $appointment['id'],
                'title' => $appointment['patient_first_name'] . ' ' . $appointment['patient_last_name'],
                'start' => $appointment['appointment_date'] . 'T' . $appointment['appointment_time'],
                'end' => date('Y-m-d\TH:i:s', strtotime($appointment['appointment_date'] . ' ' . $appointment['appointment_time'] . ' +' . $appointment['duration'] . ' minutes')),
                'backgroundColor' => $this->getStatusColor($appointment['status']),
                'extendedProps' => [
                    'appointment_id' => $appointment['appointment_id'],
                    'type' => $appointment['appointment_type'],
                    'status' => $appointment['status'],
                    'patient_phone' => $appointment['patient_phone']
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Get status color for calendar
     */
    private function getStatusColor($status)
    {
        $colors = [
            'scheduled' => '#3788d8',
            'confirmed' => '#28a745',
            'in_progress' => '#ffc107',
            'completed' => '#6f42c1',
            'cancelled' => '#dc3545',
            'no_show' => '#fd7e14',
            'rescheduled' => '#20c997'
        ];

        return $colors[$status] ?? '#6c757d';
    }
}
