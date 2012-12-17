<?php
/**
 * File:        WareHouseLogist.php
 * Created by:  Ikarius
 * Date:        12/7/12 at 11:18 PM
 * Last Edit:   12/7/12 at 11:18 PM
 */

if(isset($view['error']) && $view['error'] != '')
    echo '<div class="message error">'.$view['error'].'</div>';

if(isset($view['success']) && $view['success'] != '')
    echo '<div class="message success">'.$view['success'].'</div>';

if($view['step'] == 1){
    ?>

<form method="post" action="/WorkPoint/WareHouseLogist/ChooseWareHouse">

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

<script type="text/javascript">SS.whLogist.init();</script>
<form method="post" class="wh-logist-form" action="/WorkPoint/WareHouseLogist/WareHouseNumber:<?php echo $view['currentWorkPlace']['ID']; ?>">

    <h2>Создать доставку:</h2>
    <div class="form-div">
        <label class="form-label" for="pickup"> Место погрузки:</label>
        <select name="pickup" id="pickup">
        <optgroup label="Склады:">
            <?php foreach ($view['wareHouses']  as $wareHouse)
            echo '<option value="'.$wareHouse['ID'].'">'.$wareHouse['address'].'</option>';
            ?>
        </optgroup>
        <optgroup label="Магазины:">
            <?php foreach ($view['stores']  as $store)
            echo '<option value="'.$store['ID'].'">'.$store['address'].'</option>';
            ?>
        </optgroup>
        </select>
    </div>

    <div class="form-div">
        <label class="form-label" for="destination"> Место назначения:</label>
        <select name="destination" id="destination">
        <optgroup label="Склады:">
            <?php foreach ($view['wareHouses']  as $wareHouse)
            echo '<option value="'.$wareHouse['ID'].'">'.$wareHouse['address'].'</option>';
            ?>
        </optgroup>
        <optgroup label="Магазины:">
            <?php foreach ($view['stores']  as $store)
            echo '<option value="'.$store['ID'].'">'.$store['address'].'</option>';
            ?>
        </optgroup>
        </select>
    </div>

	<div class="form-div">
		<label class="form-label" for="product1"> Продукт: </label>
		<select class="whLogist-product" name="product1" id="product1">
			<?php foreach ($view['items']  as $item)
			echo '<option value="'.$item['ID'].'">'.$item['name'].'</option>';
			?>
		</select>
		<br clear="all" />		
        <label class="form-label" for="goodCount1">Количество: </label>
        <input class="form-input whLogist-goodCount" type="number" min="1" name="goodCount1" id="goodCount1" autofocus/>
    </div>
	<div class="form-div" style="padding: 0 0 10px 80px;">
        <a href="#" class="new-position">добавить позицию</a>
    </div>

    <div class="form-div">
        <label class="form-label" for="responsible">Ответсвенный: </label>
        <input class="form-input" type="text" name="responsible" id="responsible" autofocus/>
    </div>

    <div class="form-btn">
        <button type="submit" class="btn btn-primary btn-small"> Создать запрос </button>
    </div>
</form>

    <br/>
    <hr/>
    <br/>

<h2>Не завершонные доставки:</h2>
<table border="1px">
    <tr>
        <th>Время создания запроса</th>
        <th>Список продуктов</th>
        <th>От куда</th>
        <th>Куда</th>
        <th>Ответсвенный</th>
    </tr>
    <?php foreach($view['pendingDelivery'] as $pendingDelivery) { ?>
        <tr>
            <td><?php echo $pendingDelivery['dispatchTime'];?></td>
            <td>
                <ul>
                    <?php foreach($pendingDelivery['items'] as $item) { ?>
                        <li><?php echo $item['name'].' ('.$item['count'].')';?></li>
                    <?php } ?>
                </ul>
            </td>
                <?php   $trans1 = ($pendingDelivery['workplaceFromType']=='wh')?'Склад':'Магазин';
                        $trans2 = ($pendingDelivery['workplaceToType']=='wh')?'Склад':'Магазин';?>
            <td><?php echo $trans1.': '.$pendingDelivery['workplaceFromAddress'];?></td>
            <td><?php echo $trans2.': '.$pendingDelivery['workplaceToAddress'];?></td>
            <td><?php echo $pendingDelivery['responsible'];?></td>
        </tr>
    <?php } ?>
</table>

<br/>
<hr/>
<br/>

<h2>Не завершонные доставки:</h2>

<table border="1px">
    <tr>
        <th>Запрощик</th>
        <th>Продукт</th>
        <th>Количество</th>
    </tr>
    <?php foreach($view['requests'] as $request) { ?>
    <tr>
        <td><?php echo $request['user'];?></td>
        <td><?php echo $request['item'];?></td>
        <td><?php echo $request['count'];?></td>
    </tr>
    <?php } ?>
</table>

<?php } ?>