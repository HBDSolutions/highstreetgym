<?php
declare(strict_types=1);

function getAllSchedules(PDO $conn): array
{
    $sql = "
        SELECT
            s.schedule_id,
            s.day_of_week,                                  -- Mon..Sun
            TIME_FORMAT(s.start_time, '%H:%i') AS start_time,
            TIME_FORMAT(s.end_time, '%H:%i')   AS end_time,
            s.max_capacity,
            c.class_name,
            t.first_name, t.last_name
        FROM schedules s
        INNER JOIN classes  c ON c.class_id   = s.class_id
        INNER JOIN trainers t ON t.trainer_id = s.trainer_id
        ORDER BY FIELD(s.day_of_week,'Mon','Tue','Wed','Thu','Fri','Sat','Sun'),
                 s.start_time, c.class_name
    ";
    $rows = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $map = ['Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday','Sun'=>'Sunday'];
    foreach ($rows as &$r) { $r['day_full'] = $map[$r['day_of_week']] ?? $r['day_of_week']; }
    return $rows;
}
