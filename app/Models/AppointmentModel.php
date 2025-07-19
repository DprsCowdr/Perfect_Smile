<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'appointment_id', 'patient_id', 'doctor_id', 'appointment_date', 'appointment_time',
        'duration', 'appointment_type', 'status', 'priority', 'chief_complaint', 'symptoms',
        'treatment_plan', 'diagnosis', 'treatment_notes', 'prescription', 'follow_up_required',
        'follow_up_date', 'payment_status', 'amount', 'discount', 'insurance_claim',
        'reminder_sent', 'reminder_date', 'equipment_needed',
        'special_instructions', 'cancellation_reason', 'cancelled_by', 'cancelled_at',
        'created_by', 'updated_by'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'patient_id' => 'required|integer',
        'appointment_date' => 'required|valid_date',
        'appointment_time' => 'required',
        'appointment_type' => 'required|in_list[consultation,cleaning,filling,extraction,root_canal,crown,bridge,implant,orthodontics,emergency,follow_up]',
        'status' => 'in_list[scheduled,confirmed,in_progress,completed,cancelled,no_show,rescheduled]',
        'priority' => 'in_list[low,normal,high,urgent]',
        'duration' => 'integer|greater_than[0]',
        'payment_status' => 'in_list[pending,partial,paid,refunded]',
        'amount' => 'decimal',
        'discount' => 'decimal'
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient selection is required.',
            'integer' => 'Invalid patient selected.'
        ],
        'appointment_date' => [
            'required' => 'Appointment date is required.',
            'valid_date' => 'Please enter a valid appointment date.'
        ],
        'appointment_time' => [
            'required' => 'Appointment time is required.'
        ],
        'appointment_type' => [
            'required' => 'Appointment type is required.',
            'in_list' => 'Please select a valid appointment type.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['generateAppointmentId', 'setCreatedBy'];
    protected $beforeUpdate = ['setUpdatedBy'];

    /**
     * Generate unique appointment ID before insert
     */
    protected function generateAppointmentId(array $data)
    {
        if (!isset($data['data']['appointment_id'])) {
            $lastAppointment = $this->orderBy('id', 'DESC')->first();
            $nextNumber = $lastAppointment ? (intval(substr($lastAppointment['appointment_id'], 4)) + 1) : 1;
            $data['data']['appointment_id'] = 'APT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }
        return $data;
    }

    /**
     * Set created_by field before insert
     */
    protected function setCreatedBy(array $data)
    {
        if (session()->has('user')) {
            $data['data']['created_by'] = session('user')['id'];
        }
        return $data;
    }

    /**
     * Set updated_by field before update
     */
    protected function setUpdatedBy(array $data)
    {
        if (session()->has('user')) {
            $data['data']['updated_by'] = session('user')['id'];
        }
        return $data;
    }

    /**
     * Get appointments with patient and doctor information
     */
    public function getAppointmentsWithDetails($limit = null, $offset = 0)
    {
        $builder = $this->db->table($this->table . ' a');
        $builder->select('a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, 
                         p.phone as patient_phone, p.email as patient_email, p.patient_id,
                         p.date_of_birth as patient_date_of_birth, p.address as patient_address,
                         p.emergency_contact_name as patient_emergency_contact_name,
                         p.emergency_contact_phone as patient_emergency_contact_phone,
                         u.username as doctor_username, u.email as doctor_email, u.user_type as doctor_type');
        $builder->join('patient p', 'a.patient_id = p.id', 'left');
        $builder->join('user u', 'a.doctor_id = u.id', 'left');
        $builder->orderBy('a.appointment_date', 'DESC');
        $builder->orderBy('a.appointment_time', 'ASC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get appointment by appointment ID
     */
    public function getAppointmentByAppointmentId($appointmentId)
    {
        return $this->where('appointment_id', $appointmentId)->first();
    }

    /**
     * Get appointments by patient ID
     */
    public function getAppointmentsByPatient($patientId, $limit = null)
    {
        $builder = $this->where('patient_id', $patientId);
        if ($limit) {
            $builder->limit($limit);
        }
        return $builder->orderBy('appointment_date', 'DESC')->findAll();
    }

    /**
     * Get appointments by doctor ID
     */
    public function getAppointmentsByDoctor($doctorId, $limit = null)
    {
        $builder = $this->where('doctor_id', $doctorId);
        if ($limit) {
            $builder->limit($limit);
        }
        return $builder->orderBy('appointment_date', 'DESC')->findAll();
    }

    /**
     * Get appointments for a specific date
     */
    public function getAppointmentsByDate($date)
    {
        return $this->getAppointmentsWithDetails()->where('appointment_date', $date);
    }

    /**
     * Get upcoming appointments
     */
    public function getUpcomingAppointments($days = 7)
    {
        $today = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$days} days"));
        
        return $this->where('appointment_date >=', $today)
                    ->where('appointment_date <=', $endDate)
                    ->where('status !=', 'cancelled')
                    ->orderBy('appointment_date', 'ASC')
                    ->orderBy('appointment_time', 'ASC')
                    ->findAll();
    }

    /**
     * Search appointments
     */
    public function searchAppointments($searchTerm)
    {
        $builder = $this->db->table($this->table . ' a');
        $builder->select('a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, 
                         p.phone as patient_phone, p.email as patient_email, p.patient_id,
                         u.username as doctor_username, u.email as doctor_email, u.user_type as doctor_type');
        $builder->join('patient p', 'a.patient_id = p.id', 'left');
        $builder->join('user u', 'a.doctor_id = u.id', 'left');
        
        $builder->groupStart()
                ->like('a.appointment_id', $searchTerm)
                ->orLike('p.first_name', $searchTerm)
                ->orLike('p.last_name', $searchTerm)
                ->orLike('p.phone', $searchTerm)
                ->orLike('p.patient_id', $searchTerm)
                ->orLike('u.username', $searchTerm)
                ->orLike('a.chief_complaint', $searchTerm)
                ->orLike('a.diagnosis', $searchTerm)
                ->groupEnd();
                
        $builder->orderBy('a.appointment_date', 'DESC');
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get appointment statistics
     */
    public function getAppointmentStats()
    {
        return [
            'total' => $this->countAllResults(),
            'today' => $this->where('appointment_date', date('Y-m-d'))->countAllResults(),
            'upcoming' => $this->where('appointment_date >', date('Y-m-d'))->where('status !=', 'cancelled')->countAllResults(),
            'completed' => $this->where('status', 'completed')->countAllResults(),
            'cancelled' => $this->where('status', 'cancelled')->countAllResults(),
        ];
    }

    /**
     * Check for appointment conflicts
     */
    public function checkAppointmentConflict($doctorId, $date, $time, $duration = 30, $excludeId = null)
    {
        $appointmentTime = strtotime($date . ' ' . $time);
        $endTime = $appointmentTime + ($duration * 60);
        
        $builder = $this->where('doctor_id', $doctorId)
                        ->where('appointment_date', $date)
                        ->where('status !=', 'cancelled');
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        $existingAppointments = $builder->findAll();
        
        foreach ($existingAppointments as $appointment) {
            $existingStart = strtotime($appointment['appointment_date'] . ' ' . $appointment['appointment_time']);
            $existingEnd = $existingStart + ($appointment['duration'] * 60);
            
            // Check if times overlap
            if (($appointmentTime >= $existingStart && $appointmentTime < $existingEnd) ||
                ($endTime > $existingStart && $endTime <= $existingEnd) ||
                ($appointmentTime <= $existingStart && $endTime >= $existingEnd)) {
                return $appointment;
            }
        }
        
        return false;
    }
}
