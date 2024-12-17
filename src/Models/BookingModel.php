<?php

namespace App\Models;

class BookingModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getBookings(array $filters = []): array
    {
        $query = "
                SELECT 
                    b.price as price, 
                    e.name AS event_name, 
                    e.date AS event_date, e.timezone, 
                    em.name AS employee_name, 
                    em.email AS employee_email
                FROM bookings b
                    JOIN events e ON b.event_id = e.id
                    JOIN employees em ON b.employee_id = em.id
                WHERE 1=1
            ";

        $params = [];

        if (!empty($filters['employee_name'])) {
            $query .= " AND em.name LIKE :employee_name";
            $params['employee_name'] = '%' . $_GET['employee_name'] . '%';
        }

        if (!empty($filters['event_name'])) {
            $query .= " AND e.name LIKE :event_name";
            $params['event_name'] = '%' . $_GET['event_name'] . '%';
        }

        if (!empty($filters['date'])) {
            $query .= " AND DATE(e.date) = :date";
            $params['date'] = $_GET['date'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }
}
