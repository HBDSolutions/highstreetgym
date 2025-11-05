<?php
// XML IMPORT VIEW FILE

    // NORMALISE PREFILL
    $prefill = isset($prefill) ? (string)$prefill : '';
?>

<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <title>XML Import</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <main style="max-width: 720px; margin: 2rem auto; font-family: system-ui, Arial, sans-serif;">
        <h1>XML Import</h1>
        <p>Upload XML to add or update Members, Classes, or Schedules. Files must pass DTD validation.</p>

        <form method="post"
            action="/highstreetgym/controllers/content/xml_import_controller.php"
            enctype="multipart/form-data">
        <input type="hidden" name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES) ?>">

        <fieldset style="margin: 1rem 0;">
            <legend>Import Type</legend>
                <label>
                    <input type="radio" name="import_type" value="members"
                            <?= $prefill === 'members' ? 'checked' : '' ?>> Members
                </label><br>
                <label>
                <input type="radio" name="import_type" value="classes"
                        <?= $prefill === 'classes' ? 'checked' : '' ?>> Classes
                </label><br>
            <label><input type="radio" name="import_type" value="schedules" required> Schedules</label>
        </fieldset>

        <fieldset style="margin: 1rem 0;">
            <legend>Mode</legend>
            <label><input type="radio" name="mode" value="insert" checked> Insert only</label><br>
            <label><input type="radio" name="mode" value="upsert"> Upsert (update if exists)</label><br>
            <label><input type="radio" name="mode" value="dry_run"> Dry run (validate &amp; preview only)</label>
        </fieldset>

        <div style="margin: 1rem 0;">
            <label>XML File: <input type="file" name="xml_file" accept=".xml" required></label>
        </div>

        <button type="submit">Run Import</button>
        </form>

        <hr style="margin: 2rem 0;">
        <p><small>DTD location expected at: <code>/highstreetgym/public/xml/dtd/</code></small></p>
    </main>
    </body>
</html>
