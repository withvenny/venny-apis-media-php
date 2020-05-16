<?php

    //
    header('Content-Type: application/json');

    //
    use Media\Connection as Connection;
    use Media\Token as Token;
    use Media\Image as Image;
    use Aws\S3\S3Client as S3Client;
    //use S3\Exception\S3Exception as S3Exception;

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
                $image = new Image($pdo);

                // insert a stock into the stocks table
                $id = $image->insertImage($request);
            
                $request['id'] = $id;

                $results = $image->selectImages($request);

                $path_parts = pathinfo($_FILES['image']['name']);

                echo $path_parts['dirname'], "\n";
                echo $path_parts['basename'], "\n";
                echo $path_parts['extension'], "\n";
                echo $path_parts['filename'], "\n"; // since PHP 5.2.0

                $key = $request['id'] . "." . $path_parts['extension'];

                //
                print_r($_FILES); exit;

                /* AWS S3 */
                $s3 = S3Client::factory([

                    'credentials' => [
                        'key' => getenv('AWS_ACCESS_KEY_ID'),
                        'secret' => getenv('AWS_SECRET_ACCESS_KEY')
                    ],
                    'bucket' => getenv('S3_BUCKET'),
                    'version' => 'latest',
                    'region'  => 'us-east-1'
                ]);
                
                $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');

                if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
    
                    // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    try {
                        
                        // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                        $upload = $s3->upload(
                            $bucket, // Bucket to upload the object.
                            $key, // Key of the object.
                            fopen($_FILES['image']['tmp_name'], 'rb'), // Object data to upload. Can be a StreamInterface, PHP stream resource, or a string of data to upload.
                            'public-read' // ACL to apply to the object (default: private).
                        );
                
                    } catch(Exception $e) {
                
                        echo "Ooops";
                
                    }
                
                };

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
                $image = new Image($pdo);

                // get all stocks data
                $results = $image->selectImages($request);

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
                $image = new Image($pdo);
            
                // insert a stock into the stocks table
                $id = $image->updateImage($request);

                $request['id'] = $id;

                $results = $image->selectImages($request);

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
                $image = new Image($pdo);
            
                // insert a stock into the stocks table
                $id = $image->deleteImage($request);

                echo 'The record ' . $id . ' has been deleted';
            
            } catch (\PDOException $e) {

                echo $e->getMessage();

            }

        break;

    }

?>
