<?php
/**
 * J-MEP — DB Viewer + Full CRUD
 * Internal tool only. DELETE or password-protect on production!
 */

session_start();
// Reuse the salon's DB credentials (config/config.php), but make our own
// mysqli connection — the salon app itself uses PDO. Password gate unchanged.
require_once __DIR__ . '/../config/config.php';

if (!function_exists('db')) {
    function db() {
        static $c = null;
        if ($c instanceof mysqli) return $c;
        $c = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int) DB_PORT);
        if ($c) mysqli_set_charset($c, 'utf8mb4');
        return $c ?: null;
    }
}

// ── SIMPLE PASSWORD GATE ─────────────────────────────────────
$VIEWER_PASS = 'qweasdzxc';
if (!isset($_SESSION['dbv_auth'])) {
    if (($_POST['dbv_pass'] ?? '') === $VIEWER_PASS) {
        $_SESSION['dbv_auth'] = true;
    } else {
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>DB Viewer</title>
        <style>body{font-family:monospace;background:#111;color:#eee;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}
        form{background:#1e1e1e;padding:24px;border-radius:8px;border:1px solid #333}
        input{display:block;width:260px;padding:8px;margin:8px 0;background:#2a2a2a;border:1px solid #444;color:#eee;border-radius:4px}
        button{padding:8px 18px;background:#2563eb;border:none;color:#fff;cursor:pointer;border-radius:4px}
        </style></head><body><form method="post"><b>DB Viewer</b><br><br>
        <input type="password" name="dbv_pass" placeholder="Password" autofocus>
        <button type="submit">Login</button></form></body></html>';
        exit;
    }
}

// ── DB CONNECTION (J-MEP) ─────────────────────────────────────
$conn = db();
if (!$conn) {
    die('<p style="font-family:monospace;color:red;padding:20px">DB connection failed. Check config.php credentials.</p>');
}

// ── GET ALL TABLES ────────────────────────────────────────────
$tables = [];
$res = mysqli_query($conn, "SHOW TABLES");
while ($r = mysqli_fetch_row($res)) $tables[] = $r[0];
sort($tables);

// ── ACTIVE TABLE ─────────────────────────────────────────────
$t = isset($_GET['t']) && in_array($_GET['t'], $tables) ? $_GET['t'] : ($tables[0] ?? '');

// ── HELPERS ──────────────────────────────────────────────────
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function url($p = []) {
    global $t;
    $base = ['t' => $t, 'page' => ($_GET['page'] ?? 1)];
    return '?' . http_build_query(array_merge($base, $p));
}

// ── GET TABLE COLUMNS ─────────────────────────────────────────
function get_columns($conn, $table) {
    $cols = [];
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `" . mysqli_real_escape_string($conn, $table) . "`");
    while ($r = mysqli_fetch_assoc($res)) $cols[] = $r;
    return $cols;
}

function get_pk($conn, $table) {
    $cols = get_columns($conn, $table);
    foreach ($cols as $c) if ($c['Key'] === 'PRI') return $c['Field'];
    return null;
}

// ── DUMP FUNCTIONS ───────────────────────────────────────────
function dump_database($conn, $tables, $include_data = true) {
    $output = "-- J-MEP Database Dump\n";
    $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
    $output .= "-- Include Data: " . ($include_data ? 'Yes' : 'No (Structure Only)') . "\n\n";
    $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
    
    foreach ($tables as $table) {
        $output .= dump_table_structure($conn, $table);
        if ($include_data) {
            $output .= dump_table_data($conn, $table);
        } else {
            $output .= "-- No data exported for `$table` (structure only)\n\n";
        }
    }
    
    $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
    return $output;
}

function dump_table_structure($conn, $table) {
    $output = "--\n-- Table structure for `$table`\n--\n";
    $output .= "DROP TABLE IF EXISTS `$table`;\n";
    
    $result = mysqli_query($conn, "SHOW CREATE TABLE `" . mysqli_real_escape_string($conn, $table) . "`");
    if ($result) {
        $row = mysqli_fetch_row($result);
        $output .= $row[1] . ";\n\n";
    }
    return $output;
}

function dump_table_data($conn, $table) {
    $output = "--\n-- Dumping data for `$table`\n--\n";
    $output .= "/*!40000 ALTER TABLE `$table` DISABLE KEYS */;\n";
    
    $result = mysqli_query($conn, "SELECT * FROM `" . mysqli_real_escape_string($conn, $table) . "`");
    if ($result && mysqli_num_rows($result) > 0) {
        $fields = [];
        while ($finfo = mysqli_fetch_field($result)) {
            $fields[] = $finfo->name;
        }
        
        $row_count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $values = [];
            foreach ($fields as $field) {
                $value = $row[$field];
                if ($value === null) {
                    $values[] = "NULL";
                } else {
                    $values[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
                }
            }
            $output .= "INSERT INTO `$table` (`" . implode("`, `", $fields) . "`) VALUES (" . implode(", ", $values) . ");\n";
            $row_count++;
            if ($row_count % 100 == 0) {
                $output .= "\n";
            }
        }
    } else {
        $output .= "-- No data\n";
    }
    
    $output .= "/*!40000 ALTER TABLE `$table` ENABLE KEYS */;\n\n";
    return $output;
}

function dump_single_table($conn, $table, $include_data = true) {
    $output = "-- J-MEP Table Dump: `$table`\n";
    $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
    $output .= "-- Include Data: " . ($include_data ? 'Yes' : 'No (Structure Only)') . "\n\n";
    $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
    $output .= dump_table_structure($conn, $table);
    if ($include_data) {
        $output .= dump_table_data($conn, $table);
    } else {
        $output .= "-- No data exported for `$table` (structure only)\n\n";
    }
    $output .= "SET FOREIGN_KEY_CHECKS=1;\n";
    return $output;
}

// ── HANDLE DUMP REQUESTS ─────────────────────────────────────
if (isset($_GET['dump']) && $_GET['dump'] === 'full') {
    $include_data = !isset($_GET['no_data']);
    $dump_content = dump_database($conn, $tables, $include_data);
    $filename = 'db_dump_' . ($include_data ? 'withdata_' : 'structure_') . date('Ymd_His') . '.sql';
    
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($dump_content));
    header('Cache-Control: must-revalidate');
    echo $dump_content;
    exit;
}

if (isset($_GET['dump_table']) && $_GET['dump_table'] && in_array($_GET['dump_table'], $tables)) {
    $include_data = !isset($_GET['no_data']);
    $dump_content = dump_single_table($conn, $_GET['dump_table'], $include_data);
    $filename = 'table_' . $_GET['dump_table'] . '_' . ($include_data ? 'withdata_' : 'structure_') . date('Ymd_His') . '.sql';
    
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($dump_content));
    header('Cache-Control: must-revalidate');
    echo $dump_content;
    exit;
}

$msg = '';

// ── HANDLE SQL IMPORT ────────────────────────────────────────
$import_msg = '';
$import_err = '';
if (isset($_POST['_action']) && $_POST['_action'] === 'import_sql') {
    if (isset($_FILES['sql_file']) && $_FILES['sql_file']['error'] === UPLOAD_ERR_OK) {
        $tmpFile = $_FILES['sql_file']['tmp_name'];
        $origName = $_FILES['sql_file']['name'];
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        if ($ext !== 'sql') {
            $import_err = "Only .sql files are allowed.";
        } else {
            $sqlContent = file_get_contents($tmpFile);
            if ($sqlContent === false) {
                $import_err = "Failed to read uploaded file.";
            } else {
                // Split on semicolons but ignore those inside quotes
                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");
                $success = 0; $errors = [];
                // Use multi_query for full SQL dump compatibility
                if (mysqli_multi_query($conn, $sqlContent)) {
                    do {
                        if ($r = mysqli_store_result($conn)) mysqli_free_result($r);
                        $success++;
                    } while (mysqli_next_result($conn));
                }
                if ($e = mysqli_error($conn)) {
                    $errors[] = $e;
                }
                mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
                // Refresh table list
                $tables = [];
                $res2 = mysqli_query($conn, "SHOW TABLES");
                while ($r = mysqli_fetch_row($res2)) $tables[] = $r[0];
                sort($tables);
                if (empty($errors)) {
                    $import_msg = "✅ SQL file '<strong>" . h($origName) . "</strong>' imported successfully.";
                } else {
                    $import_err = "⚠️ Import finished with errors: " . implode('; ', $errors);
                }
            }
        }
    } else {
        $import_err = "No file uploaded or upload error (code: " . ($_FILES['sql_file']['error'] ?? 'N/A') . ").";
    }
}

// ── HANDLE CREATE DATABASE ────────────────────────────────────
$createdb_msg = '';
$createdb_err = '';
if (isset($_POST['_action']) && $_POST['_action'] === 'create_db') {
    $new_db = trim($_POST['new_db_name'] ?? '');
    $new_db_charset = $_POST['new_db_charset'] ?? 'utf8mb4';
    $new_db_collate = $_POST['new_db_collate'] ?? 'utf8mb4_unicode_ci';
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $new_db)) {
        $createdb_err = "Invalid database name. Use only letters, numbers, and underscores.";
    } else {
        $sql_create = "CREATE DATABASE IF NOT EXISTS `" . mysqli_real_escape_string($conn, $new_db) . "`
                       CHARACTER SET " . mysqli_real_escape_string($conn, $new_db_charset) . "
                       COLLATE " . mysqli_real_escape_string($conn, $new_db_collate);
        if (mysqli_query($conn, $sql_create)) {
            $createdb_msg = "✅ Database '<strong>" . h($new_db) . "</strong>' created successfully.";
        } else {
            $createdb_err = "Error: " . mysqli_error($conn);
        }
    }
}

