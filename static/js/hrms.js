
/**
 * process bar, you know
 * when loading process done, show the links.
 */
function fakeLoading(){
  
    var prog = $('#progressbar').attr('style');

    //console.log(prog);

    re = new RegExp("width: ([0-9]+)%","g");
    prog = Number(String(prog).replace(re,'$1'));
  
    if(prog < 130 ){
        prog += 10;
        $('#progressbar').attr("style","width: "+prog+"%");
        setTimeout(fakeLoading, 100)
    }else{
        $('#fakeProgress').toggle();
        $('.lead').toggle();
    }
}

function submitNewDetail(){

    $('#detail_form').ajaxSubmit({
        type:'post',
        url:'/position_controller/updateStaffInfo',
        dataType:'text',
        success:function(result){
            if(result == 'SUCCESS'){
                $('#detail_modal').modal('hide');
            }else{
                alert(result);
            }
        }
    });
    
}

function submitAddStaff(){
    $('#addStaff_form').ajaxSubmit({
        type:'post',
        url:'/position_controller/addStaff',
        dataType:'text',
        success:function(result){
            if(result == 'SUCCESS'){
                $('.alert').attr('class',"alert alert-success fade in ");
                $('.alert').text("Good");
                location.href="/position_controller";
            }else{
                $('.alert').attr('class',"alert alert-warning fade in ");
                $('.alert').text(result);
            }
        }
    });
}

function dateChanged () {
    var date = $('#datepicker').val().split('-');
    //console.log(date);
    location.href="/attendance_controller/attendanceList/"+date[0]+'/'+date[1]+'/'+date[2];
}

function dateChanged2 () {
    var date = $('#datepicker2').val().split('-');
    //console.log(date);
    location.href="/attendance_controller/attendanceList/"+date[0]+'/'+date[1];
}

$(document).ready(function(){  

    fakeLoading(); 

    $(".money").popover();

    /**
     * position_controller -> staffList_view
     * display a modal of staff details.
     */
    $(".staff_row").click(function(){
        var obj = $(this);

        var staff_name = obj.find(".staff_name").text();
        var staff_id = obj.find(".staff_id").text();

        $.getJSON("/position_controller/staffDetail_JSON/"+staff_id,function(json){
            $('#modal_detail').text(staff_name);
            $('#detail_id').text(json.id);
            $('#detail_sex').text(json.sex);
            $('#detail_email').text(json.email);
            $('#detail_tel').text(json.tel);
            $('#detail_addr').text(json.addr);
            $('#detail_status').text(json.status);
            $('#detail_salary').text(json.baseSalary);
            $('#detail_position').text(json.position);
            $('#new_id').val(json.id);

            $('#detail_modal').modal('toggle');
        });
       
    });



    $('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 0,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_date2').datetimepicker({
        language:  'zh-CN',
        weekStart: 0,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 3,
        minView: 3,
        forceParse: 0
    });
});


var num=0;
function submitNewSalary(){

    $('#salary_form').ajaxSubmit({
        type:'post',
        url:'/salary_controller/updateSalaryInfo',
        dataType:'text',
        success:function(result){
            if(result == 'SUCCESS'){
                $('#salary_modal').modal('hide');
                 location.reload();
            }else{
                alert(result);
            }
        }
    });
    
}

    $(".salary_row").click(function(){
        var obj = $(this);

        var staff_name = obj.find(".staff_name").text();
        var staff_id = obj.find(".staff_id").text();
        var year = obj.find(".salary_year").text();
        var month = obj.find(".salary_month").text();
        $('#salary_form').empty();
        $.getJSON("/salary_controller/salaryDetail_JSON/"+staff_id+"/"+year+"/"+month,function(json){
            $('#modal_salary').text(staff_name);
            $('#xxoo').text(json.staff_id); 
            $('#salary_final').text(json.final);
            $('#new_id').val(json.id);
            num = json.others.length;
            for (var i = json.others.length - 1; i >= 0; i--) {
          var one = '<div class="row"><div class="col-md-7"><input type="text" class="form-control"\
           name="data['+i+'][reason]" \
           value="'+json.others[i]["reason"]+'" /></div><div class="col-md-3">\
          <input type="number" class="form-control"  name="data['+i+'][quantity]" \
          value="'+json.others[i]["quantity"]+'" /></div></div>' ;
                $('#salary_form').append(one);

            };
            $('#salary_modal').modal('toggle');
        });
       
    });



function add_one_others()
{
   var one = '<div class="row"><div class="col-md-7"><input type="text" class="form-control" name="data['+num+'][reason]" placeholder="原因"/> \
   </div><div class="col-md-3"><input type="number" class="form-control"  name="data['+num+'][quantity]" placeholder="金额"/></div></div>' ;
                $('#salary_form').append(one);
                num++;
}
