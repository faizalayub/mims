<?php
    include "inc/user2.php";
    
    if($_POST){
        $users = new Users();
        $action = $_POST["action"];
    }

    if ($action == "checkUserLogin"){
        $result = $users->checkUserLogin($_POST);
        echo $result;
    } 

    if ($action == "changeuserpassword"){
        $result = $users->changePasswordUser($_POST);
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

    if ($action == "getCategoryListOnLoad"){
        $result = $users->getCategoryListOnLoad($_POST);
        echo $result;
    }

   if ($action == "getCategoryDetailByID"){
        $result = $users->getCategoryDetailByID($_POST);
        echo $result;
    } 

    if ($action == "getRegionListOnLoad"){
        $result = $users->getRegionListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getReportCategoryListOnLoad"){
        $result = $users->getReportCategoryListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getMonthlyItemListOnLoad"){
        $result = $users->getMonthlyItemListOnLoad($_POST);
        echo $result;
    }

    if ($action == "getItemListByStoreOnLoad"){
        $result = $users->getItemListByStoreOnLoad($_POST);
        echo $result;
    }

    if ($action == "getItemListByAgencyOnLoad"){
        $result = $users->getItemListByAgencyOnLoad($_POST);
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