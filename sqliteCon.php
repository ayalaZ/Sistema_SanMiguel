<?php
$conn = new PDO('sqlite:C:\path\to\file.sqlite');
$stmt = $conn->prepare('INSERT INTO my_table(my_id, my_value) VALUES(?, ?)');
$waiting = true; // Set a loop condition to test for
while($waiting) {
    try {
        $conn->beginTransaction();
        for($i=0; $i < 10; $i++) {
            $stmt->bindValue(1, $i, PDO::PARAM_INT);
            $stmt->bindValue(2, 'TEST', PDO::PARAM_STR);
            $stmt->execute();
            sleep(1);
        }
        $conn->commit();
        $waiting = false;
    } catch(PDOException $e) {
        if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
            // This should be specific to SQLite, sleep for 0.25 seconds
            // and try again.  We do have to commit the open transaction first though
            $conn->commit();
            usleep(250000);
        } else {
            $conn->rollBack();
            throw $e;
        }
    }
}
?>