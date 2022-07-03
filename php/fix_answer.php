<?php
$link=mysqli_connect("localhost", "root", "root", "test");
mysqli_query($link, "set character_set_client='utf8'");
mysqli_query($link, "set character_set_results='utf8'");
mysqli_query($link, "set collation_connection='utf8_general_ci'");
if ($_GET['type']=='single') {
	$question_id=str_replace('single_', '', $_GET['q_id']);
	$variant_id=str_replace('variant_', '', $_GET['v_id']);
	$query=mysqli_query($link, "SELECT users.id FROM users WHERE users.login='".$_COOKIE['login']."';");
	$data=mysqli_fetch_assoc($query);
	$user_id=$data['id'];
	mysqli_query($link, "INSERT INTO answers (id, user_id, question_id, variant_id) VALUES (NULL, ".$user_id.", ".$question_id.", ".$variant_id.");");
}
if ($_GET['type']=='multi') {
	$question_id=$_GET['q_id'];
	$query=mysqli_query($link, "SELECT users.id FROM users WHERE users.login='".$_COOKIE['login']."';");
	$data=mysqli_fetch_assoc($query);
	$user_id=$data['id'];
	$variants_pointer=1;
	while($variants_pointer>0) {
		if (isset($_GET['v_id_'.$variants_pointer])) {
			mysqli_query($link, "INSERT INTO answers (id, user_id, question_id, variant_id) VALUES (NULL, ".$user_id.", ".$question_id.", ".$_GET['v_id_'.$variants_pointer].");");
			$variants_pointer++;
		} else $variants_pointer=0;
	}
}
$stat='';
$query=mysqli_query($link, "SELECT * FROM variants WHERE question_id=".$question_id.";");
while ($row=mysqli_fetch_array($query)) {
	$sub_query=mysqli_query($link, "SELECT COUNT(answers.id) AS a_count FROM answers WHERE question_id=".$question_id." and variant_id=".$row['id'].";");
	$data=mysqli_fetch_assoc($sub_query);
	$stat.="&".$row['id']."=".$data['a_count'];
}
echo $stat;
?>