//@fun: check class
function Check(){}
Check.prototype.checkUser = function(user){
  var _exp = /^[a-zA-Z0-9]+$/;
  return _exp.test(user);
};

//@fun: base class
function Base(){
  this.fillError = 'fill error!';
  this.userError = 'ths user message does not exists!';
}
//@fun: set error meg
Base.prototype.setError = function(){
  var _err = $('#l_err');
  _err.show();
};
Base.prototype.getUser = function(){
  return $.trim($('#l_user').val());
};
Base.prototype.getPwd = function(){
  return $.trim($('#l_pwd').val());
};
Base.prototype.validateData = function(result){
    if(parseInt(result) === 1)
        window.location.href = '?/register';
    else{
        var base = new Base();
        base.setError();
    }
};

$('#l_sub').click(function(){
  var _check = new Check(),
    _base = new Base();
  var _user = _base.getUser(),
    _pwd = _base.getPwd();
  if(_check.checkUser(_user)!==true){
    _base.setError();
  }else{
      var _param = 'user='+_user+'&pwd='+_pwd;
    $.post('?','/aj/login/check/'+_param, _base.validateData);
  }
});

//@fun: load
window.onload = function(){
    $('#l_err').hide();
};
