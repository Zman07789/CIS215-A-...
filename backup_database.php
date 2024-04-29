<?php
$sourceFile = 'database.sqlite';
$backupDir = 'backups/';
$backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sqlite';

$sevenDaysAgo = strtotime('-7 days');
foreach (glob($backupDir . "backup_*.sqlite") as $file) {
    if (filemtime($file) < $sevenDaysAgo) {
        unlink($file);
    }
}

if (!is_dir($backupDir)) {
    mkdir($backupDir);
}

if (copy($sourceFile, $backupFile)) {
    echo "Backup created successfully: {$backupFile}\n";
} else {
    echo "Error creating backup\n";
}
?>
