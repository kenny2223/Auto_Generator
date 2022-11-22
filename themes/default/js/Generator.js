
$(document).ready(function(){

  $("#my").DataTable();
  
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#my tbody tr").filter(function() {

      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  $('#my tbody').on('input', '.Mac', function () {
  //$('.Mac').on('input', function() {
    validateMac($(this));
    if ($(this).val().length == 12) {
      console.log($(this).val());
      $(this).closest('tr').next().find('.Mac').focus();
    }
   
  
  });

  $('#my tbody').on('change', '#checkbox', function () {
    if ($(this).is(':checked')) {
     $(this).closest('tr').find('.ip').prop( "disabled", true );
     $(this).closest('tr').find('.ip').val("");

    }else {
      $(this).closest('tr').find('.ip').prop( "disabled", false )
      $(this).closest('tr').find('.ip').val($('#P_ip').val());
  
      
    }
  });

  
  $('#P_ip').on('input', function() { $('.ip:enabled').val($(this).val());});


  $('#P_Mac').on('input', function() {
  
    $('.Mac').val($(this).val());

  if ($('.Mac').length) validateMac($('.Mac'));
    
    var v= $(this).val().match(/\b[0-9A-F]{1,6}\b/gi);

    if ($(this).val().length ==0 || $(this).val().length == 6 && v!==null ) {
      $(this).css('border','');
    }else $(this).css("border", "2px solid red");

  });


  $('#P_admin').on('input', function() { 
    if ($(this).val().length >=8 ) {
      $(this).css('border','');
    }else $(this).css("border", "2px solid red");
  });

 

  
  $('#FTP').on('click', function() { 

     $.ajax
      ({
          type: 'POST',
          url:  'modules/Auto/ajax_peticion.php',
          data: {
           start : true
          },
          success: function(data)
          {
           location.reload();
          }
      });
  
  
    });


  $('#Brand').on('change', function() {



  var modelo=$(this).val();
    $.ajax
    ({
        type: 'POST',
        url:  'modules/Auto/ajax_peticion.php',
        data: {
          modelo:modelo
        },
        dataType : 'json',
        success: function(data)
        {
        $('#General').val(data[0]);
        $('#suffix').html(data[1]);
      
        d=data[1].split(" ");
        (d[0] > 0)  ? $('#D_file').prop( "disabled", false ) : $('#D_file').prop( "disabled", true );
        $('#S_file').val(d[1]);
        }
    });


  });

  $('#csv').on('click', function() {
    Data=[];
   $(".Mac").each(function(){
    var text = $(this).val();
    if (text !=="") {
      
      var parent = $(this).closest('tr');
      
      var name=$($(parent).find("td")[0]).find('label').text();
      var ext=$($(parent).find("td")[1]).find('label').text();
      var pass=$($(parent).find("td")[2]).find('label').text();
      var Mac=$($(parent).find("td")[3]).find('input').val();
      var Dhcp=$($(parent).find("td")[4]).find('input').is(':checked');
      if (Dhcp) {
        Dhcp ="DHCP";
        netmask="";
        gateway=""
        

      }else {
        Dhcp ="Estatico";
        netmask=$('#mask').val();
        gateway=$('#gateway').val();
      }
      
      var Ip=$($(parent).find("td")[5]).find('input').val();
      
      Data.push([name,ext,pass,Mac.toLowerCase(),Dhcp,Ip,netmask,gateway]);
    }
  

   })


   if (Data.length>0) {
    var head =JSON.stringify(["Nombre","Extension","Password","Mac Address","Conexion","IP","Mascara","Gateway"]);
    var data= JSON.stringify(Data);
    location.href = 'modules/Auto/libs/csv.php?head='+head+'&data='+data;
    
   }

  
    });


  document.getElementById("D_file").addEventListener("click", () => 
  {
    var Suffix= $('#S_file').val();
    let v = confirm("¿Quieres eliminar los Archivos?");

  if (v) {
    $.ajax
    ({
        type: 'POST',
        url:  'modules/Auto/ajax_peticion.php',
        data: {
          Suffix:Suffix,
        },
        dataType : 'json',
        success: function(data)
        {
          (data[0] > 0)  ? $('#D_file').prop( "disabled", false ) : $('#D_file').prop( "disabled", true );
          $('#suffix').html(data[0]+' '+data[1])
          
        }
    });
  }
  
});

  

    
});

function Generar(){
  error=false;
  var Brand=$('#Brand').val();
  var General=$('#General').val();
  var G={};
  G['Server']=$('#Server').val();
  G['mask']=$('#mask').val();
  G['gateway']=$('#gateway').val();
  G['P_admin']=$('#P_admin').val();


  Data=[];

  $(".Mac").each(function(){
    var text = $(this).val();
    
    if (text !=="") {
      var v= text.match(/\b[0-9A-F]{12}\b/gi);
      if(text.length != 12 || v===null) {
        error=true;
        return false;
      }
      var parent = $(this).closest('tr');
      
      var name=$($(parent).find("td")[0]).find('label').text();
      var ext=$($(parent).find("td")[1]).find('label').text();
      var pass=$($(parent).find("td")[2]).find('label').text();
      var Mac=$($(parent).find("td")[3]).find('input').val();
      var Dhcp=$($(parent).find("td")[4]).find('input').is(':checked');
      var Ip=$($(parent).find("td")[5]).find('input').val();
     
      Data.push([name,ext,pass,Mac.toLowerCase(),Dhcp,Ip]);
    }
  

   })

   if(error) {
    alert("Mac con error");
    return;
   }
   if(G['P_admin'].length ==0){
    alert("Introduzca Contraseña para administracion en la Web");
    return;
   }else if(G['P_admin'].length < 8){
    alert("El Contraseña debe contener al menos 8 Caracteres");
    return;
   }
   
if (Data.length >0) {

  $.ajax
  ({
      type: 'POST',
      url:  'modules/Auto/ajax_peticion.php',
      data: {
        Data:Data,
        General:General,
        Brand:Brand,
        G : JSON.stringify(G)
      },
     
      success: function(data)
      {
        $('.alert').html("Se ha creado "+Data.length+" Registro");
        $('.alert').css({"top":$(window).scrollTop(), "left": "30%", })
        $('.alert').show().delay(1000).fadeOut();
        $( "#Brand" ).trigger( "change" );
      
      }
  });
}


}

function validateMac(Mac){
  var v= Mac.val().match(/\b[0-9A-F]{1,12}\b/gi);

  if (Mac.val().length ==0 || Mac.val().length ==12 && v!==null) {
    Mac.css('border','');
  }else Mac.css("border", "2px solid red");

}

function openNav() {
  document.getElementById("mySidenav").style.width = "35%";

}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
