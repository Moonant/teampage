$(function(){

  $.ajax({
	url:"",
	type:"post",
	data:{},
	success:function(data){
	  
	}
  })



  $("input#phone").blur(function(){
	blurPhone()
  })

  $("input#yourhp").blur(function(){
	blurHp()
  })
  
  $("a#nextP").click(function(){
	if(blurPhone()&&blurHp()){
	$.ajax({
	  url:"",
	  type:"post",
	  data:{phone:"phoneNum",homepage:"homepage"},
	  success:function(data){
		
	  }
	})
	}
  })
})
	function blurPhone(){
	phoneNum = $("input#phone").val();
	var reyx=/^\d{11}$/;
	if(phoneNum.match(reyx)){
	  $("span.phoneTip").css("background","url('./yes.png')");
	  return true;
	}
	else{ 
	  $("span.phoneTip").css("background","url('./no.png')");
	  return false;
	}
  }
	function blurHp(){
	homepage = $("input#yourhp").val();
	if(homepage!=""){
	  $("span.hpTip").css("background","url('./yes.png')");
	  return true;
	}
	else{ 
	  $("span.hpTip").css("background","url('./no.png')");
	  return false;
	}
  }

function ajaxupload(){
  $('#myform2').ajaxSubmit(function(data){
	data=data.split(":");
	if(data[0]=="success"){alert('');
	  $('div.photo img').attr('src','./upload/'+data[1]);
	}
  })	  
}

