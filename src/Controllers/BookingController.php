<?php

namespace App\Controllers;

use App\Models\BookingModel;

class BookingController
{
    /**
     * @var BookingModel
     */
    private $bookingModel;


    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    /**
     * @return void
     */
    public function index()
    {
        $filters = [
            'employee_name' => $_GET['employee_name'] ?? '',
            'event_name' => $_GET['event_name'] ?? '',
            'date' => $_GET['date'] ?? ''
        ];

        $results = $this->bookingModel->getBookings($filters);
        $totalPrice = array_sum(array_column($results, 'price'));

        include __DIR__ . '/../Views/index.php';
    }
}
