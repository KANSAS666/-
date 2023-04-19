<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Авторизация</title>
  
  
  
      <link rel="stylesheet" href="login.css">

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
  <div class="middle">
  <h1>Авторизация</h1>
  
  <!--  Fancy inputs  -->
  <div id="fancy-inputs">
    <label class="input">
      <input type="password">
      <span><span>Пароль</span></span>
    </label>
  </div>
  
  <div id="fancy-radio">
    <input type="radio" name="group" id="questions" class="pull-left" style="display: none;">
    <label class="radio questions" for="questions">Менеджер</label>

    <input type="radio" name="group" id="photo" class="pull-left" style="display: none;">
    <label class="radio photo" for="photo">Бухгалтер</label>
  </div>
  
  <a href="" class="btn">Войти</a>
</div>

<script>
$(function() {
  // Обработка нажатия на кнопку "Войти"
  $('.btn').click(function(e) {
    e.preventDefault(); // Отменяем стандартное действие кнопки

    // Получаем выбранную роль и пароль
    var role = $('input[type="radio"]:checked').attr('id');
    var password = $('input[type="password"]').val();

    // Проверяем пароль в соответствии с выбранной ролью
    switch(role) {
      case 'questions':
        if (password === '12345') {
          // Если пароль верный, переходим на страницу для менеджера
          window.location.href = 'manager.php';
        } else {
          // Если пароль неверный, выводим сообщение
          alert('Неверный пароль! Пожалуйста, обратитесь к администратору.');
          $('input[type="password"]').val('');
        }
        break;
      case 'photo':
        if (password === '54321') {
          // Если пароль верный, переходим на страницу для бухгалтера
          window.location.href = 'accountant.php';
        } else {
          // Если пароль неверный, выводим сообщение
          alert('Неверный пароль! Пожалуйста, обратитесь к администратору.');
          $('input[type="password"]').val('');
        }
        break;
    }
  });
});
  </script>
  
    <script src="js/index.js"></script>

</body>
</html>
