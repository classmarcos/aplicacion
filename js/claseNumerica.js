global_function = {
 just_number:function(object){
  var num = $(object).val();
  num = num.replace(/[^0-9]/g, '');  
  $(object).val(num);
 },
 decimal_number:function(object){
  var num=$(object).val();
  num = num.replace(/[^0-9\.]/g, '');  
  $(object).val(num);
 }
}

keyup = {
  constructor : function(){
            this.decimal_number();
            this.just_number(); 
     },
  decimal_number: function(){
   $('body').delegate('.decimal','keyup',function(e){
    start = $(this)[0].selectionStart;
    if(e.keyCode!=8  && e.keyCode!=37 && e.keyCode!=39 ){
     global_function.decimal_number(this);
     $(this)[0].selectionEnd = start;
    }
   })    
  },
  just_number:function(){
   $('body').delegate('.number,input[type=number]:not(.decimal)','keyup',function(e){
    start = $(this)[0].selectionStart;
    if(e.keyCode!=8  && e.keyCode!=37 && e.keyCode!=39 ){
     global_function.just_number(this);    
     $(this)[0].selectionEnd = start;
    }
   })
  }
}

keypress = {
        constructor:function(){
            this.decimal_number();
            this.just_number();
        },
  decimal_number:function(){
   $('body').delegate(".decimal","keypress",function(e){ 
      if ($(this).val().indexOf(".")!=-1 && e.which==46)
      return false;
      
      var charCode = (e.which) ? e.which : e.keyCode; 
      if (charCode > 31 && charCode!=46 && (charCode < 48 || charCode > 57)) { 
     return false; 
      }
   })  
  },
        just_number:function(){
            $('body').delegate('.number, input[type=number]:not(.decimal)','keypress',function(e){   
            var charCode = (e.which) ? e.which : e.keyCode; 
            if (charCode > 31 && (charCode < 48 || charCode > 57)) { 
           return false; 
            }
         })
        }  
}

paste = {
 constructor:function(){
  this.number();
  this.decimal();
 },
 number:function(){
   $('body').delegate('.number, input[type=number]:not(.decimal)','paste', function () {
    var element = this;

    setTimeout(function () {
        global_function.just_number(element);
    }, 100);
  });
 },
 decimal:function(){
   $('body').delegate('.decimal','paste', function () {
    var element = this;

    setTimeout(function () {
        global_function.decimal_number(element);
    }, 100);
  });
 }
}

setTimeout(function(){
  keyup.constructor();
  keypress.constructor();
  paste.constructor();
},100);