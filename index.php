<?php
$link=mysqli_connect("localhost", "root", "root", "test");
mysqli_query($link, "set character_set_client='utf8'");
mysqli_query($link, "set character_set_results='utf8'");
mysqli_query($link, "set collation_connection='utf8_general_ci'");
$logged=0;
if (isset($_POST['question'])) {
	mysqli_query($link, "INSERT INTO questions (id, name, type) VALUES (NULL, '".$_POST['question']."', '".$_POST['question_type']."');");
	$question_id=mysqli_insert_id($link);
	$variants_pointer=1;
	while($variants_pointer>0) {
		if (isset($_POST['variant_'.$variants_pointer])) {
			mysqli_query($link, "INSERT INTO variants (id, question_id, name) VALUES (NULL, ".$question_id.", '".$_POST['variant_'.$variants_pointer]."');");
			$variants_pointer++;
		} else $variants_pointer=0;
	}
}
if (isset($_POST['submit'])) {
	if (isset($_POST['login'])) {
		$query=mysqli_query($link, "SELECT users.id, users.pass_hash FROM users WHERE users.login='".$_POST['login']."';");
		$data=mysqli_fetch_assoc($query);
		if(password_verify($_POST['password'], $data['pass_hash'])) {
			setcookie("login", $_POST['login'], time()+60*60*24*365, "/", null, false, true);
			$logged=1;
		}
	}
}
if (!isset($_COOKIE['login']) and $logged===0) {
	require_once('php/header.php');
	require_once('php/log.php');
	exit;
}
require_once('php/header.php');
?>
<body class="d-flex flex-column h-100">
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  	<span class="navbar-brand px-0 mx-0">Пользователь: <?php echo $_COOKIE['login'];?></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
    </div>
    <a class="navbar-brand px-0 mx-0" href="/add"><b>+</b> Добавить вопрос</a>
  </nav>
</header>
<main role="main" class="flex-shrink-0">
  <div class="container mt-3">
<?php
$query=mysqli_query($link, "SELECT * FROM questions;");
$q_counter=0;
while ($row=mysqli_fetch_array($query)) {
	if ($q_counter>0) echo '<br><hr>';
	echo '<div class="px-0 mx-0"><b>'.$row['name'].'</b></div>';
	$sub_query=mysqli_query($link, "SELECT * FROM variants WHERE question_id=".$row['id'].";");
	while ($sub_row=mysqli_fetch_array($sub_query)) {
		if ($row['type']=='single') {
			echo '<div class="px-0 mx-0"><input class="form-check-input" type="radio" name="single_'.$row['id'].'" value="variant_'.$sub_row['id'].'">'.$sub_row['name'].'<span id="stat_'.$sub_row['id'].'" class="px-5 small"><span></div>';
		} else {
			echo '<div class="px-0 mx-0"><input class="form-check-input" type="checkbox" name="multi_'.$row['id'].'_'.$sub_row['id'].'" value="'.$sub_row['id'].'">'.$sub_row['name'].'<span id="stat_'.$sub_row['id'].'" class="px-5 small"><span></div>';
		}
	}
	if ($row['type']=='multi') {
		echo '<button class="btn btn-info" id="'.$row['id'].'" name="answer_'.$row['id'].'">Зафиксировать ответ</button>';
	}
	$q_counter++;
}
?>
  </div>
</main>
<footer class="footer mt-auto py-3 bg-dark">
  <div class="container-fluide mx-3">
    <span class="text-muted" style="color: #808080"> </span>
  </div>
</footer>
</content>
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
<script>
	$("input[name*='single_']").on('input', function() {
		$.ajax({
		    type: "GET",
		    url: "php/fix_answer.php",
		    data: "type=single&q_id="+$(this).attr('name')+"&v_id="+$(this).attr('value'),
		    success: function(msg) {
		    	var stat=msg.split('&');
		    	for (var i=1; i<stat.length; i++) {
		    		var el=stat[i].split('=');
		    		$("#stat_"+el[0]).html(el[1]+' ответов')
		    	}
		    }
 		})
	});
	$("button[name*='answer_']").click(function() {
		var q_id=$(this).attr('id');
		var els=$("input[name*='multi_"+q_id+"_']");
		var request='';
		var req_counter=1;
		for (var i=0; i<els.length; i++) {
			if ($(els[i]).is(':checked')) {
				request+='&v_id_'+req_counter+'='+$(els[i]).val();
				req_counter++;
			}
		}
		$.ajax({
		    type: "GET",
		    url: "php/fix_answer.php",
		    data: "type=multi&q_id="+q_id+request,
		    success: function(msg) {
		    	var stat=msg.split('&');
		    	for (var i=1; i<stat.length; i++) {
		    		var el=stat[i].split('=');
		    		$("#stat_"+el[0]).html(el[1]+' ответов')
		    	}
		    }
 		})
	});
</script>
</html>