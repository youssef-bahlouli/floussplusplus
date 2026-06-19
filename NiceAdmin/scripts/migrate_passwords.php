<?php
/**
 * Migration: rehash any plaintext passwords in the database.
 * Run once after deploying password_hash() changes.
 */

require_once __DIR__ . '/../php/database_connection.php';

$db = get_con_var();
$users = $db->users->find();
$count = 0;

foreach ($users as $user) {
    $pass = $user['passwrd'] ?? '';

    // Already a bcrypt hash — skip
    if (str_starts_with($pass, '$2')) {
        continue;
    }

    // Plaintext password — rehash it
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $db->users->updateOne(
        ['_id' => $user['_id']],
        ['$set' => ['passwrd' => $hash]]
    );

    echo "Migrated: " . $user['_id'] . " — rehashed plaintext password" . PHP_EOL;
    $count++;
}

echo PHP_EOL . "Done. $count user(s) migrated." . PHP_EOL;
