<?php
/**
 * File:        WareHouseGoodsManager.php
 * Created by:  Ikarius
 * Date:        12/7/12 at 11:17 PM
 * Last Edit:   12/7/12 at 11:17 PM
 */

if(isset($view['error']) && $view['error'] != '')
    echo '<div class="message error">'.$view['error'].'</div>';

if(isset($view['success']) && $view['success'] != '')
    echo '<div class="message success">'.$view['success'].'</div>';

if($view['step'] == 1){
?>

<form method="post" action="/WorkPoint/WareHouseGoodsManager/ChooseWareHouse">

    <h2>Выберите рабочея место:</h2>

    <div class="form-div">
        <label class="form-label" for="chosenWorkPlace"> Место работы: </label>
        <select name="chosenWorkPlace" id="chosenWorkPlace">
            <?php foreach ($view['possibleWorkPlaces']  as $possibleWorkPlace)
                echo '<option value="'.$possibleWorkPlace['ID'].'">'.$possibleWorkPlace['address'].'</option>';
            ?>
        </select>
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
    </div>
</form>
<?php }
elseif($view['step'] == 2) {?>

<h1>Товароведывание слада <?php echo $view['currentWorkPlace']['address'] ?>:</h1>
<h3>Введите наличея данного товара:</h3>

<form method="post" action="/WorkPoint/WareHouseGoodsManager/WareHouseNumber:<?php echo $view['currentWorkPlace']['ID']; ?>">

    <div class="form-div">
        <label class="form-label" for="goodType"> Тип товара: </label>
        <div class="brd">
            <input type = 'radio' name ="goodType" id="goodType" value= 'new' checked="true">
            <label class="form-label3" for="new"> Новый </label>
            <br/>
            <input type = 'radio' name ="goodType" id="goodType" value= 'existent'>
            <label class="form-label3" for="existent"> Существующей </label>
        </div>
    </div>

    <div class="form-div">
        <label class="form-label" for="newGoodName">Новый товар: </label>
        <input class="form-input" type="text" name="newGoodName" id="newGoodName" autofocus/>
    </div>

    <div class="form-div">
        <label class="form-label" for="existentGoodName">Сушествующей товар: </label>
        <select class="form-input" name="existentGoodName" id="existentGoodName">
            <?php foreach ($view['nameList'] as $nameList)
            echo '<option value="'.$nameList.'">'.$nameList.'</option>';
            ?>
        </select>
    </div>

    <div class="form-div">
        <label class="form-label" for="goodCount">Количество: </label>
        <input class="form-input" type="number" min="0" name="goodCount" id="goodCount" autofocus/>
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small"> Продолжить </button>
    </div>
</form>
<?php } ?>