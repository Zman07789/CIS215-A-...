<?php
$backupDir = 'backups/';
$backupFiles = glob($backupDir . "backup_*.sqlite");

usort($backupFiles, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

$sevenDaysAgo = strtotime('-7 days');
foreach ($backupFiles as $file) {
    if (filemtime($file) >= $sevenDaysAgo) {
        $backupFile = $file;
        break;
    }
}

if (isset($backupFile)) {
    if (copy($backupFile, 'database.sqlite')) {
        echo "Database restored successfully\n";
    } else {
        echo "Error restoring database\n";
    }
} else {
    echo "No backup file found within the last 7 days\n";
}
?>
