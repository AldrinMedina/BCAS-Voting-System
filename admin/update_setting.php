<?php
/**
 * Update Setting API
 * File: update_setting.php
 */

include 'includes/session.php';
include 'includes/settings.php';

header('Content-Type: application/json');

// Check if user is admin (optional - remove if you want public access)
if (!isset($_SESSION['admin'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit();
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['key']) || !isset($input['value'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing required parameters: key and value'
        ]);
        exit();
    }
    
    $key = $input['key'];
    $value = $input['value'];
    $description = $input['description'] ?? null;
    
    // Validate certain settings
    switch ($key) {
        case 'anonymity_mode':
        case 'voting_enabled':
        case 'show_vote_count':
        case 'show_percentage':
            $value = $value ? '1' : '0';
            break;
        case 'carousel_interval':
        case 'results_refresh_interval':
            $value = max(1000, intval($value)); // Minimum 1 second
            break;
    }
    
    if (updateSetting($key, $value, $description)) {
        echo json_encode([
            'success' => true,
            'message' => 'Setting updated successfully',
            'key' => $key,
            'value' => $value
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update setting'
        ]);
    }
    
} catch (Exception $e) {
    error_log("Error in update_setting.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update setting'
    ]);
}
?>