<?php
/**
 * File:        WareHouseLogist.php
 * Created by:  Ikarius
 * Date:        12/8/12 at 7:45 PM
 * Last Edit:   12/8/12 at 7:45 PM
 */

if($_SESSION['connected'])
{
    if($_SERVER['REQUEST_URI'] === '/WorkPoint/WareHouseLogist')
    {
        foreach($_SESSION['post'] as $post)
        {
            if($post['rank'] == 'Администратор')
            {
                $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                            INNER JOIN wpType
                                ON workplace.wpTypeID = wpType.wpTypeID
                            WHERE wpType.description="Склад"';

                foreach ($mysql->query($sql) as $row)
                    $possibleWorkPlaces[] = array('ID' => $row['workplaceID'],
                        'address' => $row['address']);

                break;
            }
            elseif($post['rank'] == 'Товаровед склада')
            {
                if($post['workplace']['type'] == 'Склад')
                    $possibleWorkPlaces[] = array('ID' => $post['workplace']['ID'],
                        'address' => $post['workplace']['address']);

            }
        }

        if(count($possibleWorkPlaces) == 0) $view['error'] = "No warehouse was been assigned to this role, pleas contact the administrator.";
        elseif(count($possibleWorkPlaces) == 1)
        {
            header('Location: /WorkPoint/WareHouseLogist/WareHouseNumber:'.$possibleWorkPlaces[0]['ID']);//redirection
        }
        else
        {
            $view['possibleWorkPlaces'] = $possibleWorkPlaces;
            $_SESSION['possibleWorkPlaces'] = $possibleWorkPlaces;
            $view['step'] = 1;
        }
    }
    elseif($_SERVER['REQUEST_URI'] === '/WorkPoint/WareHouseLogist/ChooseWareHouse')
    {
        foreach($_SESSION['possibleWorkPlaces'] as $possibleWorkPlace)
            $possibleWorkPlaceID[] = $possibleWorkPlace['ID'];
        if(!in_array($_POST['chosenWorkPlace'], $possibleWorkPlaceID))
            $view['error'] = 'Incorrect work place, pleas contact the administrator';
        else
        {
            header('Location: /WorkPoint/WareHouseLogist/WareHouseNumber:'.$_POST['chosenWorkPlace']);//redirection
        }
    }
    elseif(substr_compare($_SERVER['REQUEST_URI'], '/WorkPoint/WareHouseLogist/WareHouseNumber:', 0, 43, true)===0)
    {
        foreach($_SESSION['post'] as $post)
        {
            if($post['rank'] == 'Администратор')
            {
                $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                                INNER JOIN wpType
                                    ON workplace.wpTypeID = wpType.wpTypeID
                                WHERE wpType.description="Склад"';

                foreach ($mysql->query($sql) as $row)
                    $possibleWorkPlaces[] = array('ID' => $row['workplaceID'],
                        'address' => $row['address']);

                break;
            }
            elseif($post['rank'] == 'Товаровед склада')
            {
                if($post['workplace']['type'] == 'Склад')
                    $possibleWorkPlaces[] = array('ID' => $post['workplace']['ID'],
                        'address' => $post['workplace']['address']);

            }
        }

        $askedWorkPlaceID = substr($_SERVER['REQUEST_URI'], 43);

        foreach($possibleWorkPlaces as $possibleWorkPlace)
            if($askedWorkPlaceID == $possibleWorkPlace['ID'])$currentWorkPlace = $possibleWorkPlace;

        if(count($currentWorkPlace) == 0)
            $view['error'] = 'Incorrect work place, pleas contact the administrator';
        else
        {
            $view['askedWorkPlace'] = $askedWorkPlace;

            $sql = 'SELECT itemID, name FROM item_'.$_SESSION['companyID'];
            foreach ($mysql->query($sql) as $row) $items[] = array('ID' => $row['itemID'], 'name' => $row['name']);


            $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                                INNER JOIN wpType
                                    ON workplace.wpTypeID = wpType.wpTypeID
                                WHERE wpType.description="Склад"';

            foreach ($mysql->query($sql) as $row)
                $wareHouses[] = array('ID' => $row['workplaceID'],
                    'address' => $row['address']);

            $count = 0;
            foreach ($wareHouses as $wareHouse)
            {
                if($count == 0) $temp = $wareHouse;
                if($wareHouse['ID'] == $askedWorkPlace['ID'])
                {
                    $wareHouses[0] = $wareHouse;
                    $wareHouses[$count] = $wareHouse;
                }

                $count++;
            }

            $sql = 'SELECT workplaceID, address FROM workplace_'.$_SESSION['companyID'].' as workplace
                                INNER JOIN wpType
                                    ON workplace.wpTypeID=wpType.wpTypeID
                                WHERE wpType.description="Магазин"';

            foreach ($mysql->query($sql) as $row)
                $stores[] = array('ID' => $row['workplaceID'],
                    'address' => $row['address']);

            $view['items'] = $items;
            $view['wareHouses'] = $wareHouses;
            $view['stores'] = $stores;
            $view['currentWorkPlace'] = $currentWorkPlace;


            if(!empty($_POST['pickup']))
            {
                if(empty($_POST['destination'])) $view['error'] = 'Empty destination';
                elseif(empty($_POST['product1'])) $view['error'] = 'Need at least one product';
                elseif(empty($_POST['goodCount1'])) $view['error'] = 'Need product quantity';
                else
                {
                    $responsible = empty($_POST['responsible'])?'NULL':'"'.$_POST['responsible'].'"';

                    $sql = 'INSERT INTO delivery_'.$_SESSION['companyID'].' (`responsible`, `dispatchTime`, `from`, `to`) VALUES ('.$responsible.','.CURRENT_TIMESTAMP.', "'.$_POST['pickup'].'", "'.$_POST['destination'].'");';
                    $mysql->exec($sql);

                    $deliveryID = $mysql->lastInsertId();

                    for($i = 1;;$i++)
                    {
                        if(empty($_POST['product'.$i]) || empty($_POST['goodCount'.$i])) break;
                        $sql = 'INSERT INTO deliveryObject_'.$_SESSION['companyID'].' (`objectID`, `deliveryID`, `count`) VALUES ('.$_POST['product'.$i].', '.$deliveryID.', '.$_POST['goodCount'.$i].')';
                        $mysql->exec($sql);
                    }

                    $view['success'] = 'Delivery successfully created';
                }

            }

            $sql = 'SELECT  delivery.deliveryID, delivery.responsible, delivery.dispatchTime,
                            workplaceFrom.address as workplaceFromAddress, wpTypeFrom.description as workplaceFromDescription,
                            workplaceTo.address as workplaceToAddress, wpTypeTo.description as workplaceToDescription
                        FROM delivery_'.$_SESSION['companyID'].' as delivery
                        INNER JOIN workplace_'.$_SESSION['companyID'].' as workplaceFrom
                            ON delivery.from=workplaceFrom.workplaceID
                        INNER JOIN workplace_'.$_SESSION['companyID'].' as workplaceTo
                            ON delivery.to=workplaceTo.workplaceID
                        INNER JOIN wpType as wpTypeFrom
                            ON workplaceFrom.wpTypeID=wpTypeFrom.wpTypeID
                        INNER JOIN wpType as wpTypeTo
                            ON workplaceTo.wpTypeID=wpTypeTo.wpTypeID
                        WHERE delivery.arrivalTime IS NULL
                        ORDER BY deliveryID DESC';
            $pendingDelivery = array();
            foreach ($mysql->query($sql) as $row) $pendingDelivery[] = array(   'deliveryID' => $row['deliveryID'],
                                                                                'responsible' => $row['responsible'],
                                                                                'dispatchTime' => $row['dispatchTime'],
                                                                                'workplaceFromAddress' => $row['workplaceFromAddress'],
                                                                                'workplaceFromType' => $row['workplaceFromDescription'],
                                                                                'workplaceToAddress' => $row['workplaceToAddress'],
                                                                                'workplaceToType' => $row['workplaceToDescription']);

            foreach($pendingDelivery as $key => $eachPendingDelivery)
            {
                $sql = 'SELECT count, name
                        FROM deliveryObject_'.$_SESSION['companyID'].' as deliveryObject
                        INNER JOIN item_'.$_SESSION['companyID'].' as item
                            ON deliveryObject.objectID=item.itemID
                        WHERE deliveryObject.deliveryID='.$eachPendingDelivery['deliveryID'].'
                        ORDER BY name ASC';
                foreach ($mysql->query($sql) as $row)
                    $pendingDelivery[$key]['items'][] = array(   'name' => $row['name'],
                                                                 'count' => $row['count']);
            }

            $view['pendingDelivery'] = $pendingDelivery;

            $sql = 'SELECT requestID, user.login, item.name, count
                        FROM request_'.$_SESSION['companyID'].' as request
                        INNER JOIN user_'.$_SESSION['companyID'].' as user
                            ON user.userID=request.userID
                        INNER JOIN  item_'.$_SESSION['companyID'].' as item
                            ON item.itemID=request.objectID';
            $requests = array();
            foreach ($mysql->query($sql) as $row)
                $requests[] = array(    'ID' => $row['requestID'],
                                        'user' => $row['login'],
                                        'item' => $row['name'],
                                        'count' => $row['count']);
            $view['requests'] = $requests;

            $view['step'] = 2;

        }
    }



    $view['Content'] = 'Templates/WorkPoints/WareHouseLogist.php';

}