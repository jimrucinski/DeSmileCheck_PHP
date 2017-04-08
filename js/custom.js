 $(document).ready(function(){
                $("#datepicker").mask("9999/99/99",{placeholder:"yyyy/mm/dd"});
                $("#phonenumber").mask("(999) 999-9999");                

                /*Clear all input elements in form*/
                $('#clearme').on('click',function(){
                    alert($('#hidden').val());
                   $('#myform').find('input:text, input:password, select, input:hidden, textarea').val('');
                   $('#myform').find('input:radio, input:checkbox').prop('checked', false);   
                   $('.error').css('visibility','hidden'); 
                   alert($('#hidden').val());      
                });

                $("#submit").on('click',function(){
                    var junk = $("#datepicker").val();
                    var good = true;
                    if(junk==""){
                        $("#datepicker").next("span").css('visibility','visible');
                        return false;
                    }               
                });
});
