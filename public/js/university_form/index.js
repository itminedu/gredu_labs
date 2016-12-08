(function ($, _, utils) {
    'use strict';

    (function () {
        var form = $('#app-form form');
        var messages = form.data('messages');
        utils.formMessages.render(form, messages);
    }());

}(window.jQuery, _, window.EDULABS.utils));





window.onload = function() {

           $('#el-idrima').attr("disabled", true);
           $('#el-sxolh').attr("disabled", true);
           $('#el-tmhma').attr("disabled", true);
           $('#el-ereunitiko').attr("disabled", true);
           $('#el-institute').attr("disabled", true);
           $('#el-other').attr("disabled", true);
     
           $('label[for="el-ereunitiko"]').attr("disabled", true); 
           $('label[for="el-institute"]').attr("disabled", true);
           $('label[for="el-other"]').attr("disabled", true);
           $('label[for="el-idrima"]').attr("disabled", true);
           $('label[for="el-sxolh"]').attr("disabled", true);
           $('label[for="el-tmhma"]').attr("disabled", true);

           if(isNaN(parseInt(document.getElementById("hididrima").value))){

           }
           else
           { 
             $("#newselect").prop("selectedIndex", 1); 
             $("#newselect").change();
           }

            if(isNaN(parseInt(document.getElementById("hidereunitiko").value))){

            }
          else
           { 
             $("#newselect").prop("selectedIndex", 2); 
             $("#newselect").change();
           }

  }







$('#el-idrima').on('change', function() {

   var key = this.value;

 $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "13"} ,
        dataType: 'json',

    }).done(function(data, statusText, resObject) {


   if (document.getElementById("el-sxolh").options.length != 0) {
           var i;
    for(i = document.getElementById("el-sxolh").options.length-1;i >= 1; i--)
             {
               document.getElementById("el-sxolh").remove(i);
             }
             $("#el-sxolh").append('<option value=1></option>');
    }
  if (document.getElementById("el-tmhma").options.length != 0) {
           var i;

         for(i = document.getElementById("el-tmhma").options.length-1;i >= 1; i--)
             {
               document.getElementById("el-tmhma").remove(i);
             }
            $("#el-tmhma").append('<option value=1></option>');
  }

     for ( var index = 0; index < data.length; index++ ) {
      if (data[ index ].parents == data[key].tid && data[ index ].depth == 1)
        $('#el-sxolh')
         .append($("<option></option>")
                    .attr("value",index)
                    .text(data[ index ].name));
    }
    });
});






$('#el-sxolh').on('change', function() {

   var key = this.value;

 $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "13"} ,
        dataType: 'json',

    }).done(function(data, statusText, resObject) {

     if (document.getElementById("el-tmhma").options.length != 0) {
           var i;

    for(i = document.getElementById("el-tmhma").options.length-1;i >= 1; i--)
             {
               document.getElementById("el-tmhma").remove(i);
             }
             $("#el-tmhma").append('<option value=1></option>');
  }
     for ( var index = 0; index < data.length; index++ ) {
      if (data[ index ].parents == data[key].tid && data[ index ].depth == 2)

        $('#el-tmhma')
         .append($("<option></option>")
                    .attr("value",index)
                    .text(data[ index ].name));
    }

    });
});



$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><div><label for="projects">Σχετική δράση που συμμετείχατε </label><input type="text" name="projects" id="projects"></div>        <div><label for="urlproject">URL δράσης που συμμετείχατε</label><input type="text" name="urlproject" id="urlproject"></div>        <div><label for "commentproject">Περιγραφή δράσης που συμμετείχατε</label><input type="text" name="commentsproject" id="commentproject"></div><a href="#" class="remove_field">Διαγραφή</a></div>'); 
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault();
         $(this).parent('div').remove(); x--;
    })






    $("#submit").click(function(){
 
      
      $('#hidnewselect').val(document.getElementById("newselect").value);


      var projects = $("input[id='projects']")
              .map(function(){return $(this).val();}).get();

      var urlproject = $("input[id='urlproject']")
              .map(function(){return $(this).val();}).get();

     var commentproject = $("input[id='commentproject']")
              .map(function(){return $(this).val();}).get();

      var newfield = projects+"#"+urlproject+"#"+commentproject;

      $('#projectdescription').val(newfield);

    })

});







