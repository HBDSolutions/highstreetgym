<?php
// CLASS FUNCTIONS MODEL
declare(strict_types=1);

function getAllSchedules(PDO $conn): array
{
    $sql = "
        SELECT
            s.schedule_id,
            s.day_of_week,
            TIME_FORMAT(s.start_time, '%H:%i') AS start_time,
            TIME_FORMAT(s.end_time, '%H:%i') AS end_time,
            s.max_capacity,
            c.class_name,
            c.description,
            t.first_name,
            t.last_name
        FROM schedules s
        JOIN classes  c ON c.class_id = s.class_id
        JOIN trainers t ON t.trainer_id = s.trainer_id
        ORDER BY FIELD(s.day_of_week, 'Mon','Tue','Wed','Thu','Fri','Sat','Sun'),
                 s.start_time
    ";
    $stmt = $conn->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Optional: expand to full names for readability in view
    $map = [
        'Mon' => 'Monday',
        'Tue' => 'Tuesday',
        'Wed' => 'Wednesday',
        'Thu' => 'Thursday',
        'Fri' => 'Friday',
        'Sat' => 'Saturday',
        'Sun' => 'Sunday'
    ];

    foreach ($rows as &$row) {
        $row['day_full'] = $map[$row['day_of_week']] ?? $row['day_of_week'];
    }

    return $rows;
}