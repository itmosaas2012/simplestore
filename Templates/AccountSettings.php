<?php
  if (isset($_SESSION['connected'])){
?>

<?php

if(isset($_SESSION['error'])){ 
	echo '	<div id="alert" class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>';
	echo $_SESSION['error']; 
	echo '</strong></div>';
	unset($_SESSION['error']);
}

if (isset($_POST['btn_save_change'])){
    $surname = trim($_POST['familyName']); htmlspecialchars($surname); mysql_escape_string($surname);
	$name = trim($_POST['givenName']); htmlspecialchars($name); mysql_escape_string($name);
	$tell = trim($_POST['phone']); htmlspecialchars($tell); mysql_escape_string($tell);
	$email = trim($_POST['email']); htmlspecialchars($email); mysql_escape_string($email);
	$pass = trim($_POST['password']); htmlspecialchars($pass); mysql_escape_string($pass);
	$pass2 = trim($_POST['password2']); htmlspecialchars($pass2); mysql_escape_string($pass2);
	
	if ($pass != "" && $pass2 != ""){
	    if ($pass == $pass2){
		    $sql = "UPDATE user_" . $_SESSION['companyID'] . " SET name='" . $name . "', surname='" . $surname . "', tell='" . $tell . "', email='" . $email . "', password='" . $pass . "' WHERE login='" . $_SESSION['login'] . "'";
			$mysql->query($sql) or die('Ошибка при выполнении запроса');
			//echo "Изменения успешно сохранены";
		}
		else{
		    $_SESSION['error'] = "Пароли не совпадают";
		}
	}
	else{
		$_SESSION['error'] = "Пароли не введены";
	}
}

if (isset($_POST['delete_company'])){
    $id = $_SESSION['companyID'];
	//$sql = "DELETE FROM company WHERE companyID=" . $id;
	//$mysql->query($sql) or die('Ошибка при выполнении запроса');
	//$sql = "DROP TABLE log_" . $id . ", rankPerm_" . $id . ", permission_" . $id . ", userRank_" . $id . ", rank_" . $id . ", wpType_" . $id . ", category_" . $id . ", brand_" . $id . ", item_" . $id . ", workplace_" . $id . ", user_" . $id;
	//$mysql->query($sql) or die('Ошибка при выполнении запроса');
	//header("Location: /LogOut");
	echo "Компания якобы удалена, будет удалена по-настоящему, когда в таблице 'company' будет флаг 'deleted':)";
}
?>

<script type="text/javascript">
$(function() {
    $("document").on('click', '.alert .close', function () {
    	$(this).parent().slideUp('fast', function(){$(this).remove();});
	});
});
</script>

<form method="POST" action="">

    <h2>Настройки аккаунта:</h2>
	
    <div class="form-div">
        <label class="form-label" for="familyName"> Логин: </label>
        <input class="form-input" type="text" name="familyName" id="familyName" disabled="true" value="<?php echo $_SESSION['login']?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="familyName"> Фамилия: </label>
        <input class="form-input" type="text" name="familyName" id="familyName" value="<?php if (isset($_SESSION['userData']) && $_SESSION['userData']['surname'] != 'NULL') echo $_SESSION['userData']['surname']?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="givenName"> Имя: </label>
        <input class="form-input" type="text" name="givenName" id="givenName" value="<?php if (isset($_SESSION['userData']) && $_SESSION['userData']['name'] != 'NULL') echo $_SESSION['userData']['name']?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="phone"> Номер телефона: </label>
        <input class="form-input" type="text" name="phone" id="phone" value="<?php if (isset($_SESSION['userData']) && $_SESSION['userData']['tell'] != 'NULL') echo $_SESSION['userData']['tell']?>"/>
    </div>

    <div class="form-div">
        <label class="form-label" for="email"> Электронная почта: </label>
        <input class="form-input" type="email" name="email" id="email" value="<?php if (isset($_SESSION['userData']) && $_SESSION['userData']['email'] != 'NULL') echo $_SESSION['userData']['email']?>"/>
    </div>


    <div class="form-div">
        <label class="form-label" for="password"> Пароль: </label>
        <input class="form-input" type="password" name="password" id="password" value="<?php if (isset($_SESSION['userData']) && $_SESSION['userData']['password'] != 'NULL') echo $_SESSION['userData']['password']?>"/>
    </div>
	
    <div class="form-div">
        <label class="form-label" for="password2"> Пароль: </label>
        <input class="form-input" type="password" name="password2" id="password2" value="<?php if (isset($_SESSION['userData'])) echo $_SESSION['userData']['password']?>"/>
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small" name="btn_save_change"> Сохранить изменения </button>
    </div>

</form>

<?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Администратор') { ?>
<br>
<h2>Вы можете удалить компанию:</h2>

<form method="POST">
    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small" name="delete_company"> Удалить компанию </button>
	</div>
</form>
<?php } ?>
<?php } ?>