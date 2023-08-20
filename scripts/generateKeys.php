<?php

$generateAPIKey = fn ($length = 32) => bin2hex(random_bytes($length / 2));

$generateAPISecret = fn ($length = 64) => bin2hex(random_bytes($length / 2));

echo "X-API-Key: " . $generateAPIKey() . "\n";
echo "X-API-Secret: " . $generateAPISecret() . "\n";
