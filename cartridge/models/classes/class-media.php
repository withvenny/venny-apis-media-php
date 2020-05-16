<?php

    //
    namespace Media;

    //
    class Connection {
    
        /**
         * Connection
         * @var type 
         */
        private static $conn;
    
        /**
         * Connect to the database and return an instance of \PDO object
         * @return \PDO
         * @throws \Exception
         */
        public function connect() {

            // read parameters in the ini configuration file
            //$params = parse_ini_file('database.ini');
            $db = parse_url(getenv("DATABASE_URL"));

            //if ($params === false) {throw new \Exception("Error reading database configuration file");}
            if ($db === false) {throw new \Exception("Error reading database configuration file");}
            // connect to the postgresql database
            $conStr = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
                    $db['host'],
                    $db['port'], 
                    ltrim($db["path"], "/"), 
                    $db['user'], 
                    $db['pass']);
    
            $pdo = new \PDO($conStr);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
            return $pdo;
        }
    
        /**
         * return an instance of the Connection object
         * @return type
         */
        public static function get() {
            if (null === static::$conn) {
                static::$conn = new static();
            }
    
            return static::$conn;
        }
    
        protected function __construct() {
            
        }
    
        private function __clone() {
            
        }
    
        private function __wakeup() {
            
        }
    
    }

    //
    class Token {

        /**
         * PDO object
         * @var \PDO
         */
        private $pdo;
    
        /**
         * init the object with a \PDO object
         * @param type $pdo
         */
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        /**
         * Return all rows in the stocks table
         * @return array
         */
        public function all() {
            $stmt = $this->pdo->query('SELECT id, symbol, company '
                    . 'FROM stocks '
                    . 'ORDER BY symbol');
            $stocks = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $stocks[] = [
                    'id' => $row['id'],
                    'symbol' => $row['symbol'],
                    'company' => $row['company']
                ];
            }
            return $stocks;
        }

        //
        public function validatedToken() {
            
            //
            return true;
            
            //exit;

        }

        //
        public function process_id($object='obj') {

            //
            $id = substr(md5(uniqid(microtime(true),true)),0,13);

            $id = $object.'_'.$id;

            //
            return $id;
            
            //exit;

        }
        
        //
        public function event_id($object='obj') {

            //
            $id = substr(md5(uniqid(microtime(true),true)),0,13);

            $id = $object.'_'.$id;
    
            //
            return $id;
            
            //exit;

        }

        //
        public function new_id($object='obj') {

            //
            $id = substr(md5(uniqid(microtime(true),true)),0,13);
            $id = $object . "_" . $id;
    
            //
            return $id;
            
            //exit;

        }

        /**
         * Find stock by id
         * @param int $id
         * @return a stock object
         */
        public function check($id) {

            //
            $sql = "SELECT message_id FROM messages WHERE id = :id AND active = 1";

            // prepare SELECT statement
            $statement = $this->pdo->prepare($sql);
            // bind value to the :id parameter
            $statement->bindValue(':id', $id);
            
            // execute the statement
            $stmt->execute();
    
            // return the result set as an object
            return $stmt->fetchObject();
        }

        /**
         * Delete a row in the stocks table specified by id
         * @param int $id
         * @return the number row deleted
         */
        public function delete($id) {
            $sql = 'DELETE FROM stocks WHERE id = :id';
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
    
            $stmt->execute();
    
            return $stmt->rowCount();
        }

        /**
         * Delete all rows in the stocks table
         * @return int the number of rows deleted
         */
        public function deleteAll() {
    
            $stmt = $this->pdo->prepare('DELETE FROM stocks');
            $stmt->execute();
            return $stmt->rowCount();
        }

    }

    //
    class Asset {

        //
        private $pdo;
    
        //
        public function __construct($pdo) {

            //
            $this->pdo = $pdo;

            //
            $this->token = new \Media\Token($this->pdo);

        }

        //
        public function insertAsset($request) {

            //generate ID
            if(!isset($request['id'])){$request['id'] = $this->token->new_id('img');}

            $columns = "";

            // INSERT OBJECT - COLUMNS
            if(isset($request['id'])){$columns.="image_id,";}		
            if(isset($request['attributes'])){$columns.="asset_attributes,";}		
            if(isset($request['type'])){$columns.="asset_type,";}		
            if(isset($request['status'])){$columns.="asset_status,";}		
            if(isset($request['primary'])){$columns.="asset_primary,";}		
            if(isset($request['object'])){$columns.="asset_object,";}		
            if(isset($request['caption'])){$columns.="asset_caption,";}		
            if(isset($request['filename'])){$columns.="asset_filename,";}		
            if(isset($request['metadata'])){$columns.="asset_metadata,";}
            if(isset($request['profile'])){$columns.="profile_id,";}		

            $columns.= "app_id,";
            $columns.= "event_id,";
            $columns.= "process_id";

            $values = "";

            // INSERT OBJECT - VALUES
            if(isset($request['id'])){$values.=":asset_id,";}		
            if(isset($request['attributes'])){$values.=":asset_attributes,";}		
            if(isset($request['type'])){$values.=":asset_type,";}		
            if(isset($request['status'])){$values.=":asset_status,";}		
            if(isset($request['primary'])){$values.=":asset_primary,";}		
            if(isset($request['object'])){$values.=":asset_object,";}		
            if(isset($request['caption'])){$values.=":asset_caption,";}		
            if(isset($request['filename'])){$values.=":asset_filename,";}		
            if(isset($request['metadata'])){$values.=":asset_metadata,";}	
            if(isset($request['profile'])){$values.=":profile_id,";}

            $values.= ":app_id,";
            $values.= ":event_id,";
            $values.= ":process_id";

            // prepare statement for insert
            $sql = "INSERT INTO {$request['domain']} (";
            $sql.= $columns;
            $sql.= ") VALUES (";
            $sql.= $values;
            $sql.= ")";
            $sql.= " RETURNING " . prefixed($request['domain']) . "_id";
    
            //
            $statement = $this->pdo->prepare($sql);
            
            // INSERT OBJECT - BIND VALUES
            if(isset($request['id'])){$statement->bindValue('asset_id',$request['id']);}		
            if(isset($request['attributes'])){$statement->bindValue('asset_attributes',$request['attributes']);}		
            if(isset($request['type'])){$statement->bindValue('asset_type',$request['type']);}		
            if(isset($request['status'])){$statement->bindValue('asset_status',$request['status']);}		
            if(isset($request['primary'])){$statement->bindValue('asset_primary',$request['primary']);}		
            if(isset($request['object'])){$statement->bindValue('asset_object',$request['object']);}		
            if(isset($request['caption'])){$statement->bindValue('asset_caption',$request['caption']);}		
            if(isset($request['filename'])){$statement->bindValue('asset_filename',$request['filename']);}		
            if(isset($request['metadata'])){$statement->bindValue('asset_metadata',$request['metadata']);}
            if(isset($request['profile'])){$statement->bindValue('profile_id',$request['profile']);}

            $statement->bindValue(':app_id', $request['app']);
            $statement->bindValue(':event_id', $this->token->event_id());
            $statement->bindValue(':process_id', $this->token->process_id());
            
            // execute the insert statement
            $statement->execute();

            $data = $statement->fetchAll();
            
            $data = $data[0]['asset_id'];

            return $data;

        }

        //
        public function selectAssets($request) {

            //echo json_encode($request); exit;

            //$token = new \Core\Token($this->pdo);
            $token = $this->token->validatedToken($request['token']);

            // Retrieve data ONLY if token  
            if($token) {
                
                // domain, app always present
                if(!isset($request['per'])){$request['per']=20;}
                if(!isset($request['page'])){$request['page']=1;}
                if(!isset($request['limit'])){$request['limit']=100;}

                //
                $conditions = "";
                $domain = $request['domain'];
                $prefix = prefixed($domain);

                //
                $columns = "

                asset_ID,		
                asset_attributes,		
                asset_type,		
                asset_status,		
                asset_primary,		
                asset_object,		
                asset_caption,		
                asset_filename,		
                asset_metadata,		
                profile_ID

                ";

                $table = $domain;

                //
                $start = 0;

                //
                if(isset($request['page'])) {

                    //
                    $start = ($request['page'] - 1) * $request['per'];
                
                }

                //
                if(!empty($request['id'])) {

                    $conditions.= " WHERE";
                    $conditions.= " " . $prefix . "_id = :id ";
                    $conditions.= " AND active = 1 ";
                    $conditions.= " ORDER BY time_finished DESC ";
                    
                    $subset = " LIMIT 1";

                    $sql = "SELECT ";
                    $sql.= $columns;
                    $sql.= " FROM " . $table;
                    $sql.= $conditions;
                    $sql.= $subset;
                    
                    //echo json_encode($request['id']);
                    //echo '<br/>';
                    //echo $sql; exit;

                    //
                    $statement = $this->pdo->prepare($sql);

                    // bind value to the :id parameter
                    $statement->bindValue(':id', $request['id']);

                    //echo $sql; exit;

                } else {

                    $conditions = "";
                    $refinements = "";

                    // SKIP ID		
                    if(isset($request['attributes'])){$refinements.="asset_attributes"." ILIKE "."'%".$request['attributes']."%' AND ";}		
                    if(isset($request['type'])){$refinements.="asset_type"." ILIKE "."'%".$request['type']."%' AND ";}		
                    if(isset($request['status'])){$refinements.="asset_status"." ILIKE "."'%".$request['status']."%' AND ";}		
                    if(isset($request['primary'])){$refinements.="asset_primary"." ILIKE "."'%".$request['primary']."%' AND ";}		
                    if(isset($request['object'])){$refinements.="asset_object"." ILIKE "."'%".$request['object']."%' AND ";}		
                    if(isset($request['caption'])){$refinements.="asset_caption"." ILIKE "."'%".$request['caption']."%' AND ";}		
                    if(isset($request['filename'])){$refinements.="asset_filename"." ILIKE "."'%".$request['filename']."%' AND ";}		
                    if(isset($request['metadata'])){$refinements.="asset_metadata"." ILIKE "."'%".$request['metadata']."%' AND ";}		
                    if(isset($request['profile'])){$refinements.="profile_id"." = "."'".$request['profile']."' AND ";}		

                    //echo $conditions . 'conditions1<br/>';
                    //echo $refinements . 'refinements1<br/>';
                    
                    $conditions.= " WHERE ";
                    $conditions.= $refinements;
                    $conditions.= " active = 1 ";
                    $conditions.= ' AND app_id = \'' . $request['app'] . '\' ';
                    $conditions.= " ORDER BY time_finished DESC ";
                    $subset = " OFFSET {$start}" . " LIMIT {$request['per']}";
                    $sql = "SELECT ";
                    $sql.= $columns;
                    $sql.= "FROM " . $table;
                    $sql.= $conditions;
                    $sql.= $subset;

                    //echo $conditions . 'conditions2<br/>';
                    //echo $refinements . 'refinements2<br/>';

                    //echo $sql; exit;
                    
                    //
                    $statement = $this->pdo->prepare($sql);

                }
                    
                // execute the statement
                $statement->execute();

                //
                $results = [];
                $total = $statement->rowCount();
                $pages = ceil($total/$request['per']); //
                //$current = 1; // current page
                //$limit = $result['limit'];
                //$max = $result['max'];

                //
                if($statement->rowCount() > 0) {

                    //
                    $data = array();
                
                    //
                    while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
        
                        //
                        $data[] = [

                            'id' => $row['asset_id'],		
                            'attributes' => json_decode($row['asset_attributes']),		
                            'type' => $row['asset_type'],		
                            'status' => $row['asset_status'],		
                            'primary' => $row['asset_primary'],		
                            'object' => $row['asset_object'],		
                            'caption' => $row['asset_caption'],		
                            'filename' => $row['asset_filename'],		
                            'metadata' => json_decode($row['asset_metadata']),
                            'profile_id' => $row['profile_id']

                        ];

                    }

                    $code = 200;
                    $message = "OK";

                } else {

                    //
                    $data = NULL;
                    $code = 204;
                    $message = "No Content";

                }

            } else {

                //
                $data[] = NULL;
                $code = 401;
                $message = "Forbidden - Valid token required";

            }

            $results = array(

                'status' => $code,
                'message' => $message,
                'metadata' => [
                    'page' => $request['page'],
                    'pages' => $pages,
                    'total' => $total
                ],
                'data' => $data,
                'log' => [
                    'process' => $process_id = $this->token->process_id(),
                    'event' => $event_id = $this->token->event_id($process_id)
                ]

            );

            //
            return $results;

        }

        //
        public function updateAsset($request) {

            //
            $domain = $request['domain'];
            $table = prefixed($domain);
            $id = $request['id'];

            //
            $set = "";

            // UPDATE OBJECT - SET
            // SKIP as ID won't be getting UPDATED		
            if(isset($request['attributes'])){$set.= " asset_attributes = :asset_attributes ";}		
            if(isset($request['type'])){$set.= " asset_type = :asset_type ";}		
            if(isset($request['status'])){$set.= " asset_status = :asset_status ";}		
            if(isset($request['primary'])){$set.= " asset_primary = :asset_primary ";}		
            if(isset($request['object'])){$set.= " asset_object = :asset_object ";}		
            if(isset($request['caption'])){$set.= " asset_caption = :asset_caption ";}		
            if(isset($request['filename'])){$set.= " asset_filename = :asset_filename ";}		
            if(isset($request['metadata'])){$set.= " asset_metadata = :asset_metadata ";}		

            //
            $set = str_replace('  ',',',$set);

            // GET table name
            $condition = $table."_id = :id";
            $condition.= " RETURNING " . $table . "_id";

            // sql statement to update a row in the stock table
            $sql = "UPDATE {$domain} SET ";
            $sql.= $set;
            $sql.= " WHERE ";
            $sql.= $condition;

            //echo $sql; exit;

            $statement = $this->pdo->prepare($sql);
    
            //if(isset($request['id'])){$statement->bindValue(':asset_id', $request['id']);}		
            if(isset($request['attributes'])){$statement->bindValue(':asset_attributes', $request['attributes']);}		
            if(isset($request['type'])){$statement->bindValue(':asset_type', $request['type']);}		
            if(isset($request['status'])){$statement->bindValue(':asset_status', $request['status']);}		
            if(isset($request['primary'])){$statement->bindValue(':asset_primary', $request['primary']);}		
            if(isset($request['object'])){$statement->bindValue(':asset_object', $request['object']);}		
            if(isset($request['caption'])){$statement->bindValue(':asset_caption', $request['caption']);}		
            if(isset($request['filename'])){$statement->bindValue(':asset_filename', $request['filename']);}		
            if(isset($request['metadata'])){$statement->bindValue(':asset_metadata', $request['metadata']);}		

            $statement->bindValue(':id', $id);

            // update data in the database
            $statement->execute();

            $data = $statement->fetchAll();
            
            $data = $data[0]['asset_id'];

            // return generated id
            return $data;

            // return the number of row affected
            //return $statement->rowCount();

        }

        //
        public function deleteAsset($request) {

            $id = $request['id'];
            $domain = $request['domain'];
            $column = prefixed($domain) . '_id';
            $sql = 'DELETE FROM ' . $domain . ' WHERE '.$column.' = :id';
            //echo $id; //exit
            //echo $column; //exit;
            //echo $domain; //exit;
            //echo $sql; //exit

            $statement = $this->pdo->prepare($sql);
            //$statement->bindParam(':column', $column);
            $statement->bindValue(':id', $id);
            $statement->execute();
            return $statement->rowCount();

        }

    }

    //
    class Image {

        //
        private $pdo;
    
        //
        public function __construct($pdo) {

            //
            $this->pdo = $pdo;

            //
            $this->token = new \Media\Token($this->pdo);

        }

        //
        public function insertImage($request) {

            //generate ID
            if(!isset($request['id'])){$request['id'] = $this->token->new_id('img');}

            $columns = "";

            // INSERT OBJECT - COLUMNS
            if(isset($request['id'])){$columns.="image_id,";}		
            if(isset($request['attributes'])){$columns.="image_attributes,";}		
            if(isset($request['type'])){$columns.="image_type,";}		
            if(isset($request['status'])){$columns.="image_status,";}		
            if(isset($request['primary'])){$columns.="image_primary,";}		
            if(isset($request['object'])){$columns.="image_object,";}		
            if(isset($request['caption'])){$columns.="image_caption,";}		
            if(isset($request['filename'])){$columns.="image_filename,";}		
            if(isset($request['metadata'])){$columns.="image_metadata,";}
            if(isset($request['profile'])){$columns.="profile_id,";}		

            $columns.= "app_id,";
            $columns.= "event_id,";
            $columns.= "process_id";

            $values = "";

            // INSERT OBJECT - VALUES
            if(isset($request['id'])){$values.=":image_id,";}		
            if(isset($request['attributes'])){$values.=":image_attributes,";}		
            if(isset($request['type'])){$values.=":image_type,";}		
            if(isset($request['status'])){$values.=":image_status,";}		
            if(isset($request['primary'])){$values.=":image_primary,";}		
            if(isset($request['object'])){$values.=":image_object,";}		
            if(isset($request['caption'])){$values.=":image_caption,";}		
            if(isset($request['filename'])){$values.=":image_filename,";}		
            if(isset($request['metadata'])){$values.=":image_metadata,";}	
            if(isset($request['profile'])){$values.=":profile_id,";}

            $values.= ":app_id,";
            $values.= ":event_id,";
            $values.= ":process_id";

            // prepare statement for insert
            $sql = "INSERT INTO {$request['domain']} (";
            $sql.= $columns;
            $sql.= ") VALUES (";
            $sql.= $values;
            $sql.= ")";
            $sql.= " RETURNING " . prefixed($request['domain']) . "_id";
    
            //
            $statement = $this->pdo->prepare($sql);
            
            // INSERT OBJECT - BIND VALUES
            if(isset($request['id'])){$statement->bindValue('image_id',$request['id']);}		
            if(isset($request['attributes'])){$statement->bindValue('image_attributes',$request['attributes']);}		
            if(isset($request['type'])){$statement->bindValue('image_type',$request['type']);}		
            if(isset($request['status'])){$statement->bindValue('image_status',$request['status']);}		
            if(isset($request['primary'])){$statement->bindValue('image_primary',$request['primary']);}		
            if(isset($request['object'])){$statement->bindValue('image_object',$request['object']);}		
            if(isset($request['caption'])){$statement->bindValue('image_caption',$request['caption']);}		
            if(isset($request['filename'])){$statement->bindValue('image_filename',$request['filename']);}		
            if(isset($request['metadata'])){$statement->bindValue('image_metadata',$request['metadata']);}
            if(isset($request['profile'])){$statement->bindValue('profile_id',$request['profile']);}

            $statement->bindValue(':app_id', $request['app']);
            $statement->bindValue(':event_id', $this->token->event_id());
            $statement->bindValue(':process_id', $this->token->process_id());
            
            // execute the insert statement
            $statement->execute();

            $data = $statement->fetchAll();
            
            $data = $data[0]['image_id'];

            return $data;

        }

        //
        public function selectImages($request) {

            //echo json_encode($request); exit;

            //$token = new \Core\Token($this->pdo);
            $token = $this->token->validatedToken($request['token']);

            // Retrieve data ONLY if token  
            if($token) {
                
                // domain, app always present
                if(!isset($request['per'])){$request['per']=20;}
                if(!isset($request['page'])){$request['page']=1;}
                if(!isset($request['limit'])){$request['limit']=100;}

                //
                $conditions = "";
                $domain = $request['domain'];
                $prefix = prefixed($domain);

                //
                $columns = "

                image_ID,		
                image_attributes,		
                image_type,		
                image_status,		
                image_primary,		
                image_object,		
                image_caption,		
                image_filename,		
                image_metadata,		
                profile_ID

                ";

                $table = $domain;

                //
                $start = 0;

                //
                if(isset($request['page'])) {

                    //
                    $start = ($request['page'] - 1) * $request['per'];
                
                }

                //
                if(!empty($request['id'])) {

                    $conditions.= " WHERE";
                    $conditions.= " " . $prefix . "_id = :id ";
                    $conditions.= " AND active = 1 ";
                    $conditions.= " ORDER BY time_finished DESC ";
                    
                    $subset = " LIMIT 1";

                    $sql = "SELECT ";
                    $sql.= $columns;
                    $sql.= " FROM " . $table;
                    $sql.= $conditions;
                    $sql.= $subset;
                    
                    //echo json_encode($request['id']);
                    //echo '<br/>';
                    //echo $sql; exit;

                    //
                    $statement = $this->pdo->prepare($sql);

                    // bind value to the :id parameter
                    $statement->bindValue(':id', $request['id']);

                    //echo $sql; exit;

                } else {

                    $conditions = "";
                    $refinements = "";

                    // SKIP ID		
                    if(isset($request['attributes'])){$refinements.="image_attributes"." ILIKE "."'%".$request['attributes']."%' AND ";}		
                    if(isset($request['type'])){$refinements.="image_type"." ILIKE "."'%".$request['type']."%' AND ";}		
                    if(isset($request['status'])){$refinements.="image_status"." ILIKE "."'%".$request['status']."%' AND ";}		
                    if(isset($request['primary'])){$refinements.="image_primary"." ILIKE "."'%".$request['primary']."%' AND ";}		
                    if(isset($request['object'])){$refinements.="image_object"." ILIKE "."'%".$request['object']."%' AND ";}		
                    if(isset($request['caption'])){$refinements.="image_caption"." ILIKE "."'%".$request['caption']."%' AND ";}		
                    if(isset($request['filename'])){$refinements.="image_filename"." ILIKE "."'%".$request['filename']."%' AND ";}		
                    if(isset($request['metadata'])){$refinements.="image_metadata"." ILIKE "."'%".$request['metadata']."%' AND ";}		
                    if(isset($request['profile'])){$refinements.="profile_id"." = "."'".$request['profile']."' AND ";}		

                    //echo $conditions . 'conditions1<br/>';
                    //echo $refinements . 'refinements1<br/>';
                    
                    $conditions.= " WHERE ";
                    $conditions.= $refinements;
                    $conditions.= " active = 1 ";
                    $conditions.= ' AND app_id = \'' . $request['app'] . '\' ';
                    $conditions.= " ORDER BY time_finished DESC ";
                    $subset = " OFFSET {$start}" . " LIMIT {$request['per']}";
                    $sql = "SELECT ";
                    $sql.= $columns;
                    $sql.= "FROM " . $table;
                    $sql.= $conditions;
                    $sql.= $subset;

                    //echo $conditions . 'conditions2<br/>';
                    //echo $refinements . 'refinements2<br/>';

                    //echo $sql; exit;
                    
                    //
                    $statement = $this->pdo->prepare($sql);

                }
                    
                // execute the statement
                $statement->execute();

                //
                $results = [];
                $total = $statement->rowCount();
                $pages = ceil($total/$request['per']); //
                //$current = 1; // current page
                //$limit = $result['limit'];
                //$max = $result['max'];

                //
                if($statement->rowCount() > 0) {

                    //
                    $data = array();
                
                    //
                    while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
        
                        //
                        $data[] = [

                            'id' => $row['image_id'],		
                            'attributes' => json_decode($row['image_attributes']),		
                            'type' => $row['image_type'],		
                            'status' => $row['image_status'],		
                            'primary' => $row['image_primary'],		
                            'object' => $row['image_object'],		
                            'caption' => $row['image_caption'],		
                            'filename' => $row['image_filename'],		
                            'metadata' => json_decode($row['image_metadata']),
                            'profile' => $row['profile_id']

                        ];

                    }

                    $code = 200;
                    $message = "OK";

                } else {

                    //
                    $data = NULL;
                    $code = 204;
                    $message = "No Content";

                }

            } else {

                //
                $data[] = NULL;
                $code = 401;
                $message = "Forbidden - Valid token required";

            }

            $results = array(

                'status' => $code,
                'message' => $message,
                'metadata' => [
                    'page' => $request['page'],
                    'pages' => $pages,
                    'total' => $total
                ],
                'data' => $data,
                'log' => [
                    'process' => $process_id = $this->token->process_id(),
                    'event' => $event_id = $this->token->event_id($process_id)
                ]

            );

            //
            return $results;

        }

        //
        public function updateImage($request) {

            //
            $domain = $request['domain'];
            $table = prefixed($domain);
            $id = $request['id'];

            //
            $set = "";

            // UPDATE OBJECT - SET
            // SKIP as ID won't be getting UPDATED		
            if(isset($request['attributes'])){$set.= " image_attributes = :image_attributes ";}		
            if(isset($request['type'])){$set.= " image_type = :image_type ";}		
            if(isset($request['status'])){$set.= " image_status = :image_status ";}		
            if(isset($request['primary'])){$set.= " image_primary = :image_primary ";}		
            if(isset($request['object'])){$set.= " image_object = :image_object ";}		
            if(isset($request['caption'])){$set.= " image_caption = :image_caption ";}		
            if(isset($request['filename'])){$set.= " image_filename = :image_filename ";}		
            if(isset($request['metadata'])){$set.= " image_metadata = :image_metadata ";}		

            //
            $set = str_replace('  ',',',$set);

            // GET table name
            $condition = $table."_id = :id";
            $condition.= " RETURNING " . $table . "_id";

            // sql statement to update a row in the stock table
            $sql = "UPDATE {$domain} SET ";
            $sql.= $set;
            $sql.= " WHERE ";
            $sql.= $condition;

            //echo $sql; exit;

            $statement = $this->pdo->prepare($sql);
    
            //if(isset($request['id'])){$statement->bindValue(':image_id', $request['id']);}		
            if(isset($request['attributes'])){$statement->bindValue(':image_attributes', $request['attributes']);}		
            if(isset($request['type'])){$statement->bindValue(':image_type', $request['type']);}		
            if(isset($request['status'])){$statement->bindValue(':image_status', $request['status']);}		
            if(isset($request['primary'])){$statement->bindValue(':image_primary', $request['primary']);}		
            if(isset($request['object'])){$statement->bindValue(':image_object', $request['object']);}		
            if(isset($request['caption'])){$statement->bindValue(':image_caption', $request['caption']);}		
            if(isset($request['filename'])){$statement->bindValue(':image_filename', $request['filename']);}		
            if(isset($request['metadata'])){$statement->bindValue(':image_metadata', $request['metadata']);}		

            $statement->bindValue(':id', $id);

            // update data in the database
            $statement->execute();

            $data = $statement->fetchAll();
            
            $data = $data[0]['image_id'];

            // return generated id
            return $data;

            // return the number of row affected
            //return $statement->rowCount();

        }

        //
        public function deleteImage($request) {

            $id = $request['id'];
            $domain = $request['domain'];
            $column = prefixed($domain) . '_id';
            $sql = 'DELETE FROM ' . $domain . ' WHERE '.$column.' = :id';
            //echo $id; //exit
            //echo $column; //exit;
            //echo $domain; //exit;
            //echo $sql; //exit

            $statement = $this->pdo->prepare($sql);
            //$statement->bindParam(':column', $column);
            $statement->bindValue(':id', $id);
            $statement->execute();
            return $statement->rowCount();

        }

    }
    
?>