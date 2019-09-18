function jzDropDownColumnEdit(id,className,attribute,key,url,loaderPath,updateAll){    
    $('#jzdc_input_id_'+id).show();
    $('#jzdc_input_id_'+id).unbind('keyup');
    $('#jzdc_input_id_'+id).keyup(function(event){
        var keyCode = event.which;             
	if(keyCode == undefined){keyCode = event.keyCode;}
	if(keyCode==13){jzDropDownColumnSave(id,className,attribute,key,url,loaderPath,updateAll);}
	if(keyCode==27){jzDropDownColumnDeny(id,attribute,key);}
    });
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_empty_id_'+id).hide();
    $('#jzdc_title_id_'+id).hide();
    $('#jzdc_input_id_'+id).show();
    $('#jzdc_input_id_'+id).focus();
    $('#jzdc_input_id_'+id).select();
    $('#jzdc_save_id_'+id).show();
    $('#jzdc_deny_id_'+id).show();
    return false;//just in case
}
    
function jzDropDownColumnSave(id,className,attribute,key,url,loaderPath,updateAll){ 
    var pjaxId=$('#jzdc_title_id_'+id).closest('.pjax').attr('id');
    var tmpTitle=$('#jzdc_input_id_'+id).val();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_input_id_'+id).blur();
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_info_id_'+id).html('<img src="'+loaderPath+'">');
    $('#jzdc_info_id_'+id).show();
    $.ajax({
        timeout: 29000, //29 sec
	url: url,
	data: {data:JSON.stringify({class:className,id:key,attribute:attribute,value:$('#jzdc_input_id_'+id).val()})},
        dataType: 'json',
     	success:function(data){
            if(data.msg==0){
                $('#jzdc_empty_id_'+id).show(); 
                $('#jzdc_title_id_'+id).show();
                $('#jzdc_info_id_'+id).html(data.val);
                $('#jzdc_info_id_'+id).fadeOut(6000);
            }
            if(data.msg==1){
                if(updateAll){
                    $('.pjax').each(function(){
                        $.pjax.reload({container:'#'+$(this).attr('id'), timeout:10000, push: false, async:false}).done(function(){
                            $('#'+$(this).attr('loader')).hide();
                        });                        
                    });
                    
                } else {
                    $.pjax.preventDefaults;
//                    $.pjax.defaults.timeout = 10000;
                    $.pjax.reload({container:'#'+pjaxId,timeout:10000, push: false,replace: false});
                }
            }
     	},
     	error:function(e,st,ss){
            alert('Error! '+ss);
            window.location.reload();
     	},
     	complete:function(data){
//            alert(data.responseText);
     	},
    });   
    return false;
}

function jzDropDownColumnDeny(id){
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_title_id_'+id).show(); 
    $('#jzdc_empty_id_'+id).show(); 
}

//****    

function jzDataColumnTextEdit(id,className,attribute,key,url,loaderPath,updateAll){
    $('#jzdc_input_id_'+id).val($('#jzdc_title_id_'+id).text());
    $('#jzdc_input_id_'+id).unbind('keyup');
    $('#jzdc_input_id_'+id).keyup(function(event){
        var keyCode = event.which;             
	if(keyCode == undefined){keyCode = event.keyCode;}
	if(keyCode==13){jzDataColumnTextSave(id,className,attribute,key,url,loaderPath,updateAll);}
	if(keyCode==27){jzDataColumnTextDeny(id,attribute,key);}
    });
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_empty_id_'+id).hide();
    $('#jzdc_title_id_'+id).hide();
    $('#jzdc_input_id_'+id).show();
    $('#jzdc_input_id_'+id).focus();
    $('#jzdc_input_id_'+id).select();
    $('#jzdc_save_id_'+id).show();
    $('#jzdc_deny_id_'+id).show();
    return false;//just in case
}
    
function jzDataColumnTextSave(id,className,attribute,key,url,loaderPath,updateAll){     
    var pjaxId=$('#jzdc_title_id_'+id).closest('.pjax').attr('id');
    var tmpTitle=$('#jzdc_input_id_'+id).val();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_input_id_'+id).blur();
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_info_id_'+id).html('<img src="'+loaderPath+'">');
    $('#jzdc_info_id_'+id).show();
    $.ajax({
        timeout: 29000, //29 sec
	url: url,
	data: {data:JSON.stringify({class:className,id:key,attribute:attribute,value:$('#jzdc_input_id_'+id).val()})},
        dataType: 'json',
     	success:function(data){
            if(data.msg==1){
                if(updateAll){
                    $('.pjax').each(function(){
                        $.pjax.preventDefaults;
                        $.pjax.reload({container:'#'+$(this).attr('id'),timeout:10000, push: false, async:false}).done(function(){
                            $('#'+$(this).attr('loader')).hide();
                        });                        
                    });
                    
                } else {
                    $.pjax.preventDefaults;
                    $.pjax.reload({container:'#'+pjaxId,timeout:10000, push: false});
                }
            }
            if(data.msg==0){
                $('#jzdc_empty_id_'+id).show(); 
                $('#jzdc_title_id_'+id).show();
                $('#jzdc_info_id_'+id).html(data.val);
                $('#jzdc_info_id_'+id).fadeOut(6000);
            }
     	},
     	error:function(e,st,ss){
            alert('Error! '+ss);
            window.location.reload();
     	},
     	complete:function(data){
//            alert(data.responseText);
     	},
    });   
    return false;
}

function jzDataColumnTextDeny(id){
    $('#jzdc_info_id_'+id).hide(); 
    $('#jzdc_save_id_'+id).hide();
    $('#jzdc_deny_id_'+id).hide();
    $('#jzdc_input_id_'+id).hide();
    $('#jzdc_title_id_'+id).show(); 
    $('#jzdc_empty_id_'+id).show(); 
}