// ── HANDLE ACTIONS ────────────────────────────────────────────
$action = $_POST['_action'] ?? $_GET['action'] ?? '';

// DELETE ROW
if ($action === 'delete' && $t) {
    $pk  = get_pk($conn, $t);
    $id  = $_GET['id'] ?? null;
    if ($pk && $id !== null) {
        $esc = mysqli_real_escape_string($conn, $t);
        $epk = mysqli_real_escape_string($conn, $pk);
        $eid = mysqli_real_escape_string($conn, $id);
        mysqli_query($conn, "DELETE FROM `$esc` WHERE `$epk` = '$eid' LIMIT 1");
        $msg = "Row deleted.";
    }
    header("Location: " . url(['action' => '', 'id' => '', 'msg' => urlencode($msg)]));
    exit;
}

// INSERT ROW
if ($action === 'insert' && $t) {
    $cols = get_columns($conn, $t);
    $fields = $vals = [];
    foreach ($cols as $c) {
        $field = $c['Field'];
        if ($c['Extra'] === 'auto_increment') continue;
        if (!isset($_POST[$field])) continue;
        $v = $_POST[$field];
        if ($v === '' && strpos($c['Null'], 'YES') !== false) {
            $fields[] = "`" . mysqli_real_escape_string($conn, $field) . "`";
            $vals[]   = "NULL";
        } else {
            $fields[] = "`" . mysqli_real_escape_string($conn, $field) . "`";
            $vals[]   = "'" . mysqli_real_escape_string($conn, $v) . "'";
        }
    }
    if ($fields) {
        $sql = "INSERT INTO `" . mysqli_real_escape_string($conn, $t) . "` (" . implode(',', $fields) . ") VALUES (" . implode(',', $vals) . ")";
        if (mysqli_query($conn, $sql)) $msg = "Row inserted. ID=" . mysqli_insert_id($conn);
        else $msg = "Error: " . mysqli_error($conn);
    }
    header("Location: " . url(['action' => '', 'msg' => urlencode($msg)]));
    exit;
}

