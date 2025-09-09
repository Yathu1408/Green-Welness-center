<?php
require 'db.php';
echo "Connected OK<br>";

try {
  // sanity check query
  $stmt = $pdo->query("SELECT 1");
  echo "Simple query OK<br>";
} catch (Throwable $e) {
  echo "Query failed: " . $e->getMessage();
}