<?php
// XML IMPORT SERVICE

declare(strict_types=1);

class XmlImportService
{
    // PDO CONNECTION
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    // DTD SELECTOR
    public function dtdFor(string $type, string $dtdDir): string
    {
        $base = rtrim($dtdDir, '/\\');
        if ($type === 'members')   return $base . '/memberAdd.dtd';
        if ($type === 'classes')   return $base . '/classAdd.dtd';
        if ($type === 'schedules') return $base . '/scheduleAdd.dtd';
        throw new InvalidArgumentException('Unknown import type.');
    }

    // VALIDATE XML AGAINST DTD
    public function validateXml(string $xmlPath, string $dtdPath): void
    {
        if (!is_file($dtdPath) || !is_readable($dtdPath)) {
            throw new RuntimeException('DTD not found: ' . $dtdPath);
        }

        $dom = new DOMDocument();
        $dom->resolveExternals = false;
        $dom->substituteEntities = false;
        $dom->load($xmlPath, LIBXML_NONET);

        $impl = new DOMImplementation();
        $rootName = $dom->documentElement->nodeName;

        $abs = realpath($dtdPath);
        if ($abs === false) {
            throw new RuntimeException('Could not resolve DTD path: ' . $dtdPath);
        }
        $abs = str_replace('\\', '/', $abs);

        $dtd = $impl->createDocumentType($rootName, '', $abs);
        $newDom = $impl->createDocument('', '', $dtd);
        $newDom->encoding = 'UTF-8';
        $newDom->resolveExternals = false;
        $newDom->substituteEntities = false;
        $newDom->appendChild($newDom->importNode($dom->documentElement, true));

        libxml_use_internal_errors(true);
        $ok = $newDom->validate();
        $errs = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        if (!$ok) {
            $msgs = array_map(fn($e) => trim($e->message), $errs);
            throw new RuntimeException(implode(' | ', $msgs));
        }
    }