// UPDATE ROW
if ($action === 'update' && $t) {
    $pk  = get_pk($conn, $t);
    $id  = $_POST['_pk_val'] ?? null;
    $cols = get_columns($conn, $t);
    $sets = [];
    foreach ($cols as $c) {
        $field = $c['Field'];
        if ($field === $pk) continue;
        if (!isset($_POST[$field])) continue;
        $v = $_POST[$field];
        if ($v === '' && strpos($c['Null'], 'YES') !== false)
            $sets[] = "`" . mysqli_real_escape_string($conn, $field) . "` = NULL";
        else
            $sets[] = "`" . mysqli_real_escape_string($conn, $field) . "` = '" . mysqli_real_escape_string($conn, $v) . "'";
    }
    if ($sets && $pk && $id !== null) {
        $sql = "UPDATE `" . mysqli_real_escape_string($conn, $t) . "` SET " . implode(', ', $sets) . " WHERE `" . mysqli_real_escape_string($conn, $pk) . "` = '" . mysqli_real_escape_string($conn, $id) . "' LIMIT 1";
        if (mysqli_query($conn, $sql)) $msg = "Row updated.";
        else $msg = "Error: " . mysqli_error($conn);
    }
    header("Location: " . url(['action' => '', 'msg' => urlencode($msg)]));
    exit;
}

// RUN CUSTOM SQL (supports multiple queries)
if ($action === 'sql') {
    $sql = trim($_POST['raw_sql'] ?? '');
    $sql_result = null;
    $sql_error  = null;
    $sql_rows   = [];
    $sql_cols   = [];
    $sql_affected = null;
    
    if ($sql) {
        // Check if this is a multi-query (contains multiple semicolons)
        $is_multi = substr_count($sql, ';') > 1 || (substr_count($sql, ';') === 1 && trim(substr($sql, strrpos($sql, ';') + 1)) !== '');
        
        if ($is_multi) {
            // Use multi_query for multiple statements
            if (mysqli_multi_query($conn, $sql)) {
                $total_affected = 0;
                $has_select = false;
                
                do {
                    // Store result if it's a SELECT query
                    if ($result = mysqli_store_result($conn)) {
                        $has_select = true;
                        // Get column names
                        $sql_cols = [];
                        while ($finfo = mysqli_fetch_field($result)) {
                            $sql_cols[] = $finfo->name;
                        }
                        // Get rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql_rows[] = $row;
                        }
                        mysqli_free_result($result);
                    } else {
                        // For UPDATE/INSERT/DELETE queries
                        if (mysqli_errno($conn)) {
                            $sql_error = mysqli_error($conn);
                            break;
                        }
                        $total_affected += mysqli_affected_rows($conn);
                    }
                } while (mysqli_next_result($conn));
                
                // Set the affected count if no SELECT was executed
                if (!$has_select && !$sql_error) {
                    $sql_affected = $total_affected;
                }
            } else {
                $sql_error = mysqli_error($conn);
            }
        } else {
            // Single query - use the original method
            $r = mysqli_query($conn, $sql);
            if ($r === false) {
                $sql_error = mysqli_error($conn);
            } elseif ($r === true) {
                $sql_affected = mysqli_affected_rows($conn);
            } else {
                $fc = mysqli_num_fields($r);
                for ($i = 0; $i < $fc; $i++) $sql_cols[] = mysqli_fetch_field_direct($r, $i)->name;
                while ($row = mysqli_fetch_assoc($r)) $sql_rows[] = $row;
            }
        }
    }
}

