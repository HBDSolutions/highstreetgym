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

    // IMPORT MEMBERS INTO USERS TABLE
    // MATCH ON EMAIL
    // MODE: INSERT | UPSERT
    public function importMembers(string $xmlPath, string $mode = 'insert'): array
    {
        $sx = simplexml_load_file($xmlPath, 'SimpleXMLElement', LIBXML_NONET);
        if ($sx === false) {
            throw new RuntimeException('INVALID XML.');
        }

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
            return [
                'inserted' => 0,
                'updated'  => 0,
                'skipped'  => 0,
                'warnings' => [],
                'errors'   => [],
                'preview'  => array_slice($rows, 0, 5),
            ];
        }

        $inserted = $updated = $skipped = 0;
        $warnings = [];
        $errors   = [];

        $upd = $this->db->prepare("
            UPDATE users
               SET first_name=:first_name,
                   last_name=:last_name,
                   phone=:phone,
                   status=:status
             WHERE email=:email
        ");

        $ins = $this->db->prepare("
            INSERT INTO users (first_name, last_name, email, phone, user_type, status, created_at)
            VALUES (:first_name, :last_name, :email, :phone, 'member', :status, NOW())
        ");

        $this->db->beginTransaction();
        try {
            foreach ($rows as $r) {
                if (!filter_var($r['email'], FILTER_VALIDATE_EMAIL)) {
                    $warnings[] = 'INVALID EMAIL: ' . $r['email'];
                    $skipped++;
                    continue;
                }

                if ($mode === 'upsert') {
                    $upd->execute([
                        ':first_name' => $r['first_name'],
                        ':last_name'  => $r['last_name'],
                        ':phone'      => $r['phone'],
                        ':status'     => $r['status'],
                        ':email'      => $r['email'],
                    ]);
                    if ($upd->rowCount() > 0) {
                        $updated++;
                        continue;
                    }
                }

                try {
                    $ins->execute([
                        ':first_name' => $r['first_name'],
                        ':last_name'  => $r['last_name'],
                        ':email'      => $r['email'],
                        ':phone'      => $r['phone'],
                        ':status'     => $r['status'],
                    ]);
                    $inserted++;
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

        return [
            'inserted' => $inserted,
            'updated'  => $updated,
            'skipped'  => $skipped,
            'warnings' => $warnings,
            'errors'   => $errors,
        ];
    }
}
