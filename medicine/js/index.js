//alert(' i am IP ');
function ip(parName,parVal,Deep_callback){
    //alert(' i am IP '+Deep_callback);
    
        var pName=parName;
        var pVal=parVal;
    
      xmlhttp = new XMLHttpRequest();
      xmlhttp.open("POST", "../php/master.php", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send(parName+"=" + pVal);
    
      xmlhttp.onreadystatechange = function(){
          if (this.readyState == 4 && this.status == 200) {
            var responseT =this.responseText;
            
            Deep_callback(responseT);
    //console.log('I am onreadystatechange ='+responseT);
          }
        }
    
    xmlhttp.onerror = function(e){
    console.log('onerror');
        Deep_callback("0");//0 means offline INTERNET PROBLem
    };
    
    console.log('I am ending of IP....'+pVal);
    };//ip(mypar)  closed