$('#newselect').on('change', function() {
  
  selection = $("#newselect").val();
 
  switch(selection)
   {
       case 'idrimata':
           $('#el-ereunitiko').attr("disabled", true);
           $('#el-ereunitiko').val('');
           $('#el-institute').attr("disabled", true);
           $('#el-institute').val('');
           $('#el-other').attr("disabled", true);
           $('#el-other').val('');
           $('label[for="el-ereunitiko"]').attr("disabled", true);
           $('label[for="el-institute"]').attr("disabled", true);
           $('label[for="el-other"]').attr("disabled", true);
           $('#el-idrima').attr("disabled", false);
           $('#el-sxolh').attr("disabled", false);
           $('#el-tmhma').attr("disabled", false);
           $('label[for="el-sxolh"]').attr("disabled", false);
           $('label[for="el-tmhma"]').attr("disabled", false);
           $('label[for="el-idrima"]').attr("disabled", false);

    $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "13"} ,
        dataType: 'json',

    }).done(function(data, statusText, resObject) {
 
  

    for ( var index = 0; index < data.length; index++ ) {
      if (data[ index ].depth == 0)
      {
        if (index == parseInt(document.getElementById("hididrima").value)){
           $('#el-idrima')
           .append($("<option selected ></option>")
                    .attr("value",index)
                    .text(data[ index ].name));

            refresh(index);
     }
     else
     {
            $('#el-idrima')
           .append($("<option></option>")
                    .attr("value",index)
                    .text(data[ index ].name));
     }
     }
     }
     });

       break;
       case 'ereunitika':
           $('#el-idrima').val('');
           $('#el-sxolh').val('');
           $('#el-tmhma').val('');
           $('#el-idrima').attr("disabled", true);
           $('#el-sxolh').attr("disabled", true);
           $('#el-tmhma').attr("disabled", true);
           $('#el-ereunitiko').attr("disabled", false);
           $('#el-institute').attr("disabled", false);
           $('#el-other').attr("disabled", true);
           $('label[for="el-ereunitiko"]').attr("disabled", false); 
           $('label[for="el-institute"]').attr("disabled", false);
           $('label[for="el-other"]').attr("disabled", false);
           $('label[for="el-idrima"]').attr("disabled", true);
           $('label[for="el-sxolh"]').attr("disabled", true);
           $('label[for="el-tmhma"]').attr("disabled", true);
     $.post({
            url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
            type: 'POST',
            data: { vid: "15"} ,
            dataType: 'json',

        }).done(function(data1, statusText, resObject) {
          
          for ( var index1 = 0; index1 < data1.length; index1++ ) {
            if (data1[ index1 ].depth == 0)
            {
        
            if (index1 == parseInt(document.getElementById("hidereunitiko").value))
            {
                 $('#el-ereunitiko')
                    .append($("<option selected ></option>")
                    .attr("value",index1)
                    .text(data1[ index1 ].name));


                  refresh1(index1);
            }
          else
          {
                $('#el-ereunitiko')
                .append($("<option></option>")
                      .attr("value",index1)
                      .text(data1[ index1 ].name));

          }
      }
    }
    });
   break;
   }
}); 






  $('#el-ereunitiko').on('change', function() {
  var key = this.value;
  
  $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "15"} ,
        dataType: 'json',

    }).done(function(data1, statusText, resObject) {
  if (document.getElementById("el-institute").options.length != 0) 
  {
    var i;
    for(i = document.getElementById("el-institute").options.length-1;i >= 1; i--)
    {
       document.getElementById("el-institute").remove(i);
    }
    $("#el-institute").append('<option value=1></option>');
  }
  for ( var index1 = 0; index1 < data1.length; index1++ ) 
  {
     if (data1[ index1 ].parents == data1[key].tid && data1[ index1 ].depth == 1)
        $('#el-institute')
           .append($("<option></option>")
                    .attr("value",index1)
                    .text(data1[ index1 ].name));
  }
    $("#el-institute").append('<option value=1000>ΑΛΛΟ</option>');
  });

  val1= document.getElementById("el-ereunitiko").value;

  if (document.getElementById("el-idrima").options.length != 0) {
  var i;
      for(i = document.getElementById("el-idrima").options.length-1;i >= 1; i--)
      {
        document.getElementById("el-idrima").remove(i);
      }
    }
  });





  $('#el-institute').on('change', function() {
  
    sel = $("#el-institute").val();
    switch(sel)
    {
       case '1000':
           $('#el-other').attr("disabled", false);
           $('#lother').attr("disabled", false);
           break;
       default:
          $('#el-other').val("");
          $('#el-other').attr("disabled",true);
            
    }
  }); 




 function refresh(key) {


    $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "13"} ,
        dataType: 'json',

    }).done(function(data, statusText, resObject) {

   for ( var index = 0; index < data.length; index++ ) 
   {
      if (data[ index ].parents == data[key].tid && data[ index ].depth == 1)
         if (index == parseInt(document.getElementById("hidsxolh").value))
         {
            $('#el-sxolh')
                 .append($("<option selected></option>")
                    .attr("value",index)
                    .text(data[ index ].name));

            for ( var index1 = 0; index1 < data.length; index1++ ) 
            {
              if (data[ index1 ].parents == data[index].tid && data[ index1 ].depth == 2)
              if (index1 == parseInt(document.getElementById("hidtmhma").value))
              {

                 $('#el-tmhma')
                     .append($("<option selected></option>")
                            .attr("value",index1)
                            .text(data[ index1 ].name));
              }
              else
              {

                  $('#el-tmhma')
                     .append($("<option  ></option>")
                            .attr("value",index1)
                            .text(data[ index1].name));

              }

            }

        }

      else
      {
          $('#el-sxolh')
             .append($("<option  ></option>")
                    .attr("value",index)
                    .text(data[ index ].name));


      }

    }
    });
}




function refresh1(key) {


    $.post({
        url: 'http://relabs1.minedu.gov.gr/mypoint/taxonomy_vocabulary/getTree.json',
        type: 'POST',
        data: { vid: "15"} ,
        dataType: 'json',

    }).done(function(data1, statusText, resObject) {


     for ( var index1 = 0; index1 < data1.length; index1++ ) {
      console.log(data1[ index1 ].parents,data1[key].tid, data1[ index1 ].depth)
      if (data1[index1].parents == data1[key].tid && data1[ index1 ].depth == 1)
      if (index1 == parseInt(document.getElementById("hidinstitute").value)){


         $('#el-institute')
             .append($("<option selected></option>")
                    .attr("value",index1)
                    .text(data1[ index1 ].name));

           }

      else
{
          $('#el-institute')
             .append($("<option  ></option>")
                    .attr("value",index1)
                    .text(data1[ index1 ].name));


}

    }
    });
}

