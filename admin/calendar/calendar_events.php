<?php
require_once '../backend/_db_mysql.php';

// .events.load() passes start and end as query string parameters by default
//$start = "2020-12-01 10:00:00";
//$end = "2025-12-01 10:00:00";
    
$stmt = $db->prepare('SELECT * FROM appointments');

//$stmt->bindParam(':start', $start);
//$stmt->bindParam(':end', $end);

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['id'];
  $e->text = $row['name'] . ' - ' . $row['phone'];
  $e->start = $row['appoint_date'] . ' ' . $row['appoint_time'] . ':00:00';
  $e->end = $row['appoint_date'] . ' ' . ($row['appoint_time'] + 1) . ':00:00';
  $e->backColor = $row['color'];
  $e->phone = $row['phone'];
  $e->email = $row['email'];
  $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);
