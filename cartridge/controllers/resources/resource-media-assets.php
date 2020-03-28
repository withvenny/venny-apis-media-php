<?php

    //
    header('Content-Type: application/json');

    //
    use Media\Connection as Connection;
    use Media\Token as Token;
    use Media\Asset as Asset;

    // connect to the PostgreSQL database
    $pdo = Connection::get()->connect();

    // STEP 1. Receive passed variables / information
    if(isset($_REQUEST['app'])){$request['app'] = clean($_REQUEST['app']);}
    if(isset($_REQUEST['domain'])){$request['domain'] = clean($_REQUEST['domain']);}
    if(isset($_REQUEST['token'])){$request['token'] = clean($_REQUEST['token']);}

    // INITIATE DATA CLEANSE
    if(isset($_REQUEST['id'])){$request['id'] = clean($_REQUEST['id']);}		
    if(isset($_REQUEST['attributes'])){$request['attributes'] = clean($_REQUEST['attributes']);}		
    if(isset($_REQUEST['type'])){$request['type'] = clean($_REQUEST['type']);}		
    if(isset($_REQUEST['status'])){$request['status'] = clean($_REQUEST['status']);}		
    if(isset($_REQUEST['primary'])){$request['primary'] = clean($_REQUEST['primary']);}		
    if(isset($_REQUEST['object'])){$request['object'] = clean($_REQUEST['object']);}		
    if(isset($_REQUEST['caption'])){$request['caption'] = clean($_REQUEST['caption']);}		
    if(isset($_REQUEST['filename'])){$request['filename'] = clean($_REQUEST['filename']);}		
    if(isset($_REQUEST['metadata'])){$request['metadata'] = clean($_REQUEST['metadata']);}
    if(isset($_REQUEST['profile'])){$request['profile'] = clean($_REQUEST['profile']);}

    //
    switch ($_SERVER['REQUEST_METHOD']) {

        //
        case 'POST':

            try {

                // 
                $asset = new Asset($pdo);
            
                // insert a stock into the stocks table
                $id = $asset->insertAsset($request);

                $request['id'] = $id;

                $results = $asset->selectAssets($request);

                $results = json_encode($results);
                
                //
                echo $results;
            
            } catch (\PDOException $e) {

                echo $e->getMessage();

            }

        break;

        //
        case 'GET':

            //
            if(isset($_REQUEST['per'])){$request['per'] = clean($_REQUEST['per']);}
            if(isset($_REQUEST['page'])){$request['page'] = clean($_REQUEST['page']);}
            if(isset($_REQUEST['limit'])){$request['limit'] = clean($_REQUEST['limit']);}        

            try {

                // 
                $asset = new Asset($pdo);

                // get all stocks data
                $results = $asset->selectAssets($request);

                $results = json_encode($results);

                echo $results;

            } catch (\PDOException $e) {

                echo $e->getMessage();

            }

        break;

        //
        case 'PUT':

            try {

                // 
                $asset = new Asset($pdo);
            
                // insert a stock into the stocks table
                $id = $asset->updateAsset($request);

                $request['id'] = $id;

                $results = $asset->selectAssets($request);

                $results = json_encode($results);

                echo $results;
            
            } catch (\PDOException $e) {

                echo $e->getMessage();

            }

        break;

        //
        case 'DELETE':

            try {

                // 
                $asset = new Asset($pdo);
            
                // insert a stock into the stocks table
                $id = $asset->deleteAsset($request);

                echo 'The record ' . $id . ' has been deleted';
            
            } catch (\PDOException $e) {

                echo $e->getMessage();

            }

        break;

    }

?>
