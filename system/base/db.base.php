<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Load_Error);

/*
 * db clasd
 */

class SYS_Db{

  private $db_host = '';
  private $db_user = '';
  private $db_password = '';
  private $db_charset = '';
  private $db_name = '';
  private $conn = null;
  private $db_arr = array(
    'login'=>'uniqueStudioSystem',
    'main'=>'FWPersonInfo',
  );
  private $db_err = 'database linked error!';

  public function __construct(){
    configItemInfo('db');
    $this->setDbBaseInfo();
  }

  public function getDbConnect(){
    return $this->$conn;
  }

  //
  public function isDbConnect(){
    if($this->conn == null)
      return false;
    else
      return true;
  }
  private function setDbBaseInfo(){
    $this->db_host = getConfig('db', 'DbHost');
    $this->db_user = getConfig('db', 'DbUser');
    $this->db_password = getConfig('db', 'DbPassword');
    $this->db_charset = getConfig('db', 'DbCharset');
  }
  //@fun: set database
  public function setDatabase($db = 'main'){
    if($db == 'login')
      $this->db_name = $this->db_arr['login'];
    else
      $this->db_name = $this->db_arr['main'];
    $this->initDatabase();
  }

  //@fun: linked database
  private function initDatabase(){
    $this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_password);
    mysql_select_db($this->db_name, $this->conn);
    mysql_query("set names ".$this->db_charset);
  }

  //@fun: select
    public function select($table,$key='*',$condition='',$order_array='',$limit=30){
      $result=array();
      $query='SELECT ';
      if(empty($table)){
	$result['tot']=0;
	$result['error']=true;
	return $result;
      }
      if($key=='*') $query.='* FROM ';
      else{
	if(is_array($key)){
          $query.= $this->table($table).".`$key[0]`";
          for($i=1;$i<count($key);$i++)
            $query.=', '.$this->table($table).".`$key[$i]`";
          $query.=' FROM ';
	}else
        $query.= $this->table($table).".`$key` FROM ";
      }
      $query.= $this->table($table);
      if($condition) $query.=' WHERE '.$condition;
      if($order_array){
	$order_key=array_keys($order_array);
	$order_value=array_values($order_array);
	$query.=' ORDER BY `'.$order_key[0].'` '. $order_value[0] ;
	for($i=1;$i<count($order_array);$i++)
          $query.=', `'.$order_key[$i].'` '. $order_value[$i] ;
      }
      if($limit)
        $query.=' LIMIT '.$limit;
      //var_dump($query);
      return $this->_check_result($this->query($query));
    }

  //@fun: init table
  private function table($table){
    return '`'.$this->db_name."`.`".trim($table).'`';
  }

  //@fun: check query result
  private function _check_result($result){
    if(empty($result) || isset($result['error']))
      return false;
    else{
      if($result['tot'] == 0)
        return false;
      elseif($result['tot'] == 1)
        return $result['record'][0];
      else
        return $result['record'];
    }
  }

  //@fun: query
  public function query($query,$num=99999){
    $result=array();
    $cmd=substr($query,0,6);
    @$resource_query=mysql_query($query,$this->conn);
    $result['errno']=mysql_errno($this->conn);
    if($result['errno']){
      $result['tot']=0;
      $result['error']=mysql_error($this->conn);
      //@mysql_free_result($resource_query);
      @mysql_close($this->conn);
      return $result;
    }else{
      unset($result['errno']);
      switch($cmd){
      case 'SELECT':{
        $temp=$result['tot']=mysql_num_rows($resource_query);
	while($record=mysql_fetch_assoc($resource_query)){
          $result['record'][]=$record;
          if((--$temp)==0 || (--$num)==0 )
            break;
	}
	break;
      }
      default:{
	$result['affect']=mysql_affected_rows($this->conn);
	if($cmd=='INSERT') $result['insert_id']=mysql_insert_id($this->conn);
	  break;
      }
      }
      //@mysql_free_result($resource_query);
      @mysql_close($this->conn);
      return $result;
    }
  }

  //@fun: insert
  public function insert($table, $key){
    $result=array();
    if(empty($table) || empty($key))
      return false;
    $query='INSERT INTO '.$this->table($table).' ( ';
    $keys_key=array_keys($key);
    $keys_value=array_values($key);
    $query.=' `'.$keys_key[0].'` ';
    for($i=1;$i<count($key);$i++)
      $query.=' , `'. $keys_key[$i] .'` ';
    $query.=' ) VALUES ('." '". mysql_real_escape_string($keys_value[0]) ."' ";
    for($i=1;$i<count($key);$i++)
      $query.=" , '". mysql_real_escape_string($keys_value[$i]) ."' ";
    $query.=' )';
    $temp=$this->query($query);
    if(!empty($temp) && !empty($temp['affect']) && !empty($temp['insert_id']))
      return true;
    else
      return false;
  }


}

?>
