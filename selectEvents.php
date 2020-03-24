<?php
require 'dbConnect.php';

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n\n";
    }
}



try {
    $stmt = $conn->prepare("SELECT 
		event_id,
		event_description,
		event_presenter,
		event_date,
		event_time
		FROM wdv341_event");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	$result = $stmt->fetchAll();  // associative array

	$iterator = new RecursiveArrayIterator($result);
	$tableRows = new TableRows($iterator);  //returns object
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>WDV341 Advanced Javascript Unit 9 Select Events</title>
		<style>
			body{background-color:linen}
			td{ width:2000px;border:1px solid black }
			table {border: solid 1px black}
		</style>
	</head>

	<body>
		<?php
		if ( count($result) > 0){
			echo "<table>";
			foreach( $tableRows as $k=>$v) {
				echo $v;
			 }
			echo "</table>";
		}else{
			echo "<h1>No records returned</h1>";
		}
		?>
	</body>
</html>
