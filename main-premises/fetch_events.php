<?php
header('Content-Type: application/json');


// Database Configuration
$host = 'localhost';
$db   = 'mrbsnew';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Get the selected date from the request, default to today
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    // Create Unix Timestamps for the start and end of the selected day
    $startOfDay = strtotime($date . " 00:00:00");
    $endOfDay   = strtotime($date . " 23:59:59");

    $sql = "SELECT e.id, 
                   e.name AS event_name, 
                   e.type AS event_type, 
                   a.area_name AS floor_num, 
                   r.room_name, 
                   -- Formatting times for display
                   FROM_UNIXTIME(e.start_time, '%h:%i %p') AS start_time, 
                   FROM_UNIXTIME(e.end_time, '%h:%i %p') AS end_time,
                   -- Raw timestamps for JS multi-day logic
                   e.start_time AS raw_start,
                   e.end_time AS raw_end
            FROM mrbs_entry e
            JOIN mrbs_room r ON e.room_id = r.id
            JOIN mrbs_area a ON r.area_id = a.id
            WHERE (
                e.start_time <= :end_of_day AND e.end_time >= :start_of_day
            )
            AND e.status = 0
            ORDER BY e.start_time ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'start_of_day' => $startOfDay,
        'end_of_day'   => $endOfDay
    ]);
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database Connection Failed', 
        'details' => 'Please check the server status.'
    ]);
}