<?php
/**
 * Settings Management Functions
 * File: includes/settings.php
 */

/**
 * Get a setting value from database
 * @param string $key Setting key
 * @param mixed $default Default value if setting doesn't exist
 * @return mixed Setting value
 */
function getSetting($key, $default = null) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['setting_value'];
    }
    
    return $default;
}

/**
 * Update a setting value in database
 * @param string $key Setting key
 * @param mixed $value Setting value
 * @param string $description Optional description
 * @return bool Success status
 */
function updateSetting($key, $value, $description = null) {
    global $conn;
    
    if ($description) {
        $stmt = $conn->prepare("
            INSERT INTO settings (setting_key, setting_value, description) 
            VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
            setting_value = VALUES(setting_value),
            description = VALUES(description),
            updated_at = CURRENT_TIMESTAMP
        ");
        $stmt->bind_param("sss", $key, $value, $description);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO settings (setting_key, setting_value) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE 
            setting_value = VALUES(setting_value),
            updated_at = CURRENT_TIMESTAMP
        ");
        $stmt->bind_param("ss", $key, $value);
    }
    
    return $stmt->execute();
}

/**
 * Get all settings as associative array
 * @return array All settings
 */
function getAllSettings() {
    global $conn;
    
    $settings = [];
    $result = $conn->query("SELECT setting_key, setting_value FROM settings");
    
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return $settings;
}

/**
 * Check if setting exists
 * @param string $key Setting key
 * @return bool
 */
function settingExists($key) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['count'] > 0;
}

/**
 * Delete a setting
 * @param string $key Setting key
 * @return bool Success status
 */
function deleteSetting($key) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM settings WHERE setting_key = ?");
    $stmt->bind_param("s", $key);
    
    return $stmt->execute();
}

/**
 * Get boolean setting value
 * @param string $key Setting key
 * @param bool $default Default value
 * @return bool
 */
function getBooleanSetting($key, $default = false) {
    $value = getSetting($key, $default ? '1' : '0');
    return $value === '1' || $value === 'true' || $value === 'yes';
}

/**
 * Get integer setting value
 * @param string $key Setting key
 * @param int $default Default value
 * @return int
 */
function getIntegerSetting($key, $default = 0) {
    $value = getSetting($key, $default);
    return (int) $value;
}
?>