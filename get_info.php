<?php
//Includes & log file
$log = fopen('./oc.err.log','a');
include('./config.php');
include('./functions.php');
//Connect to DB
$conn = new mysqli($server, $dbusr, $dbpw, $db);
//Check the connection, throw error if any and write to the log file
if ($conn->connect_error) {
	$now = date("Y-m-d H:i:s");
	$err = "[" . $now . "] Database Connection Failed: " . $conn->connect_error ."\n";
	fwrite($log,$err);
	die($err);
}
else {
	$now = date("Y-m-d H:i:s");
	fwrite($log,"[" . $now . "]Database Connection Successful\n");
}

//queries to build arrays of information
///Positions
$query = "select * from positions"; //this query pulls more information than is absolutely needed, and could probably be limited to id,name,parentid
$info = $conn->query($query,MYSQLI_STORE_RESULT);
///Skills
$query2 = "select * from skills"; 
$skill = $conn->query($query2,MYSQLI_STORE_RESULT);

//Building the array for positions from the query. 
$data = array();
$id = array();
$refs = array();
$list = array();
while ($result = mysqli_fetch_assoc($info)){
	$name = $result['name'];
	$self_id = $result['id'];
	$parent_id = $result['parentid'];
	$skill_set = $result['skill'];
	$self[] = array($self_id, $name , $parent_id);
	$skill_sets[$name] = $skill_set;
}
//now we check recusively for parentage
$pre_data = tree($self, array(0));
//cleanup so everything looks correct and can be parsed properly
fixArrayKey($skill_sets);
$pass1 = removeRecursive($pre_data,0);
$pass2 = removeRecursive($pass1,1);
$data = removeRecursive($pass2,2);
//Building Skill array
// while ($result = mysqli_fetch_assoc($skill)){
	// $id = $result['id'];
	// $name = $result['name'];
	// $parent = $result['parentid'];
	// $skill_list[] = array($id,$name);
// }
	while($sk = mysqli_fetch_assoc($skill)) {
		// Assign by reference
		$thisref = &$refs[ $sk['id'] ];
		// add the the menu parent
		$thisref['parentid'] = $sk['parentid'];
		$thisref['name'] = $sk['name'];
		$thisref['id'] = $sk['id'];
		// if there is no parent id
		if ($sk['parentid'] == 0) {
			$list[ $sk['id'] ] = &$thisref;
		}
		else {
			$refs[ $sk['parentid'] ]['children'][ $sk['id'] ] = &$thisref;
		}
	}
$skills = tree($skill_list, array(0));
$conn->close();
?>
