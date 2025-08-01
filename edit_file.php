<?php
function checkAvailability($kolej_id, $check_in, $check_out) {
    global $conn;
    $sql = "SELECT COUNT(*) as booked_rooms 
            FROM tempahan_bilik 
            WHERE id_kolej = ? 
            AND ((tarikh_mula BETWEEN ? AND ?) 
            OR (tarikh_tamat BETWEEN ? AND ?))
            AND status != 'cancelled'";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $kolej_id, $check_in, $check_out, $check_in, $check_out);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // dapat jumah bilik yang ada dari table kolej
    $sql_total = "SELECT had_bilik FROM kolej WHERE id_kolej = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $kolej_id);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    
    return $row_total['had_bilik'] - $row['booked_rooms'];
}

function generateReport($start_date, $end_date, $kolej_id = null) {
    global $conn;
    
    $sql = "SELECT k.nama_kolej, 
            COUNT(t.id_tempahan) as total_bookings,
            SUM(t.total_amount) as revenue,
            AVG(r.rating) as avg_rating
            FROM kolej k
            LEFT JOIN tempahan_bilik t ON k.id_kolej = t.id_kolej
            LEFT JOIN ratings r ON k.id_kolej = r.fld_kolej_id
            WHERE t.tarikh_mula BETWEEN ? AND ?";
    
    if ($kolej_id) {
        $sql .= " AND k.id_kolej = ?";
    }
    
    $sql .= " GROUP BY k.id_kolej";
    
    $stmt = $conn->prepare($sql);
    if ($kolej_id) {
        $stmt->bind_param("ssi", $start_date, $end_date, $kolej_id);
    } else {
        $stmt->bind_param("ss", $start_date, $end_date);
    }
    
    $stmt->execute();
    return $stmt->get_result();
   <link rel="icon" type="image/png" href="hihi.png">
}
