<?php
/**
 * File:        Registration.php
 * Created by:  Ikarius
 * Date:        11/13/12 at 16:59
 * Last Edit:   11/13/12 at 16:59
 */

    if(isset($view['error']) && $view['error'] != '')
    echo '<div class="message error">'.$view['error'].'</div>';?>

<form method="post" action="/Registration">

<?php if($view['step'] == 1) {?>
    <h2>Введите данные, относящейся к компании</h2>
    <div class="form-div">
	    <label class="form-label" for="companyName"> Название компании: </label>
	    <input class="form-input" type="text" name="companyName" id="companyName" autofocus />
    </div>       
	<div class="form-btn">    
		<button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
	</div>
    
<?php } elseif($view['step'] == 2) {?>
    <h2>Введите данные, относящейся к администратору:</h2>
    <div class="form-div">
	    <label class="form-label" for="login">Логин: </label>
	    <input class="form-input" type="text" name="adminLogin" id="login" autofocus/>
    </div>
    <div class="form-div">
	    <label class="form-label" for="adminPassword"> Пароль: </label>
	    <input class="form-input" type="password" name="adminPassword" id="adminPassword" />
    </div>
    <div class="form-div">
	    <label class="form-label" for="adminPasswordRepeated"> Повторите пароль: </label>
	    <input class="form-input" type="password" name="adminPasswordRepeated" id="adminPasswordRepeated" />
    </div>
	<div class="form-div">    
	    <label class="form-label" for="adminEmail"> Электронная почта: </label>
	    <input class="form-input" type="email" name="adminEmail" id="adminEmail" />
	</div>
	<div class="form-btn">    
		<button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
	</div>


<?php } elseif($view['step'] == 3) {?>
    <p>Было послано проверочное сообщения на <?php echo $view['adminEmail']?>.</p>
        <p>P.S: Пока не работает, аккаунт автоматический активирован.</p>

<?php } elseif($view['step'] == 4) {?>
    <p>Ваш аккаунт активирован.</p>
<?php }?>

</form>