// ── FETCH TABLE DATA ──────────────────────────────────────────
$pk      = $t ? get_pk($conn, $t) : null;
$cols    = $t ? get_columns($conn, $t) : [];
$perPage = max(1, (int)($_GET['per_page'] ?? 50));
$page    = max(1, (int)($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;
$search  = trim($_GET['s'] ?? '');
$totalRows = 0;
$rows    = [];

// Edit row fetch
$edit_row = null;
if (($action === 'edit' || isset($_GET['edit_id'])) && $t && $pk) {
    $edit_id = $_GET['edit_id'] ?? $_GET['id'] ?? null;
    if ($edit_id !== null) {
        $r = mysqli_query($conn, "SELECT * FROM `" . mysqli_real_escape_string($conn, $t) . "` WHERE `" . mysqli_real_escape_string($conn, $pk) . "` = '" . mysqli_real_escape_string($conn, $edit_id) . "' LIMIT 1");
        if ($r) $edit_row = mysqli_fetch_assoc($r);
    }
}

if ($t) {
    $et = mysqli_real_escape_string($conn, $t);
    $where = '';
    if ($search && $cols) {
        $parts = [];
        foreach ($cols as $c) {
            $parts[] = "`" . mysqli_real_escape_string($conn, $c['Field']) . "` LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
        }
        $where = 'WHERE ' . implode(' OR ', $parts);
    }
    $cr = mysqli_query($conn, "SELECT COUNT(*) FROM `$et` $where");
    if ($cr) $totalRows = (int)mysqli_fetch_row($cr)[0];
    $totalPages = max(1, (int)ceil($totalRows / $perPage));

    $res = mysqli_query($conn, "SELECT * FROM `$et` $where LIMIT $perPage OFFSET $offset");
    if ($res) while ($r = mysqli_fetch_assoc($res)) $rows[] = $r;
} else {
    $totalPages = 1;
}

if (isset($_GET['msg'])) $msg = urldecode($_GET['msg']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>DB Viewer — J-MEP</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Courier New',monospace;font-size:13px;background:#0f1117;color:#e2e8f0;display:flex;height:100vh;overflow:hidden}

/* SIDEBAR */
#sidebar{width:220px;min-width:220px;background:#161b27;border-right:1px solid #1e2d40;overflow-y:auto;display:flex;flex-direction:column}
#sidebar h2{padding:12px 14px;font-size:11px;color:#4a6fa5;text-transform:uppercase;letter-spacing:.1em;border-bottom:1px solid #1e2d40;flex-shrink:0}
.tbl-link{display:block;padding:5px 14px;color:#94a3b8;text-decoration:none;font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;border-left:2px solid transparent}
.tbl-link:hover{background:#1e2d40;color:#e2e8f0}
.tbl-link.active{background:#1e2d40;color:#60a5fa;border-left-color:#3b82f6;font-weight:bold}
#sidebar-footer{padding:10px 14px;border-top:1px solid #1e2d40;flex-shrink:0}
#sidebar-footer .dump-section{margin:6px 0 8px 0}
#sidebar-footer .dump-title{font-size:10px;color:#64748b;margin-bottom:4px;font-weight:bold}
#sidebar-footer a{font-size:11px;color:#64748b;text-decoration:none;display:block;margin:4px 0;padding:3px 6px;border-radius:3px}
#sidebar-footer a:hover{background:#1e2d40;color:#e2e8f0}
#sidebar-footer .dump-link{color:#f59e0b}
#sidebar-footer .dump-link:hover{background:#1e2d40;color:#fbbf24}
#sidebar-footer .dump-link-structure{color:#10b981}
#sidebar-footer .dump-link-structure:hover{background:#1e2d40;color:#34d399}
#sidebar-footer .logout-link{color:#ef4444;margin-top:8px;border-top:1px solid #1e2d40;padding-top:8px}
#sidebar-footer .logout-link:hover{background:#1e2d40;color:#f87171}

/* MAIN */
#main{flex:1;display:flex;flex-direction:column;overflow:hidden}
#topbar{background:#161b27;border-bottom:1px solid #1e2d40;padding:8px 16px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;flex-shrink:0}
#topbar strong{color:#60a5fa;font-size:14px}
#topbar span{color:#64748b;font-size:12px}
.toolbar{display:flex;gap:6px;align-items:center;flex-wrap:wrap;margin-left:auto}
.toolbar input[type=text]{padding:5px 8px;background:#1e2d40;border:1px solid #2d3f57;color:#e2e8f0;border-radius:4px;font-family:monospace;font-size:12px;width:180px}
.toolbar select{padding:5px 8px;background:#1e2d40;border:1px solid #2d3f57;color:#e2e8f0;border-radius:4px;font-family:monospace;font-size:12px}
.btn{display:inline-flex;align-items:center;gap:4px;padding:5px 10px;border-radius:4px;font-family:monospace;font-size:12px;cursor:pointer;border:none;text-decoration:none;white-space:nowrap}
.btn-blue{background:#1d4ed8;color:#fff}.btn-blue:hover{background:#2563eb}
.btn-green{background:#15803d;color:#fff}.btn-green:hover{background:#16a34a}
.btn-red{background:#7f1d1d;color:#fca5a5}.btn-red:hover{background:#991b1b}
.btn-yellow{background:#854d0e;color:#fde68a}.btn-yellow:hover{background:#92400e}
.btn-gray{background:#1e2d40;color:#94a3b8;border:1px solid #2d3f57}.btn-gray:hover{color:#e2e8f0}
.btn-sm{padding:3px 7px;font-size:11px}
.btn-purple{background:#6b21a5;color:#e9d5ff}.btn-purple:hover{background:#7e22ce}
.btn-cyan{background:#0e7490;color:#cffafe}.btn-cyan:hover{background:#0891b2}
.btn-teal{background:#115e59;color:#99f6e4}.btn-teal:hover{background:#0f766e}
.btn-group{display:inline-flex;gap:2px}
.btn-group .btn{border-radius:0}
.btn-group .btn:first-child{border-radius:4px 0 0 4px}
.btn-group .btn:last-child{border-radius:0 4px 4px 0}

#msg-bar{padding:6px 16px;font-size:12px;background:#1a2e1a;color:#86efac;border-bottom:1px solid #166534;flex-shrink:0}
#msg-bar.err{background:#2e1a1a;color:#fca5a5;border-color:#7f1d1d}

/* CONTENT AREA */
#content{flex:1;overflow-y:auto;padding:0}

/* TABLE */
.tbl-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:12px}
thead th{background:#1a2535;color:#7dd3fc;padding:7px 10px;text-align:left;white-space:nowrap;border-bottom:1px solid #1e2d40;position:sticky;top:0;z-index:2}
tbody tr:nth-child(even){background:#0f1520}
tbody tr:hover{background:#1a2535}
td{padding:5px 10px;border-bottom:1px solid #1a2535;vertical-align:top;max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
td:hover{white-space:normal;word-break:break-all;max-width:none;background:#1e2d40}
.null-v{color:#4a5568;font-style:italic}
.td-actions{display:flex;gap:4px;white-space:nowrap}

/* FORM PANEL */
.form-panel{background:#161b27;border-bottom:1px solid #1e2d40;padding:14px 16px}
.form-panel h3{font-size:13px;color:#60a5fa;margin-bottom:12px}
.form-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:8px}
.form-field label{display:block;font-size:11px;color:#64748b;margin-bottom:3px;text-transform:uppercase;letter-spacing:.05em}
.form-field input,.form-field textarea,.form-field select{width:100%;padding:6px 8px;background:#0f1520;border:1px solid #2d3f57;color:#e2e8f0;border-radius:4px;font-family:monospace;font-size:12px}
.form-field input:focus,.form-field textarea:focus{outline:none;border-color:#3b82f6}
.form-field textarea{height:60px;resize:vertical}
.form-actions-row{margin-top:10px;display:flex;gap:6px}

/* SQL PANEL */
.sql-panel{background:#161b27;border-bottom:1px solid #1e2d40;padding:14px 16px}
.sql-panel h3{font-size:13px;color:#f59e0b;margin-bottom:8px}
.sql-panel textarea{width:100%;height:80px;padding:8px;background:#0f1520;border:1px solid #2d3f57;color:#e2e8f0;border-radius:4px;font-family:monospace;font-size:13px;resize:vertical}
.sql-result{margin-top:10px;font-size:12px}
.sql-result .err{color:#fca5a5}
.sql-result .ok{color:#86efac}

/* IMPORT / CREATE DB PANELS */
.import-panel,.createdb-panel{background:#161b27;border-bottom:1px solid #1e2d40;padding:14px 16px}
.import-panel h3{font-size:13px;color:#a78bfa;margin-bottom:10px}
.createdb-panel h3{font-size:13px;color:#34d399;margin-bottom:10px}
.import-panel input[type=file]{color:#e2e8f0;font-family:monospace;font-size:12px;padding:4px 0}
.import-panel .import-note{font-size:11px;color:#64748b;margin-top:6px}
.createdb-row{display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap}
.createdb-row .form-field{flex:1;min-width:160px}
.alert-ok{background:#14532d;color:#86efac;border:1px solid #166534;padding:7px 12px;border-radius:4px;font-size:12px;margin-bottom:8px}
.alert-err{background:#450a0a;color:#fca5a5;border:1px solid #7f1d1d;padding:7px 12px;border-radius:4px;font-size:12px;margin-bottom:8px}

/* PAGINATION */
.pgn{padding:8px 16px;display:flex;align-items:center;gap:6px;border-top:1px solid #1e2d40;background:#0f1117;flex-shrink:0}
.pgn a,.pgn span{padding:3px 8px;border-radius:3px;font-size:12px;text-decoration:none;color:#94a3b8;border:1px solid #2d3f57}
.pgn a:hover{background:#1e2d40;color:#e2e8f0}
.pgn .cur{background:#1d4ed8;color:#fff;border-color:#1d4ed8}
.pgn-info{margin-left:auto;font-size:11px;color:#4a6fa5}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar">
  <h2>J-MEP DB</h2>
  <?php foreach ($tables as $tbl): ?>
  <a class="tbl-link <?= $tbl === $t ? 'active' : '' ?>"
     href="?t=<?= urlencode($tbl) ?>"
     title="<?= h($tbl) ?>">
    <?= h($tbl) ?>
  </a>
  <?php endforeach; ?>
  <div id="sidebar-footer">
    <div class="dump-section">
      <div class="dump-title">📦 FULL DATABASE EXPORT</div>
      <a href="?dump=full" class="dump-link" onclick="return confirm('Export FULL DATABASE with data? This may take a while.');">📊 With Data (Full)</a>
      <a href="?dump=full&no_data=1" class="dump-link-structure" onclick="return confirm('Export FULL DATABASE structure only (no data)?');">🏗️ Structure Only (No Data)</a>
    </div>
    <?php if ($t): ?>
    <div class="dump-section">
      <div class="dump-title">📄 CURRENT TABLE EXPORT: <?= h($t) ?></div>
      <a href="?dump_table=<?= urlencode($t) ?>" class="dump-link" onclick="return confirm('Export table <?= h($t) ?> with data?');">📊 With Data</a>
      <a href="?dump_table=<?= urlencode($t) ?>&no_data=1" class="dump-link-structure" onclick="return confirm('Export table <?= h($t) ?> structure only?');">🏗️ Structure Only (No Data)</a>
    </div>
    <?php endif; ?>
    <a href="?logout=1" class="logout-link">⎋ Logout</a>
  </div>
</div>

<?php if (isset($_GET['logout'])) { unset($_SESSION['dbv_auth']); header("Location: " . $_SERVER['PHP_SELF']); exit; } ?>

<!-- MAIN -->
<div id="main">

  <!-- TOPBAR -->
  <div id="topbar">
    <strong><?= h($t) ?></strong>
    <span><?= number_format($totalRows) ?> rows</span>
    <div class="toolbar">
      <form method="get" style="display:contents">
        <input type="hidden" name="t" value="<?= h($t) ?>">
        <input type="text" name="s" value="<?= h($search) ?>" placeholder="Search all columns…">
        <select name="per_page" onchange="this.form.submit()">
          <?php foreach ([25,50,100,250,500] as $n): ?>
          <option value="<?= $n ?>" <?= $perPage==$n?'selected':'' ?>><?= $n ?>/page</option>
          <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-gray">Go</button>
      </form>
      <button class="btn btn-green" onclick="togglePanel('insert-panel')">+ Insert</button>
      <button class="btn btn-yellow" onclick="togglePanel('sql-panel')">⌘ SQL</button>
      <button class="btn btn-purple" onclick="togglePanel('import-panel')">⬆ Import SQL</button>
      <button class="btn" style="background:#065f46;color:#6ee7b7" onclick="togglePanel('createdb-panel')">＋ New DB</button>
      <?php if ($t): ?>
      <div class="btn-group">
        <a href="?dump_table=<?= urlencode($t) ?>" class="btn btn-cyan" onclick="return confirm('Export table <?= h($t) ?> with data?');">📊 Dump (Data)</a>
        <a href="?dump_table=<?= urlencode($t) ?>&no_data=1" class="btn btn-teal" onclick="return confirm('Export table <?= h($t) ?> structure only?');">🏗️ Dump (Structure)</a>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if ($msg): ?>
  <div id="msg-bar" class="<?= stripos($msg,'error')!==false||stripos($msg,'Error')!==false?'err':'' ?>">
    <?= h($msg) ?>
  </div>
  <?php endif; ?>

  <!-- IMPORT SQL PANEL -->
  <div class="import-panel" id="import-panel" style="display:none">
    <h3>⬆ Import SQL File</h3>
    <?php if ($import_msg): ?><div class="alert-ok"><?= $import_msg ?></div><?php endif; ?>
    <?php if ($import_err): ?><div class="alert-err"><?= h($import_err) ?></div><?php endif; ?>
    <form method="post" action="<?= url([]) ?>" enctype="multipart/form-data">
      <input type="hidden" name="_action" value="import_sql">
      <div style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap">
        <div class="form-field" style="flex:1;min-width:240px">
          <label>Select .sql file</label>
          <input type="file" name="sql_file" accept=".sql" required>
        </div>
        <div class="form-actions-row" style="margin:0">
          <button type="submit" class="btn btn-purple"
            onclick="return confirm('This will execute all SQL in the file against the CURRENT database. Continue?')">
            ⬆ Run Import
          </button>
          <button type="button" class="btn btn-gray" onclick="togglePanel('import-panel')">Cancel</button>
        </div>
      </div>
      <p class="import-note">⚠️ The SQL file will be executed against the <strong>currently connected database</strong>. Make sure the file targets the right DB. Large dumps may time out on shared hosting.</p>
    </form>
  </div>

  <!-- CREATE DATABASE PANEL -->
  <div class="createdb-panel" id="createdb-panel" style="display:none">
    <h3>＋ Create New Database</h3>
    <?php if ($createdb_msg): ?><div class="alert-ok"><?= $createdb_msg ?></div><?php endif; ?>
    <?php if ($createdb_err): ?><div class="alert-err"><?= h($createdb_err) ?></div><?php endif; ?>
    <form method="post" action="<?= url([]) ?>">
      <input type="hidden" name="_action" value="create_db">
      <div class="createdb-row">
        <div class="form-field">
          <label>Database Name *</label>
          <input type="text" name="new_db_name" placeholder="e.g. u664394736_newdb"
                 pattern="[a-zA-Z0-9_]+" title="Letters, numbers, underscores only" required>
        </div>
        <div class="form-field">
          <label>Charset</label>
          <select name="new_db_charset">
            <option value="utf8mb4" selected>utf8mb4 (recommended)</option>
            <option value="utf8">utf8</option>
            <option value="latin1">latin1</option>
          </select>
        </div>
        <div class="form-field">
          <label>Collation</label>
          <select name="new_db_collate">
            <option value="utf8mb4_unicode_ci" selected>utf8mb4_unicode_ci</option>
            <option value="utf8mb4_general_ci">utf8mb4_general_ci</option>
            <option value="utf8_general_ci">utf8_general_ci</option>
          </select>
        </div>
        <div class="form-actions-row" style="margin:0">
          <button type="submit" class="btn" style="background:#065f46;color:#6ee7b7"
            onclick="return confirm('Create new database? Make sure your DB user has CREATE privilege.')">
            ＋ Create DB
          </button>
          <button type="button" class="btn btn-gray" onclick="togglePanel('createdb-panel')">Cancel</button>
        </div>
      </div>
      <p class="import-note">⚠️ Requires your MySQL user to have <strong>CREATE</strong> privilege. On shared hosting (Hostinger), you may need to create the DB in hPanel first and then assign the user.</p>
    </form>
  </div>

  <!-- INSERT FORM -->
  <div class="form-panel" id="insert-panel" style="display:none">
    <h3>INSERT — <?= h($t) ?></h3>
    <form method="post" action="<?= url(['action'=>'']) ?>">
      <input type="hidden" name="_action" value="insert">
      <div class="form-grid">
        <?php foreach ($cols as $c): ?>
        <?php if ($c['Extra'] === 'auto_increment') continue; ?>
        <div class="form-field">
          <label><?= h($c['Field']) ?><?= $c['Null']==='NO'&&$c['Default']===null?' *':'' ?></label>
          <?php if (strpos($c['Type'],'text')!==false): ?>
          <textarea name="<?= h($c['Field']) ?>"></textarea>
          <?php elseif (strpos($c['Type'],'enum')!==false): ?>
          <?php preg_match_all("/'([^']+)'/", $c['Type'], $em); ?>
          <select name="<?= h($c['Field']) ?>">
            <?php if ($c['Null']==='YES'): ?><option value="">NULL</option><?php endif; ?>
            <?php foreach ($em[1] as $ev): ?>
            <option value="<?= h($ev) ?>"><?= h($ev) ?></option>
            <?php endforeach; ?>
          </select>
          <?php else: ?>
          <input type="text" name="<?= h($c['Field']) ?>"
                 placeholder="<?= h($c['Type']) ?>"
                 value="<?= h($c['Default'] ?? '') ?>">
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="form-actions-row">
        <button type="submit" class="btn btn-green">Insert Row</button>
        <button type="button" class="btn btn-gray" onclick="togglePanel('insert-panel')">Cancel</button>
      </div>
    </form>
  </div>

  <!-- EDIT FORM -->
  <?php if ($edit_row): ?>
  <div class="form-panel" id="edit-panel">
    <h3>EDIT — <?= h($t) ?> [<?= h($edit_row[$pk] ?? '') ?>]</h3>
    <form method="post" action="<?= url(['action'=>'']) ?>">
      <input type="hidden" name="_action" value="update">
      <input type="hidden" name="_pk_val" value="<?= h($edit_row[$pk] ?? '') ?>">
      <div class="form-grid">
        <?php foreach ($cols as $c): ?>
        <div class="form-field">
          <label><?= h($c['Field']) ?><?= $c['Field']===$pk?' [PK]':'' ?></label>
          <?php if ($c['Field'] === $pk): ?>
          <input type="text" value="<?= h($edit_row[$c['Field']] ?? '') ?>" disabled style="opacity:.4">
          <?php elseif (strpos($c['Type'],'text')!==false): ?>
          <textarea name="<?= h($c['Field']) ?>"><?= h($edit_row[$c['Field']] ?? '') ?></textarea>
          <?php elseif (strpos($c['Type'],'enum')!==false): ?>
          <?php preg_match_all("/'([^']+)'/", $c['Type'], $em); ?>
          <select name="<?= h($c['Field']) ?>">
            <?php if ($c['Null']==='YES'): ?><option value="" <?= $edit_row[$c['Field']]===null?'selected':'' ?>>NULL</option><?php endif; ?>
            <?php foreach ($em[1] as $ev): ?>
            <option value="<?= h($ev) ?>" <?= $edit_row[$c['Field']]===$ev?'selected':'' ?>><?= h($ev) ?></option>
            <?php endforeach; ?>
          </select>
          <?php else: ?>
          <input type="text" name="<?= h($c['Field']) ?>"
                 value="<?= h($edit_row[$c['Field']] ?? '') ?>">
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <div class="form-actions-row">
        <button type="submit" class="btn btn-blue">Save Changes</button>
        <a href="<?= url(['edit_id'=>'','action'=>'']) ?>" class="btn btn-gray">Cancel</a>
      </div>
    </form>
  </div>
  <?php endif; ?>

  <!-- SQL PANEL -->
  <div class="sql-panel" id="sql-panel" style="display:<?= $action==='sql'?'block':'none' ?>">
    <h3>⌘ Raw SQL</h3>
    <form method="post" action="<?= url([]) ?>">
      <input type="hidden" name="_action" value="sql">
      <textarea name="raw_sql" placeholder="SELECT * FROM kegiatan LIMIT 10;&#10;&#10;-- You can run multiple queries separated by semicolons:&#10;-- UPDATE table1 SET field = 'value' WHERE id = 1;&#10;-- UPDATE table2 SET field = 'value' WHERE id = 2;"><?= h($_POST['raw_sql'] ?? '') ?></textarea>
      <div class="form-actions-row">
        <button type="submit" class="btn btn-yellow">Run SQL</button>
        <button type="button" class="btn btn-gray" onclick="togglePanel('sql-panel')">Close</button>
      </div>
    </form>
    <?php if ($action === 'sql' && isset($sql_error)): ?>
    <div class="sql-result"><span class="err">ERROR: <?= h($sql_error) ?></span></div>
    <?php elseif ($action === 'sql' && $sql_affected !== null): ?>
    <div class="sql-result"><span class="ok">OK — <?= $sql_affected ?> row(s) affected.</span></div>
    <?php elseif ($action === 'sql' && isset($sql_cols) && $sql_cols): ?>
    <div class="sql-result">
      <div style="margin-bottom:6px;color:#86efac"><?= count($sql_rows) ?> row(s) returned.</div>
      <div style="overflow-x:auto">
       <table>
        <thead> tr<?php foreach ($sql_cols as $sc): ?><th><?= h($sc) ?></th><?php endforeach; ?> </thead>
        <tbody>
        <?php foreach ($sql_rows as $sr): ?>
         <tr><?php foreach ($sql_cols as $sc): ?>
          <td><?= $sr[$sc]===null ? '<span class="null-v">NULL</span>' : h(mb_substr((string)$sr[$sc],0,200)) ?></td>
        <?php endforeach; ?></tr>
        <?php endforeach; ?>
        </tbody>
       </table>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- DATA TABLE -->
  <div style="flex:1;overflow-y:auto">
  <?php if (!$t): ?>
    <div style="padding:40px;color:#4a6fa5;text-align:center">Select a table from the sidebar.</div>
  <?php elseif (empty($cols)): ?>
    <div style="padding:40px;color:#4a6fa5;text-align:center">Table not found or empty.</div>
  <?php else: ?>
  <div class="tbl-wrap">
   <table>
    <thead>
      <tr>
        <th style="width:80px">Actions</th>
        <?php foreach ($cols as $c): ?>
        <th><?= h($c['Field']) ?><br><span style="font-weight:400;font-size:10px;color:#4a6fa5"><?= h($c['Type']) ?></span></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
    <?php if (empty($rows)): ?>
     <tr><td colspan="<?= count($cols)+1 ?>" style="text-align:center;padding:30px;color:#4a6fa5">No rows found.</td></tr>
    <?php else: ?>
    <?php foreach ($rows as $row): ?>
     <tr>
      <td>
        <div class="td-actions">
          <a class="btn btn-yellow btn-sm"
             href="<?= url(['edit_id' => h($pk ? $row[$pk] : ''), 'action' => 'edit']) ?>">Edit</a>
          <a class="btn btn-red btn-sm"
             href="<?= url(['action' => 'delete', 'id' => h($pk ? $row[$pk] : ''), 'page' => $_GET['page'] ?? 1]) ?>">Del</a>
        </div>
      </td>
      <?php foreach ($cols as $c): ?>
      <td title="<?= h((string)($row[$c['Field']] ?? '')) ?>">
        <?php if ($row[$c['Field']] === null): ?>
          <span class="null-v">NULL</span>
        <?php else: ?>
          <?= h(mb_substr((string)$row[$c['Field']], 0, 120)) ?><?= mb_strlen((string)$row[$c['Field']]) > 120 ? '…' : '' ?>
        <?php endif; ?>
      </td>
      <?php endforeach; ?>
     </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
   </table>
  </div>
  <?php endif; ?>
  </div>

  <!-- PAGINATION -->
  <?php if ($t && $totalPages > 1): ?>
  <div class="pgn">
    <?php if ($page > 1): ?>
    <a href="<?= url(['page'=>1]) ?>">«</a>
    <a href="<?= url(['page'=>$page-1]) ?>">‹</a>
    <?php endif; ?>
    <?php
    $rs = max(1, $page-3); $re = min($totalPages, $page+3);
    for ($p = $rs; $p <= $re; $p++):
    ?>
    <a href="<?= url(['page'=>$p]) ?>" class="<?= $p===$page?'cur':'' ?>"><?= $p ?></a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
    <a href="<?= url(['page'=>$page+1]) ?>">›</a>
    <a href="<?= url(['page'=>$totalPages]) ?>">»</a>
    <?php endif; ?>
    <span class="pgn-info">
      Rows <?= number_format($offset+1) ?>–<?= number_format(min($offset+$perPage,$totalRows)) ?>
      of <?= number_format($totalRows) ?> | Page <?= $page ?>/<?= $totalPages ?>
    </span>
  </div>
  <?php endif; ?>

</div><!-- /#main -->

<script>
function togglePanel(id) {
  var el = document.getElementById(id);
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
// Auto-scroll to edit form if present
<?php if ($edit_row): ?>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('edit-panel')?.scrollIntoView({behavior:'smooth'});
});
<?php endif; ?>
// Auto-open import/createdb panels if there's feedback
<?php if ($import_msg || $import_err): ?>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('import-panel').style.display = 'block';
});
<?php endif; ?>
<?php if ($createdb_msg || $createdb_err): ?>
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('createdb-panel').style.display = 'block';
});
<?php endif; ?>
</script>
</body>
</html>