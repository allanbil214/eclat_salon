<?php
$outlet_id = (int) ($_POST['outlet_id'] ?? 0);
$outlet    = $outlet_id ? get_outlet_by_id($outlet_id) : null;
if (!$outlet) { flash('Outlet not found.', 'err'); admin_redirect('/outlets'); }

// IDs of members being assigned to this outlet
$assigned = array_map('intval', (array) ($_POST['member_ids'] ?? []));
$assigned = array_filter($assigned);

// For every team member:
// - if their ID is in $assigned → set outlet_id = this outlet
// - if their ID is NOT in $assigned AND they currently belong to this outlet → unset (set NULL)
// Members assigned to OTHER outlets are left untouched.
$all = get_all_team();

foreach ($all as $m) {
    $id             = (int) $m['id'];
    $current_outlet = $m['outlet_id'] !== null ? (int) $m['outlet_id'] : null;

    if (in_array($id, $assigned, true)) {
        // Assign to this outlet (even if they were at another outlet)
        if ($current_outlet !== $outlet_id) {
            qexec('UPDATE team SET outlet_id = :oid WHERE id = :id', ['oid' => $outlet_id, 'id' => $id]);
        }
    } elseif ($current_outlet === $outlet_id) {
        // Was at this outlet but unchecked → unassign
        qexec('UPDATE team SET outlet_id = NULL WHERE id = :id', ['id' => $id]);
    }
    // else: belongs to a different outlet and not checked — leave alone
}

flash('Team assignments saved.');
admin_redirect('/outlets/team?outlet_id=' . $outlet_id);
