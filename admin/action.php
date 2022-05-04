<?php
    include "inc/admin.php";
    
    if($_POST){
        $admins = new Admins();
        $action = $_POST["action"];
    }

    if ($action == "checkAdminLogin"){
        $result = $admins->checkAdminLogin($_POST);
        echo $result;
    }

    if ($action == "addUser"){
        $result = $admins->addUser($_POST);
        echo $result;
    }

    if ($action == "getUserListOnLoad"){
        $result = $admins->getUserListOnLoad($_POST);
        echo $result;
    }

    if ($action == "updateUser"){
        $result = $admins->updateUser($_POST);
        echo $result;
    }

    if ($action == "deleteUser"){
        $result = $admins->deleteUser($_POST);
        echo $result;
    }
    
  if ($action == "addItem"){
        $result = $admins->addItem($_POST);
        echo $result;
    }

    if ($action == "getItemsListOnLoad"){
        $result = $admins->getItemsListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getItemListOnLoad"){
        $result = $admins->getItemListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsListOnLoad"){
        $result = $admins->getSendItemsListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsToRegionListOnLoad"){
        $result = $admins->getSendItemsToRegionListOnLoad($_POST);
        echo $result;
    } 

    if ($action == "getSendItemsToSiteListOnLoad"){
        $result = $admins->getSendItemsToSiteListOnLoad($_POST);
        echo $result;
    } 

    if ($action == "getSendItemsSubregionToSiteListOnLoad"){
        $result = $admins->getSendItemsSubregionToSiteListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSendItemsDetailByID"){
        $result = $admins->getSendItemsDetailByID($_POST);
        echo $result;
    }            

    if ($action == "updateItem"){
        $result = $admins->updateItem($_POST);
        echo $result;
    }

      if ($action == "updateFaulty"){
        $result = $admins->updateFaulty($_POST);
        echo $result;
    }

    if ($action == "updateSendItem"){
        $result = $admins->updateSendItem($_POST);
        echo $result;
    }

     if ($action == "updateItemSite"){
        $result = $admins->updateItemSite($_POST);
        echo $result;
    }

    if ($action == "updateItemFaulty"){
        $result = $admins->updateItemFaulty($_POST);
        echo $result;
    }    

    if ($action == "deleteItem"){
        $result = $admins->deleteItem($_POST);
        echo $result;
    }

    if ($action == "addRequest"){
        $result = $admins->addRequest($_POST);
        echo $result;
    }

    if ($action == "deleteRequest"){
        $result = $admins->deleteRequest($_POST);
        echo $result;
    }


    if ($action == "getRequestListOnLoad"){
        $result = $admins->getRequestListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getCategoryListOnLoad"){
        $result = $admins->getCategoryListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSummaryListOnLoad"){
        $result = $admins->getSummaryListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getSummaryGraph"){
        $result = $admins->getSummaryGraph($_POST);
        echo $result;
    }

    if ($action == "getMonthlyItemListOnLoad"){
        $result = $admins->getMonthlyItemListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getMonthlyGraph"){
        $result = $admins->getMonthlyGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByRegionOnLoad"){
        $result = $admins->getItemListByRegionOnLoad($_POST);
        echo $result;
    }

    if ($action == "getRegionGraph"){
        $result = $admins->getRegionGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByAgencyOnLoad"){
        $result = $admins->getItemListByAgencyOnLoad($_POST);
        echo $result;
    }

    if ($action == "getAgencyGraph"){
        $result = $admins->getAgencyGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByStatusOnLoad"){
        $result = $admins->getItemListByStatusOnLoad($_POST);
        echo $result;
    }

    if ($action == "getStatusGraph"){
        $result = $admins->getStatusGraph($_POST);
        echo $result;
    }

    if ($action == "getItemListByDeliveryOnLoad"){
        $result = $admins->getItemListByDeliveryOnLoad($_POST);
        echo $result;
    }

    if ($action == "getDeliveryStatusGraph"){
        $result = $admins->getDeliveryStatusGraph($_POST);
        echo $result;
    }

    if ($action == "test"){
        $result = $admins->test($_POST);
        echo $result;
    }

    if ($action == "getFaultyRecordOnLoad"){
        $result = $admins->getFaultyRecordOnLoad($_POST);
        echo $result;
    }

    if ($action == "getFaultyRecordByID"){
        $result = $admins->getFaultyRecordByID($_POST);
        echo $result;
    }

    

?>