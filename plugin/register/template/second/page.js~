function SystemInfo(){//@class: system information
  var group = [];
  this.getGroup = function(){
    return group;
  };
  this.setGroup = function(groupInfo){
    group.push(groupInfo);
  };
}
SystemInfo.prototype.getGroupByName = function(groupName){
  var groupArr = this.getGroup(),
      result = '';
  for(var i in groupArr)
    if(groupArr[i].name == groupName)
      result = groupArr[i];
  return result;
};

function Group(name){//@class: group information
  this.name = name;
  var skillArr = [];
  this.getSkillArr = function(){
    return skillArr;
  };
  this.setSkillArr = function(skillInfo ,flag){
    if(!flag)
      skillArr.push(skillInfo);
    else
      skillArr = skillInfo;
  };
}
Group.prototype.getSkill = function(skillValue){
  var skill = this.getSkillArr(),
      result = '';
  for(var i in skill)
    if(skill[i].name == skillValue)
      result = skill[i];
  return result;
};
function Skill(name, degree){//@class: skill 
  this.name = name;
  this.degree = degree;
  this.setDegree = function(degree){
    this.degree = degree;
  };
}
/*******************************************/
function Event(){}
Event.prototype.initSlide = function(){
  var _slides= $('div._detail_slide');
  for(var i = 0, length = _slides.length; i<length; i++){
    this.slideInfo(_slides[i]);
  }
  if(displayInfo.groupName == 'add'){
    var _add = $('input.input_add');
    _add.click(this.addClick);
    _add.blur(this.addBlus);
  }
};
Event.prototype.addBlus = function(obj){
  var _obj = $(obj.target);
  if($.trim(_obj.val()) == '')
    _obj.val('add');
  else{
    var _model = new DrawModel();
    _obj.parent().parent().parent().append(_model.initPage('add',{name:'add',degree:0}));
    var _event = new Event();
    _event.initSlide();
  }
};
Event.prototype.addClick = function(obj){
  if(obj.target.value == 'add')
    obj.target.value = '';
};
Event.prototype.slideInfo = function(slide){
  var _slide = $(slide).slider(),
      _number = _slide.parent().next().children();
  _slide.slider('value',_number.val());
  _slide.on("slide",function(event, ui){
    _number.val(ui.value);
  });
};
Event.prototype.postInputInfo = function(result){
  if(parseInt(result) == 1)
    window.location.href = '?/register/pageDetail/';
}

/************************************************/
function DrawModel(){

}
DrawModel.prototype.initPage = function(groupName, skill){
  var _label = this.drawLabel(groupName,skill),_slide = this.drawSlide(skill),_number = this.drawNumber(skill),_result = '';
  _result += '<tr>'+_label+_slide+_number+'</tr>';
  return _result;
};
DrawModel.prototype.drawLabel = function(groupName, skill){
  var _result = '', _label = '';
  if(groupName == 'add')
    _label = '<input type="text" style="width:65px;" value="'+skill.name+'" class="input_add" />';
  else 
    _label = '<label>'+skill.name+'</label>';
  _result = '<td>'+_label+'</td>';
  return _result;
  
};
DrawModel.prototype.drawNumber = function(skill){
  var _result = '',
      _input = '<input type="text" class="_detail_number" value="'+skill.degree+'"/>';
  _result = '<td>'+_input+'</td>';
  return _result;
};
DrawModel.prototype.drawSlide = function(skill){
  var _result = '',
      _slide = '<div class="_detail_slide"></div>';
  _result = '<td style="width:240px;height:30px;">'+_slide+'</td>';
  return _result;
};
DrawModel.prototype.drawAddPage = function(){
  
};
DrawModel.prototype.integratePage = function(info){
  var _result = '<table>'+info+'</table>';
  return _result;
};
DrawModel.prototype.drawCircle = function(skill){
  var _result = '',
      _canvas = '<span class="_circle_canvas"></span>';
  _result = '<span class="_view_circle">'+_canvas+'</span>';
  $('div#r_view').append(_result);
}

function DisplayInfo(groupName){//@class: display class
  this.groupArr = [];
  this.initGroupInfo();
  this.groupName = groupName;//edit group
  //this.initGroupInfo();
}
DisplayInfo.prototype.initGroupInfo = function(){
  for(var i=0,length = system.groupArr.length; i<length; i++){
    var _group = {};
    _group.name = system.groupArr[i];
    _group.info = this.initGroupDetailInfo(_group.name);
    this.groupArr.push(_group);
  }
};
DisplayInfo.prototype.initGroupDetailInfo = function(groupName){
  var  _model = new DrawModel(), _result = '';
  var _skillArr = system.systemInfo.getGroupByName(groupName).getSkillArr();
  console.log(_skillArr);
  for(var i=0,length=_skillArr.length; i<length; i++)
    _result += _model.initPage(groupName,_skillArr[i]);
  return _model.integratePage(_result);
};
DisplayInfo.prototype.displayGroup = function(group){
  var _group = this.getGroupByName(group),
      _event = new Event();
  //console.log(_group);
  $('#center_list').html(_group.info);
  _event.initSlide();
};
DisplayInfo.prototype.getGroupByName = function(groupName){
  for(var i in this.groupArr)
    if(this.groupArr[i].name == groupName)
      return this.groupArr[i];
  return {};
};
DisplayInfo.prototype.saveEditGroup = function(){
  this.getGroupByName(this.groupName).info = $('#center_list');
};
DisplayInfo.prototype.updateGroupInfo = function(){
  this.getGroupByName(this.groupName).info = this.initGroupDetailInfo(this.groupName);
};


