<?php
/**
 * File:        Registration.php
 * Created by:  Ikarius
 * Date:        11/13/12 at 16:5932
 * Last Edit:   11/13/12 at 16:32
 */
?>

<?php if(isset($view['error']) && $view['error'] != '')
    echo '<div class="message error">'.$view['error'].'</div>';?>

<form method="post" action="/Connection">

    <h2>Введите ваши данные:</h2>

    <div class="form-div">
	    <label class="form-label" for="company"> Компания: </label>
	    <input class="form-input" type="text" name="company" id="company" autofocus/>
    </div>
    
    <div class="form-div">
	    <label class="form-label" for="login"> Логин: </label>
	    <input class="form-input" type="text" name="login" id="login"/>
    </div> 
    <div class="form-div">
	    <label class="form-label" for="password"> Пароль: </label>
	    <input class="form-input" type="password" name="password" id="password"/>
    </div>
    
	<div class="form-btn">    
		<button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
	</div>
</form>