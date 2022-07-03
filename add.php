<?php
require_once('php/header.php');
?>
<body class="d-flex flex-column h-100">
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
    	<span class="navbar-brand px-0 mx-0" href="/">Создание вопроса</span>
    </div>
  </nav>
</header>
<main role="main" class="container mt-3">
<div class="container">
  <div class="row">
    <div class="col">
      <form action="/" method="POST" id="form_1">
      	<div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Вопрос" name="question">
        </div>
        <div class="form-check form-check-inline mb-3">
          <span class="mr-3">Тип вопроса:</span>
          <input class="form-check-input" type="radio" name="question_type" id="radio1" value="single" checked>
          <label class="form-check-label" for="radio1">один ответ</label>
        </div>
        <div class="form-check form-check-inline mb-3">
          <input class="form-check-input" type="radio" name="question_type" id="radio2" value="multi">
          <label class="form-check-label" for="radio2">несколько ответов</label>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Вариант ответа" name="variant_1">
        </div>
      </form>
      <button class="btn btn-outline-info" type="button" id="add_people">Добавить вариант ответа</button>
      <button class="btn btn-info" id="submit" name="add_question">Сохранить</button>
    </div>
  </div>
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
  var v_count=2;
  $("#add_people").click(function(){$('#form_1').append('<div class="input-group mb-3"><input type="text" class="form-control" placeholder="Вариант ответа" name="variant_'+v_count+'"></div>');v_count++});
  $("#submit").click(function(){$('#form_1').submit()});
</script>
</html>