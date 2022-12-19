<?php include("../../services/db.php") ?>
<?php
$db = new dbServices($mysql_host, $mysql_username, $mysql_password, $mysql_database);
$dbcon = $db->dbConnect();
// insert
if ($dbcon) {
	$tbName = 'user_table';
	$valuesArray = array(
		"'John'",
		"'Doe'",
		"'db_test@mail.com'",
		"'
		'",
		"'Admin'"
	);
	$fieldArray = array('first_name', 'last_name', "email", 'password', 'role');
	$result = $db->insert($tbName, $valuesArray, $fieldArray);
}
// select
if ($dbcon) {
	$tbName = 'user_table';
	$fieldArray = array('*');
	$where = "role='Admin'";
	$result = $db->select($tbName, $fieldArray, $where);
	if ($result) {
		while ($row = $result->fetch_assoc()) {
			echo $row['first_name'] . ' ' . $row['last_name'] . '<br>';
		}
	}
	$db->closeDb();
}
?>