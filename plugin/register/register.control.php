<?php

if(!defined('IS_ACTIVE')) die(C_Meg_Access);

/*
 * login control class
 */

class Control_Register extends Control{


  //@fun: get user information
  public function getUserInfo(){
    $_id = $GLOBALS['FW']['User']['Main']['Id'];
    $_result = array();
    if($_id == C_Each_Visitors_Id)
      return $_result;
    if(!empty($GLOBALS['FW']['Session']['Main']['Page1']))
      $_result = $GLOBALS['FW']['Session']['Main']['Page1'];
    else{
      $_result = $this->_get_user_info($_id);
      if($_result === false)
        $_result = array();
    }
    return json_encode($_result);
  }

  //@fun: get user information
  private function _get_user_info($_id){
    $_db =  new Db();
    $_db->setDatabase('login');
    $_con = "`id`='".$_id."'";
    $_selectArr = array(
      'username','email',
    );
    $_result = $_db->select('Auth_member', $_selectArr, $_con);
    if($_result !== false){
      $_sess = Session::getInstance();
      $_sess->set('Page1', array('Name'=>$_result['username'],'Email'=>$_result['email']));
    }
    return $_result;
  }

  //@fun: validate the first page
  public function validateFirst($phone, $blog){
    $_id = $GLOBALS['FW']['User']['Main']['Id'];
    if($_id == C_Each_Visitors_Id)
      return 0;
    $_session = $GLOBALS['FW']['Session']['Main'];
    $phone = trim($phone);
    $blog = trim($blog);
    if(!$this->_check_user($phone, $blog))
      return 0;
    elseif(empty($_session['Name']) || empty($_session['Email'])){
      $_result = $this->_get_user_info($_id);
      if($_result === false)
        return 0;
    }
    $_sess = Session::getInstance();
    $_sessArr = array_merge($_session['Page1'], array('Phone'=>$phone,'Blog'=>$blog));
    $_sess->set('Page1', $_sessArr);
    return 1;
  }

  //@fun: check phone and blog
  private function _check_user($phone, $blog){
    if(!strlen($phone) || !strlen($blog))
      return false;
    $_exp = '{^13[0-9]{9}$}';
    if(!preg_match($_exp, $phone))
      return false;
    else
      return true;
  }

  /*************************************************/
  /********************************************/

  //@fun: get skills
  public function getSkillInfo($skill){
    $skill = strtolower($skill);
    $_arr = array('design','web','it','alg','android');
    if(!in_array($skill, $_arr))
      return 0;
    $_db = new Db();
    $_db->setDatabase('main');
    $_result = $_db->select('Skill_'.$skill,array('skill','checked'));
    if($_result === false)
      return 0;
    $_final_one = array();
    $_final_two = array();
    foreach($_result as $_value){
      if($_value['checked'] == 1)
        $_final_one[] = $_value;
      else
        $_final_two[] = $_value;
    }
    return json_encode(array_merge($_final_one, $_final_two, array(array('model'=>$skill))));
  }

  //@fun: get group information from Session
  public function getSessionUserInfo(){
    $_result = array();
    if(!empty($GLOBALS['FW']['Session']['Main']['Page2']['Page']))
      $_result = $GLOBALS['FW']['Session']['Main']['Page2']['Page'];
    return json_encode($_result);
  }

  //@fun: integrate  input information
  public function integratInputInfo($content){
    $_tempResult = explode('_',$content);
    $_result = array();
    for($i=0,$length = count($_tempResult); $i<$length; $i++){
      if($i % 2 == 0){
        $_temp=array('name'=>$_tempResult[$i],'degree'=>$_tempResult[++$i]);
        $_result[] = $_temp;
      }
    }
    $_sess = Session::getInstance();
    $_sess->set('Page2', array('Page'=>$_result));
    return 1;
  }

}

?>
