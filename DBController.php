<?php
class DBController {
    private $pdo;
    function __construct() {
       $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=db_auth',
        'fred', 'zap');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}


     function RunBaseQueryPDO($query) {//modified to PDO
        $stmt = $this->pdo->query($query);
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      $resultset[] = $row;
    }
    if(!empty($resultset))
                return $resultset;
    } 

    function RunQueryPDO($query, $param_type, $param_value_array){//modified to PDO
        $sql = $this->pdo->prepare($query);
        $this->BindQueryParamsPDO($sql,$param_type,$param_value_array);
        $sql->execute();

        while ( $row = $sql->fetch(PDO::FETCH_ASSOC) ) {
            $resultset[] = $row;
          }
          if(!empty($resultset)){
                      return $resultset;
          }
    }
  
    function BindQueryParamsPDO($sql, $param_type, $param_value_array){//modified to PDO
        for($i=0; $i<count($param_value_array); $i++) {
            $type_reference = & $param_type[$i];
            $value_reference = & $param_value_array[$i];
            $sql->bindParam($i+1,$value_reference,$type_reference);
        }
    }
    
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->pdo->prepare($query);
        $this->BindQueryParamsPDO($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->pdo->prepare($query);
        $this->BindQueryParamsPDO($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}
?>
