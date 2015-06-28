<?php
function connectDB()
{
  // phpinfo();
  try {
    return new PDO(DSN, DB_USER, DB_PASSWORD);

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }
}
?>