    // PREVIEW BUILDER
    public function preview(string $type, string $xmlPath): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) throw new RuntimeException('Invalid XML.');

        $out = [];

        if ($type === 'members') {
            $i = 0; foreach ($sx->member as $m) {
                $out[] = [
                    'first_name' => (string)$m->first_name,
                    'last_name'  => (string)$m->last_name,
                    'email'      => (string)$m->email,
                    'phone'      => (string)$m->phone,
                    'status'     => (string)$m->status,
                ];
                if (++$i >= 5) break;
            }
        } elseif ($type === 'classes') {
            $i = 0; foreach ($sx->class as $c) {
                $out[] = [
                    'class_name'       => (string)$c->class_name,
                    'description'      => (string)$c->description,
                    'duration'         => (string)$c->duration,
                    'difficulty_level' => (string)$c->difficulty_level,
                ];
                if (++$i >= 5) break;
            }
        } elseif ($type === 'schedules') {
            $i = 0; foreach ($sx->schedule as $s) {
                $out[] = [
                    'trainer_id'   => (string)$s->trainer_id,
                    'class_id'     => (string)$s->class_id,
                    'day_of_week'  => (string)$s->day_of_week,
                    'start_time'   => (string)$s->start_time,
                    'end_time'     => (string)$s->end_time,
                    'max_capacity' => (string)$s->max_capacity,
                ];
                if (++$i >= 5) break;
            }
        } else {
            throw new InvalidArgumentException('Unsupported import type for preview.');
        }

        return $out;
    }

    // IMPORT MEMBERS INTO USERS
    public function importMembers(string $xmlPath, string $mode = 'insert'): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) throw new RuntimeException('Invalid XML.');

        $rows = [];
        foreach ($sx->member as $m) {
            $rows[] = [
                'first_name' => trim((string)$m->first_name),
                'last_name'  => trim((string)$m->last_name),
                'email'      => strtolower(trim((string)$m->email)),
                'phone'      => trim((string)$m->phone),
                'status'     => trim((string)($m->status ?? 'active')),
            ];
        }

        if ($mode === 'dry_run') {
            return ['inserted'=>0,'updated'=>0,'skipped'=>0,'warnings'=>[],'errors'=>[],'preview'=>array_slice($rows,0,5)];
        }

        $inserted = $updated = $skipped = 0; $warnings = []; $errors = [];

        $upd = $this->db->prepare("
            UPDATE users
               SET first_name=:first_name, last_name=:last_name, phone=:phone, status=:status
             WHERE email=:email
        ");
        $ins = $this->db->prepare("
            INSERT INTO users (first_name,last_name,email,phone,user_type,status,created_at)
            VALUES (:first_name,:last_name,:email,:phone,'member',:status,NOW())
        ");

        $this->db->beginTransaction();
        try {
            foreach ($rows as $r) {
                if (!filter_var($r['email'], FILTER_VALIDATE_EMAIL)) {
                    $warnings[] = 'INVALID EMAIL: ' . $r['email']; $skipped++; continue;
                }
                if ($mode === 'upsert') {
                    $upd->execute([
                        ':first_name'=>$r['first_name'], ':last_name'=>$r['last_name'],
                        ':phone'=>$r['phone'], ':status'=>$r['status'], ':email'=>$r['email']
                    ]);
                    if ($upd->rowCount() > 0) { $updated++; continue; }
                }
                try {
                    $ins->execute([
                        ':first_name'=>$r['first_name'], ':last_name'=>$r['last_name'],
                        ':email'=>$r['email'], ':phone'=>$r['phone'], ':status'=>$r['status']
                    ]);
                    $inserted++;
                } catch (PDOException $e) {
                    $errors[] = 'ROW ERROR: ' . $e->getMessage(); $skipped++;
                }
            }
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack(); throw $e;
        }

        return ['inserted'=>$inserted,'updated'=>$updated,'skipped'=>$skipped,'warnings'=>$warnings,'errors'=>$errors];
    }

    // IMPORT CLASSES
    public function importClasses(string $xmlPath, string $mode = 'insert'): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) throw new RuntimeException('Invalid XML.');

        $rows = [];
        foreach ($sx->class as $c) {
            $rows[] = [
                'class_name'       => trim((string)$c->class_name),
                'description'      => trim((string)$c->description),
                'duration'         => (int)($c->duration ?? 0),
                'difficulty_level' => trim((string)($c->difficulty_level ?? 'all')),
            ];
        }

        if ($mode === 'dry_run') {
            return ['inserted'=>0,'updated'=>0,'skipped'=>0,'warnings'=>[],'errors'=>[],'preview'=>array_slice($rows,0,5)];
        }

        $inserted = $updated = $skipped = 0; $warnings = []; $errors = [];

        $sel = $this->db->prepare('SELECT class_id FROM classes WHERE class_name = :class_name');
        $upd = $this->db->prepare('
            UPDATE classes SET description=:description, duration=:duration, difficulty_level=:difficulty_level
            WHERE class_name=:class_name
        ');
        $ins = $this->db->prepare('
            INSERT INTO classes (class_name,description,duration,difficulty_level)
            VALUES (:class_name,:description,:duration,:difficulty_level)
        ');

        $this->db->beginTransaction();
        try {
            foreach ($rows as $r) {
                if ($r['class_name'] === '') { $warnings[]='MISSING CLASS_NAME'; $skipped++; continue; }
                $sel->execute([':class_name'=>$r['class_name']]);
                $exists = (bool)$sel->fetchColumn();

                try {
                    if ($exists && $mode === 'upsert') {
                        $upd->execute([
                            ':description'=>$r['description'], ':duration'=>$r['duration'],
                            ':difficulty_level'=>$r['difficulty_level'], ':class_name'=>$r['class_name']
                        ]);
                        $updated++;
                    } elseif (!$exists) {
                        $ins->execute([
                            ':class_name'=>$r['class_name'], ':description'=>$r['description'],
                            ':duration'=>$r['duration'], ':difficulty_level'=>$r['difficulty_level']
                        ]);
                        $inserted++;
                    } else {
                        $skipped++;
                    }
                } catch (PDOException $e) {
                    $errors[] = 'ROW ERROR: ' . $e->getMessage(); $skipped++;
                }
            }
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack(); throw $e;
        }

        return ['inserted'=>$inserted,'updated'=>$updated,'skipped'=>$skipped,'warnings'=>$warnings,'errors'=>$errors];
    }

    // IMPORT SCHEDULES
    public function importSchedules(string $xmlPath, string $mode = 'insert'): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) throw new RuntimeException('Invalid XML.');

        // VALID DAYS
        $validDays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

        // NORMALISE AND COLLECT ROWS
        $rows = [];
        foreach ($sx->schedule as $s) {
            $day = trim((string)$s->day_of_week);
            // NORMALISE DAY TO FIRST 3 CHARS, CAPITALISED
            if ($day !== '') {
                $day = ucfirst(strtolower(substr($day, 0, 3)));
            }

            $start = trim((string)$s->start_time);
            $end   = trim((string)$s->end_time);

            // COERCE TIMES TO HH:MM:SS
            $start = preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $start) ? (strlen($start) === 5 ? $start . ':00' : $start) : '';
            $end   = preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $end)   ? (strlen($end)   === 5 ? $end   . ':00' : $end)   : '';

            $rows[] = [
                'trainer_id'   => (int)$s->trainer_id,
                'class_id'     => (int)$s->class_id,
                'day_of_week'  => $day,
                'start_time'   => $start,
                'end_time'     => $end,
                'max_capacity' => ($s->max_capacity === null || $s->max_capacity === '') ? null : (int)$s->max_capacity,
            ];
        }

        if ($mode === 'dry_run') {
            return ['inserted'=>0,'updated'=>0,'skipped'=>0,'warnings'=>[],'errors'=>[],'preview'=>array_slice($rows,0,5)];
        }

        $inserted = $updated = $skipped = 0; $warnings = []; $errors = [];

        // PREPARE STATEMENTS
        $ensureTC = $this->db->prepare('
            INSERT IGNORE INTO trainer_class (trainer_id, class_id)
            VALUES (:trainer_id, :class_id)
        ');
        $sel = $this->db->prepare('
            SELECT schedule_id FROM schedules
            WHERE trainer_id=:trainer_id AND class_id=:class_id AND day_of_week=:day_of_week AND start_time=:start_time
        ');
        $upd = $this->db->prepare('
            UPDATE schedules
            SET end_time=:end_time, max_capacity=:max_capacity
            WHERE schedule_id=:schedule_id
        ');
        $ins = $this->db->prepare('
            INSERT INTO schedules (class_id, trainer_id, day_of_week, start_time, end_time, max_capacity)
            VALUES (:class_id, :trainer_id, :day_of_week, :start_time, :end_time, :max_capacity)
        ');

        // DEDUPE WITHIN THE SAME FILE
        $seen = [];

        $this->db->beginTransaction();
        try {
            foreach ($rows as $r) {
                // REQUIRED FIELDS
                if ($r['trainer_id'] <= 0 || $r['class_id'] <= 0) {
                    $warnings[] = 'MISSING TRAINER OR CLASS';
                    $skipped++;
                    continue;
                }
                if ($r['day_of_week'] === '' || !in_array($r['day_of_week'], $validDays, true)) {
                    $warnings[] = 'INVALID DAY: ' . ($r['day_of_week'] === '' ? '(empty)' : $r['day_of_week']);
                    $skipped++;
                    continue;
                }
                if ($r['start_time'] === '') {
                    $warnings[] = 'INVALID START TIME';
                    $skipped++;
                    continue;
                }

                // DEDUPE KEY
                $key = $r['trainer_id'].'-'.$r['class_id'].'-'.$r['day_of_week'].'-'.$r['start_time'];
                if (isset($seen[$key])) {
                    $warnings[] = 'DUPLICATE IN FILE: ' . $key;
                    $skipped++;
                    continue;
                }
                $seen[$key] = true;

                // ENSURE TRAINER_CLASS LINK
                $ensureTC->execute([':trainer_id'=>$r['trainer_id'], ':class_id'=>$r['class_id']]);

                // FIND EXISTING
                $sel->execute([
                    ':trainer_id'=>$r['trainer_id'],
                    ':class_id'=>$r['class_id'],
                    ':day_of_week'=>$r['day_of_week'],
                    ':start_time'=>$r['start_time'],
                ]);
                $scheduleId = $sel->fetchColumn();

                try {
                    if ($scheduleId && $mode === 'upsert') {
                        $upd->execute([
                            ':end_time'    => $r['end_time'] === '' ? null : $r['end_time'],
                            ':max_capacity'=> $r['max_capacity'],
                            ':schedule_id' => $scheduleId,
                        ]);
                        $updated++;
                    } elseif (!$scheduleId) {
                        $ins->execute([
                            ':class_id'     => $r['class_id'],
                            ':trainer_id'   => $r['trainer_id'],
                            ':day_of_week'  => $r['day_of_week'],
                            ':start_time'   => $r['start_time'],
                            ':end_time'     => $r['end_time'] === '' ? null : $r['end_time'],
                            ':max_capacity' => $r['max_capacity'],
                        ]);
                        $inserted++;
                    } else {
                        $skipped++;
                    }
                } catch (PDOException $e) {
                    $errors[] = 'ROW ERROR: ' . $e->getMessage();
                    $skipped++;
                }
            }
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }

        return ['inserted'=>$inserted,'updated'=>$updated,'skipped'=>$skipped,'warnings'=>$warnings,'errors'=>$errors];
    }
}
