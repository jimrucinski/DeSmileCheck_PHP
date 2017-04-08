
$(document).ready(function(){
   
                $(".datemask").mask("9999/99/99",{placeholder:"yyyy/mm/dd"});
                $(".phone").mask("(999) 999-9999");                

                /*Clear all input elements in form*/
                $('#SmileForm').on('click','#clearme',function(){
                   $('.smileForm').find('input:text, input:password, select, input:hidden, textarea').val('');
                   $('.smileForm').find('input:radio, input:checkbox').prop('checked', false);   
                   $('.error').css('visibility','hidden'); 
 
                });

                $("#addStudent").on('click',function(){
                    ret = true;
                    if($('#student_grade').val()==''){
                        $('#student_grade').css('border-color','red');
                        ret = false;
                    }        
                    return ret;
                });

                $("#addScreening").on('click',function(){
                    ret = true;
                    if($('#schoolSelect').val()==''){
                        $('#schoolSelect').css('border-color','red');
                        ret = false;
                    }          
                    return ret;
                  
                });
});
