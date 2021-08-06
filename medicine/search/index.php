
<html >
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">


<script src="../js/jquery.min.js" ></script>
<script src="../js/index.js" ></script>

<link href="bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }


      .height {
    height: 20vh
}

.search {
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1)
}

.search input {
    height: 60px;
    text-indent: 25px;
    border: 2px solid #d6d4d4
}

.search input:focus {
    box-shadow: none;
    border: 2px solid blue
}

.search .fa-search {
    position: absolute;
    top: 20px;
    left: 16px
}

.search button {
    position: absolute;
    top: 5px;
    right: 5px;
    height: 50px;
    width: 110px;
    background: blue
}
    </style>

    
    <!-- Custom styles for this template -->
    <link href="list-groups.css" rel="stylesheet">
  </head>
  <body>





<div class="b-example-divider"></div>

    <div class="container">
      <div class="row height d-flex justify-content-center align-items-center">
          <div class="col-md-8">
              <div class="search"> <i class="fa fa-search"></i> <input type="text" class="form-control" id="search_medicine" placeholder="Search Medicine or type relative word"> <button class="btn btn-primary">Search</button> </div>
          </div>
      </div>
  </div>

<div class="b-example-divider"></div>

<div class="list-group list-group-checkable" id="medicine_list_inn" >



</div>










<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Medical Addresses </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="address_code">






      <div class='container'><div class='row height d-flex justify-content-center align-items-center'><div class='col-md-8'><div class='search'> <i class='fa fa-search'></i> <input type='text' class='form-control' id='search_medical' placeholder='Search Medical Name or address '> <button class='btn btn-primary'>Search</button> </div></div></div></div><div class='b-example-divider'></div><div class='list-group list-group-checkable' id='medical_list_inn' ></div>






      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" >Ok</button>
      </div>
    </div>
  </div>
</div>



<script src="bootstrap.bundle.min.js"></script>
  <script>
function deep_medicine_list_callback(par){

//console.log("par is===" +par);

var parx =JSON.parse(par);



  var md_id="";
  var md_nm="";
  var md_prc="";
  var md_sci="";

var list_code= "";
for (var key_x in parx) {

  var record = parx[key_x];

  for (var key in record) {
    var value = record[key];
     // console.log(key);
      //console.log("-->"+value);

      if(key=="medicine_id"){
        md_id=value;
      }else if(key=="medicine_price"){
        md_prc=value;
      }else if(key=="medicine_name"){
        md_nm=value;
      }else if(key=="medicine_sci"){
        md_sci=value;
      }      
  }



list_code= list_code + "<div> <label data-bs-toggle='modal' data-bs-target='#exampleModal' class='list-group-item py-3 fw-bold' onclick='get_info(\""+md_id+"\")' style='color:green' for='listGroupCheckableRadios2'>"+md_nm+"<span style='float: right;color:red;'>"+md_prc+" ₹</span>   <span style='color:black;' class='d-block small opacity-50'>"+md_sci+"</span> <span class='d-block small opacity-50' style='float: right;color:blue;'>"+md_id+"</span></label><div class='b-example-divider'></div></div>";


}
  document.getElementById("medicine_list_inn").innerHTML=list_code;

}



ip("deep_medicine_list_","string",deep_medicine_list_callback);




function get_info(i){
  console.log("called id ="+i);
  ip("Deep_get_info",i,get_info_callback);

}

function get_info_callback(par2){
  //console.log("-->"+par2);

  var parxy =JSON.parse(par2);
  console.log(parxy);




 












  var medical_address="";
  var medical_contact="";
  var medical_id="";
  var medical_name="";
  var dist="";

var medical_list_code= "";
for (var key_xy in parxy) {

  var record = parxy[key_xy];

  for (var keyy in record) {
    var value = record[keyy];

      if(keyy=="medical_address"){
        medical_address=value;
      }else if(keyy=="medical_contact"){
        medical_contact=value;
      }else if(keyy=="medical_id"){
        medical_id=value;
      }else if(keyy=="medical_name"){
        medical_name=value;
      }else if(keyy=="dist"){
        dist=value;
      }        
  }



  medical_list_code= medical_list_code + "<div><label class='list-group-item py-3 fw-bold'  style='color:green' for='listGroupCheckableRadios2'>"+medical_name+"<span style='color:purple;'>"+dist+"</span> <span style='float: right;color:red;'>"+medical_contact+" </span>   <span style='color:black;' class='d-block small opacity-50'>"+medical_address+"</span> <span class='d-block small opacity-50' style='float: right;color:blue;'>"+medical_id+"</span></label><div class='b-example-divider'></div></div>";


}
  document.getElementById("medical_list_inn").innerHTML=medical_list_code;

































  //medical_list_inn


}














///////////////////////////////////////////////  for medicine

$("#search_medicine").keyup(function() {

var filter = $(this).val(),
  count = 0;

$('#medicine_list_inn div').each(function() {


  if ($(this).text().search(new RegExp(filter, "i")) < 0) {
    $(this).hide();  // MY CHANGE

  } else {
    $(this).show(); // MY CHANGE
    count++;
  }

});

});




///////////////////////////////////////////////  for medicine



$("#search_medical").keydown(function() {

  var filter = $(this).val(),
  count = 0;

$('#medical_list_inn div').each(function() {


  if ($(this).text().search(new RegExp(filter, "i")) < 0) {
    $(this).hide();  // MY CHANGE

  } else {
    $(this).show(); // MY CHANGE
    count++;
  }

});

});














var myModal = document.getElementById('myModal')
var myInput = document.getElementById('myInput')

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus()
})
  </script>
  </body>
</html>
