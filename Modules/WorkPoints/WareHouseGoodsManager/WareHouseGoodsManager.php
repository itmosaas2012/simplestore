<?php
/**
 * File:        WareHouseGoodsManager.php
 * Created by:  Ikarius
 * Date:        12/8/12 at 7:43 PM
 * Last Edit:   12/8/12 at 7:43 PM
 */



if($_SESSION['connected'])
{
    if($_SERVER['REQUEST_URI'] === '/WorkPoint/WareHouseGoodsManager')
    {
        foreach($_SESSION['post'] as $post)
        {
            if($post['rank'] == 'Администратор')
            {
                $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                            INNER JOIN wpType
                                ON workplace.wpTypeID = wpType.wpTypeID
                            WHERE wpType.description="wh"';

                foreach ($mysql->query($sql) as $row)
                    $possibleWorkPlaces[] = array('ID' => $row['workplaceID'],
                                                'address' => $row['address']);

                break;
            }
            elseif($post['rank'] == 'Товаровед склада')
            {
                if($post['workplace']['type'] == 'wh')
                    $possibleWorkPlaces[] = array('ID' => $post['workplace']['ID'],
                                                'address' => $post['workplace']['address']);

            }
        }

        if(count($possibleWorkPlaces) == 0) $view['error'] = "No warehouse was been assigned to this role, pleas contact the administrator.";
        elseif(count($possibleWorkPlaces) == 1)
        {
            header('Location: /WorkPoint/WareHouseGoodsManager/WareHouseNumber:'.$possibleWorkPlaces[0]['ID']);//redirection
        }
        else
        {
            $view['possibleWorkPlaces'] = $possibleWorkPlaces;
            $_SESSION['possibleWorkPlaces'] = $possibleWorkPlaces;
            $view['step'] = 1;
        }
    }
    elseif($_SERVER['REQUEST_URI'] === '/WorkPoint/WareHouseGoodsManager/ChooseWareHouse')
    {
        foreach($_SESSION['possibleWorkPlaces'] as $possibleWorkPlace)
            $possibleWorkPlaceID[] = $possibleWorkPlace['ID'];
        if(!in_array($_POST['chosenWorkPlace'], $possibleWorkPlaceID))
            $view['error'] = 'Incorrect work place, pleas contact the administrator';
        else
        {
            header('Location: /WorkPoint/WareHouseGoodsManager/WareHouseNumber:'.$_POST['chosenWorkPlace']);//redirection
        }
    }
    elseif(substr_compare($_SERVER['REQUEST_URI'], '/WorkPoint/WareHouseGoodsManager/WareHouseNumber:', 0, 49, true)===0)
    {
        foreach($_SESSION['post'] as $post)
        {
            if($post['rank'] == 'Администратор')
            {
                $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                                INNER JOIN wpType
                                    ON workplace.wpTypeID = wpType.wpTypeID
                                WHERE wpType.description="wh"';

                foreach ($mysql->query($sql) as $row)
                    $possibleWorkPlaces[] = array('ID' => $row['workplaceID'],
                        'address' => $row['address']);

                break;
            }
            elseif($post['rank'] == 'Товаровед склада')
            {
                if($post['workplace']['type'] == 'wh')
                    $possibleWorkPlaces[] = array('ID' => $post['workplace']['ID'],
                        'address' => $post['workplace']['address']);

            }
        }

        $askedWorkPlaceID = substr($_SERVER['REQUEST_URI'], 49);

        foreach($possibleWorkPlaces as $possibleWorkPlace)
            if($askedWorkPlaceID == $possibleWorkPlace['ID'])$currentWorkPlace = $possibleWorkPlace;

        if(count($currentWorkPlace) == 0)
            $view['error'] = 'Incorrect work place, pleas contact the administrator';
        else
        {
            if(!empty($_POST['goodCount']))
            {
                if($_POST['goodType'] == 'new')
                {
                    if($_POST['newGoodName'] == '') $view['error'] = 'Good name are empty.';
                    else
                    {
                        $sql = 'SELECT count(itemID) FROM item_'.$_SESSION['companyID'].' WHERE name="'.$_POST['newGoodName'].'"';
                        foreach ($mysql->query($sql) as $row) $existingItemCount = $row['count(itemID)'];

                        if($existingItemCount != 0) $view['error'] = 'Item already exist.';
                        else
                        {
                            $sql = 'INSERT INTO item_'.$_SESSION['companyID'].' (name) VALUES ("'.$_POST['newGoodName'].'")';
                            $mysql->exec($sql);

                            $sql = 'SELECT itemID FROM item_'.$_SESSION['companyID'].' WHERE name="'.$_POST['newGoodName'].'"';
                            foreach ($mysql->query($sql) as $row) $itemID = $row['itemID'];

                            $sql = 'INSERT INTO object_'.$_SESSION['companyID'].' (workplaceID, itemID, count) VALUES ("'.$currentWorkPlace['ID'].'", "'.$itemID.'", "'.$_POST['goodCount'].'")';
                            $mysql->exec($sql);

                            $view['success'] = "New good added.";
                        }
                    }
                }
                else
                {
                    $sql = 'SELECT count(itemID) FROM item_'.$_SESSION['companyID'].' WHERE name="'.$_POST['existentGoodName'].'"';
                    foreach ($mysql->query($sql) as $row) $existingItemCount = $row['count(itemID)'];

                    if($existingItemCount == 0) $view['error'] = 'Item unknown, pleas contact an Administrator.';
                    else
                    {
                        $sql = 'SELECT itemID FROM item_'.$_SESSION['companyID'].' WHERE name="'.$_POST['existentGoodName'].'"';
                        foreach ($mysql->query($sql) as $row) $itemID = $row['itemID'];

                        $sql = 'SELECT count(itemID) FROM object_'.$_SESSION['companyID'].' WHERE itemID='.$itemID.' AND workplaceID="'.$currentWorkPlace['ID'].'"';
                        foreach ($mysql->query($sql) as $row) $existingObjectCount = $row['count(itemID)'];

                        if($existingObjectCount == 0)
                        {
                            $sql = 'INSERT INTO object_'.$_SESSION['companyID'].' (workplaceID, itemID, count) VALUES ("'.$currentWorkPlace['ID'].'", "'.$itemID.'", "'.$_POST['goodCount'].'")';
                            $mysql->exec($sql);
                        }
                        else
                        {
                            $sql = 'UPDATE object_'.$_SESSION['companyID'].' SET count='.$_POST['goodCount'].' WHERE itemID='.$itemID.' AND workplaceID="'.$currentWorkPlace['ID'].'"';
                            $mysql->exec($sql);

                            $view['success'] = "Good updated.";
                        }

                    }
                }
            }

            $view['currentWorkPlace'] = $currentWorkPlace;
            $sql = 'SELECT name FROM item_'.$_SESSION['companyID'];
            foreach ($mysql->query($sql) as $row) $nameList[] = $row['name'];
            if(!empty($nameList)) $view['nameList'] = $nameList;
            $view['step'] = 2;
        }

    }
    $view['Content'] = 'Templates/WorkPoints/WareHouseGoodsManager.php';


}