<?php
    include "inc/user.php";
    
    if($_POST){
        $users = new Users();
        $action = $_POST["action"];
    }

    if ($action == "checkUserLogin"){
        $result = $users->checkUserLogin($_POST);
        echo $result;
    }    
    
    if ($action == "addItem"){
        $result = $users->addItem($_POST);
        echo $result;
    }

    if ($action == "getItemsListOnLoad"){
        $result = $users->getItemsListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getItemListOnLoad"){
        $result = $users->getItemListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsListOnLoad"){
        $result = $users->getSendItemsListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsToRegionListOnLoad"){
        $result = $users->getSendItemsToRegionListOnLoad($_POST);
        echo $result;
    } 

    if ($action == "getSendItemsToSiteListOnLoad"){
        $result = $users->getSendItemsToSiteListOnLoad($_POST);
        echo $result;
    } 

    if ($action == "getSendItemsSubregionToSiteListOnLoad"){
        $result = $users->getSendItemsSubregionToSiteListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsDetailByID"){
        $result = $users->getSendItemsDetailByID($_POST);
        echo $result;
    }            

    if ($action == "updateItem"){
        $result = $users->updateItem($_POST);
        echo $result;
    }

    if ($action == "updateFaulty"){
        $result = $users->updateFaulty($_POST);
        echo $result;
    }

    if ($action == "updateSendItem"){
        $result = $users->updateSendItem($_POST);
        echo $result;
    }

     if ($action == "updateItemSite"){
        $result = $users->updateItemSite($_POST);
        echo $result;
    }

    if ($action == "updateItemFaulty"){
        $result = $users->updateItemFaulty($_POST);
        echo $result;
    }    

    if ($action == "deleteItem"){
        $result = $users->deleteItem($_POST);
        echo $result;
    }


    if ($action == "addRequest"){
        $result = $users->addRequest($_POST);
        echo $result;
    }


    if ($action == "getRequestListOnLoad"){
        $result = $users->getRequestListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getCategoryListOnLoad"){
        $result = $users->getCategoryListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSummaryListOnLoad"){
        $result = $users->getSummaryListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSummaryGraph"){
        $result = $users->getSummaryGraph($_POST);
        echo $result;
    }

    if ($action == "getMonthlyItemListOnLoad"){
        $result = $users->getMonthlyItemListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getMonthlyGraph"){
        $result = $users->getMonthlyGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByRegionOnLoad"){
        $result = $users->getItemListByRegionOnLoad($_POST);
        echo $result;
    }

    if ($action == "getRegionGraph"){
        $result = $users->getRegionGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByAgencyOnLoad"){
        $result = $users->getItemListByAgencyOnLoad($_POST);
        echo $result;
    }

    if ($action == "getAgencyGraph"){
        $result = $users->getAgencyGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByStatusOnLoad"){
        $result = $users->getItemListByStatusOnLoad($_POST);
        echo $result;
    }

    if ($action == "getStatusGraph"){
        $result = $users->getStatusGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByDeliveryOnLoad"){
        $result = $users->getItemListByDeliveryOnLoad($_POST);
        echo $result;
    }

    if ($action == "getDeliveryStatusGraph"){
        $result = $users->getDeliveryStatusGraph($_POST);
        echo $result;
    }

    if ($action == "test"){
        $result = $users->test($_POST);
        echo $result;
    }

    if ($action == "getFaultyRecordOnLoad"){
        $result = $users->getFaultyRecordOnLoad($_POST);
        echo $result;
    }

    if ($action == "getFaultyRecordByID"){
        $result = $users->getFaultyRecordByID($_POST);
        echo $result;
    }

    

?>