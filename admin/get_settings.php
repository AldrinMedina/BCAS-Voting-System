<?php
/**
 * Get Settings API
 * File: get_settings.php
 */

include 'includes/session.php';
include 'includes/settings.php';

header('Content-Type: application/json');

try {
    // Get specific setting or all settings
    if (isset($_GET['key'])) {
        $key = $_GET['key'];
        $value = getSetting($key);
        
        if ($value !== null) {
            echo json_encode([
                'success' => true,
                'key' => $key,
                'value' => $value
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Setting not found'
            ]);
        }
    } else {
        // Return all settings
        $settings = getAllSettings();
        echo json_encode([
            'success' => true,
            'settings' => $settings
        ]);
    }
    
} catch (Exception $e) {
    error_log("Error in get_settings.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Failed to retrieve settings'
    ]);
}
?>