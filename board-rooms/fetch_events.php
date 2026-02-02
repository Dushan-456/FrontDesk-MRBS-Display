<?php
header('Content-Type: application/json');

// Database Configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'mrbsnew'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    $startOfDay = strtotime($date . " 00:00:00");
    $endOfDay   = strtotime($date . " 23:59:59");


    $sql = "
        (SELECT e.id, e.name AS event_name, e.type AS event_type, a.area_name AS floor_num, r.room_name, 
                FROM_UNIXTIME(e.start_time, '%h:%i %p') AS start_time, 
                FROM_UNIXTIME(e.end_time, '%h:%i %p') AS end_time,
                e.start_time AS raw_start, e.end_time AS raw_end
         FROM mrbsnew.mrbs_entry e
         JOIN mrbsnew.mrbs_room r ON e.room_id = r.id
         JOIN mrbsnew.mrbs_area a ON r.area_id = a.id
         WHERE e.start_time <= :end_of_day AND e.end_time >= :start_of_day 
         AND e.status = 0 
         AND a.area_name = 'Boardrooms')
        
        UNION ALL
        
        (SELECT e.id, e.name AS event_name, e.type AS event_type, a.area_name AS floor_num, r.room_name, 
                FROM_UNIXTIME(e.start_time, '%h:%i %p') AS start_time, 
                FROM_UNIXTIME(e.end_time, '%h:%i %p') AS end_time,
                e.start_time AS raw_start, e.end_time AS raw_end
         FROM br_v.mrbs_entry e
         JOIN br_v.mrbs_room r ON e.room_id = r.id
         JOIN br_v.mrbs_area a ON r.area_id = a.id
         WHERE e.start_time <= :end_of_day AND e.end_time >= :start_of_day 
         AND e.status = 0 
         AND a.area_name = 'Board Room V')
        
        ORDER BY raw_start ASC";

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
        'details' => $e->getMessage() 
    ]);
}