/***************************************************/
var displayInfo;
var system = {};
system.groupArr = ['web','design','it','alg','android','add'];
system.skillWebArr = ['HTML','Javascript','PHP'];
system.skillDesignArr = ['Photoshop','After'];
system.skillITArr = ['C','Python'];
system.skillALGArr = ['C','CPlusPlus'];
system.skillAndroidArr = ['Java','C#'];
system.skillAddArr = ['add'];
system.skillArr = [system.skillWebArr,system.skillDesignArr, system.skillITArr, system.skillALGArr, system.skillAndroidArr, system.skillAddArr];
system.initSystemInfo = function(){
  system.systemInfo = new SystemInfo();
};
system.initSystemGroup = function(){
  var group;
  for(var i in system.groupArr){
    group = new Group(system.groupArr[i]);
    system.systemInfo.setGroup(group);
    system.initSystemSkill(group, i);
  }
};
system.initSystemSkill = function(group, name){
  var result = '',
      skillValue = system.skillArr[name];
  for(var i in skillValue)
    group.setSkillArr(new Skill(skillValue[i], 0));
};
system.initSystem = function(){
  system.initSystemInfo();
  system.initSystemGroup();
};
system.changeGroupInfo = function(groupName){
  if(groupName == 'add'){
    this.changeAddGroupInfo();
    return;
  }
  var _skills = system.systemInfo.getGroupByName(groupName).getSkillArr(),
      _numberArr = $('input._detail_number');
  for(var i =0,length = _numberArr.length; i<length; i++)
    _skills[i].degree = _numberArr[i].value;
};
system.changeAddGroupInfo = function(){
  var _labelArr = $('input.input_add'),_numberArr = $('input._detail_number'),_result=[];
  var _skills = system.systemInfo.getGroupByName('add').getSkillArr();
  for(var i=0,length=_numberArr.length; i<length; i++){
    _labelArr[i].value = $.trim(_labelArr[i].value);
    _numberArr[i].value = $.trim(_numberArr[i].value);
    if(_labelArr[i].value == '' || _labelArr[i].value == 'add' || !_numberArr[i].value)
      continue;
    else
      _result.push(new Skill(_labelArr[i].value, _numberArr[i].value));
  }
  system.systemInfo.getGroupByName('add').setSkillArr(_result, true);
};
system.ajSystemInfo = function(){//ajax get system information
  $.post('?/aj/register/g_sessinfo/','', this.ajSystemInfoInte);
};
system.ajSystemInfoInte = function(result){
  var _result = eval(result);
  console.log(_result);
  if(!_result.length)
    return;
  var _group = system.systemInfo.getGroup(),_skills = [],_addArr=[], flag = false;
  for(var k =0,k_length = _result.length;k<k_length; k++){
    flag = false;
    for(var i = 0, i_length = _group.length; i<i_length ;i++){
      _skills = system.systemInfo.getGroupByName(_group[i].name).getSkillArr();
      for(var j = 0, j_length = _skills.length; j<j_length; j++){
        if(_result[k].name == _skills[j].name){
          _skills[j].setDegree(_result[k].degree);
          flag = true;
        }
      }
    }
    if(!flag)
      _addArr.push(new Skill(_result[k].name, _result[k].degree));
  }
  _addArr.push(new Skill('add', 0));
  system.systemInfo.getGroupByName('add').setSkillArr(_addArr, true);
  window.init();
};

/******************************************************/
$('div#nav_top button').click(function(){
  var _groupName = $(this).attr('name').toLowerCase();
  if(_groupName == displayInfo.groupName)
    return;
  system.changeGroupInfo(displayInfo.groupName);
  displayInfo.updateGroupInfo();
  displayInfo.groupName = _groupName;
  displayInfo.displayGroup(displayInfo.groupName);
});

$('#r_next').click(function(){
  system.changeGroupInfo(displayInfo.groupName);
  displayInfo.updateGroupInfo();
  var _skills = [], _result = '',_event = new Event();
  for(var i=0, _tempGroup=system.systemInfo.getGroup(), i_length=_tempGroup.length; i<i_length; i++){
    _skills = system.systemInfo.getGroupByName(_tempGroup[i].name).getSkillArr();
    for(var j=0, j_length = _skills.length; j < j_length; j++)
      if(parseInt(_skills[j].degree))
        _result += '_'+_skills[j].name + '_' + _skills[j].degree;
  }
  //console.log(_result);
  $.post('?/aj/register/p_info/&info='+_result.substring(1),'',_event.postInputInfo);
});
$('#r_pre').click(function(){
  window.location.href='?/register/';
});
/*****************************************************/
window.onload = function(){
  system.initSystem();
  system.ajSystemInfo();
  //var draw = new DrawModel();
  //draw.drawCircle({name:'design'});
};
function init(){
  displayInfo = new DisplayInfo('design');
  displayInfo.displayGroup('design');
}
