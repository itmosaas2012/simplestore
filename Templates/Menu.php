<?php
/**
 * File:        Menu.php
 * Created by:  Ikarius
 * Date:        11/17/12 at 1:53 PM
 * Last Edit:   11/19/12 at 6:53 PM by kokovtsev
 */
?>
    <nav class="header_menu">
        <ul>
            <li class="menuSeparator"></li>
            <li class="header_menu_item">
                <a href="#">Item 1</a>
                <!-- InstanceBeginEditable name="header_subMenu" -->
                <nav class="header_subMenu">
                    <ul>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 1.1</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 1.2</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 1.3</a></li>
                        <li class="menuSeparator"></li>
                    </ul>
                <!-- end .header_subMenu --></nav>
                <!-- InstanceEndEditable -->
            </li>
            <li class="menuSeparator">::</li>
            <li class="header_menu_item"><a href="#">Item 2</a>
                <!-- InstanceBeginEditable name="header_subMenu" -->
                <nav class="header_subMenu">
                    <ul>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 2.1</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 2.2</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 2.3</a></li>
                        <li class="menuSeparator"></li>
                    </ul>
                <!-- end .header_subMenu --></nav>
                <!-- InstanceEndEditable -->
            </li>
            <li class="menuSeparator">::</li>
            <li class="header_menu_item"><a href="#">Item 3</a>
                <!-- InstanceBeginEditable name="header_subMenu" -->
                <nav class="header_subMenu">
                    <ul>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 3.1</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 3.2</a></li>
                        <li class="menuSeparator"></li>
                        <li class="heder_subMenu_item"><a href="#">Item 3.3</a></li>
                        <li class="menuSeparator"></li>
                    </ul>
                <!-- end .header_subMenu --></nav>
                <!-- InstanceEndEditable -->
            </li>
            <li class="menuSeparator">::</li>
            
            <?php if($_SESSION['connected']){ ?>
                <li class="header_menu_item">
                <a href='/Settings'>Настройки</a></li>
				<li class="menuSeparator">::</li>
            <?php } ?>  

            <!--Administration-->
            <?php if($_SESSION['connected'] && $_SESSION['rank'] == 'Администратор') { ?>
            <li class="header_menu_item"><a href="#">
                <a href="/Administration">Администрация</a>
                <nav class="header_subMenu">
                <ul>
                    <li class="menuSeparator"></li>
                    <li class="heder_subMenu_item"><a href="/Administration/Staff">Управления соотрудников</a></li>
                    <li class="menuSeparator"></li>
                    <li class="heder_subMenu_item"><a href="/Administration/WareHouses">Управления складов</a></li>
                    <li class="menuSeparator"></li>
                    <li class="heder_subMenu_item"><a href="/Administration/Stores">Управления магазинов</a></li>
                    <li class="menuSeparator"></li>
                </ul>
                <!-- end .header_subMenu --></nav></li>
            <li class="menuSeparator">::</li>
            <?php } ?>
        </ul>
		<!-- end .header_actions --></nav>


