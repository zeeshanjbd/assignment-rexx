<?php

namespace App\Services;

use App\Helpers\VersionHandler;
use DateTime;
use DateTimeZone;
use Exception;

class BookingImporter
{
    private $db;

    public function __construct()
    {
        $this->db = Database::importConnection();
    }

    /**
     * @param string $filePath
     * @return void
     * @throws Exception
     */
    public function import(string $filePath)
    {
        $this->createDatabase();

        $data = json_decode(file_get_contents($filePath), true);
        if (!$data || !is_array($data)) {
            throw new \Exception("Invalid JSON file format.");
        }

        $employeeStmt = $this->db->prepare(
            "INSERT INTO employees (name, email) 
         VALUES (:name, :email) 
         ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)"
        );

        $eventStmt = $this->db->prepare(
            "INSERT INTO events (name, date, timezone, version) 
         VALUES (:name, :date, :timezone, :version) 
         ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)"
        );

        $bookingStmt = $this->db->prepare(
            "INSERT INTO bookings (participation_id, employee_id, event_id, price) 
         VALUES (:participation_id, :employee_id, :event_id, :price)"
        );

        foreach ($data as $item) {
            try {

                $this->validateDate($item);

                $timezone = VersionHandler::getTimezoneByVersion($item['version']);
                $eventDate = new DateTime($item['event_date'], new DateTimeZone($timezone));
                if ($timezone !== 'UTC') {
                    $eventDate->setTimezone(new DateTimeZone('UTC'));
                }

                $employeeStmt->execute([
                    'name' => trim($item['employee_name']),
                    'email' => filter_var($item['employee_mail'], FILTER_VALIDATE_EMAIL),
                ]);
                $employeeId = $this->db->lastInsertId();

                $eventStmt->execute([
                    'name' => $item['event_name'],
                    'date' => $eventDate->format('Y-m-d H:i:s'),
                    'timezone' => $timezone,
                    'version' => $item['version'],
                ]);
                $eventId = $this->db->lastInsertId();

                $bookingStmt->execute([
                    'participation_id' => $item['participation_id'],
                    'employee_id' => $employeeId,
                    'event_id' => $eventId,
                    'price' => $item['participation_fee'],
                ]);
            } catch (Exception $e) {
                throw new Exception("Error processing booking: " . $e->getMessage());
            }
        }
    }

    /**
     * @param $item
     * @return void
     * @throws Exception
     */
    private function validateDate($item)
    {
        if (empty($item['employee_name']) || empty($item['employee_mail']) ||
            empty($item['event_name']) || empty($item['event_date']) || empty($item['version'])
        ) {
            throw new Exception("Incomplete booking data: " . json_encode($item));
        }
    }

    /**
     *  Ensure that the necessary database schema exists.
     *  This method imports the schema if it does not exist.
     * @return void
     * @throws Exception
     */
    private function createDatabase()
    {
        $schemaFilePath = __DIR__ . '/../../database/create_schema.sql';
        if (!file_exists($schemaFilePath)) {
            throw new Exception("Schema file does not exist: {$schemaFilePath}");
        }

        $sql = file_get_contents($schemaFilePath);
        $this->db->exec($sql);
    }
}
