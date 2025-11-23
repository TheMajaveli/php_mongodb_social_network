<?php

/**
 * Legacy seed file - now uses the new DatabaseSeeder structure
 * This file is kept for backward compatibility
 * 
 * Usage: php database/seeders/seed.php
 * Or use: php database/seeders/DatabaseSeeder.php
 */

require_once __DIR__ . '/DatabaseSeeder.php';

$seeder = new DatabaseSeeder();
$seeder->run();

