$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
  radioClass   : 'iradio_flat-green'
});

function savenewpass(baseUrl) {
    var valid = true;
    if ($("#user_pass_change").val() === '') {
        alert('Silahkan isi Password');
        $("#user_pass_retype").val('');
        valid = false;
    }
    if ($("#user_pass_change_retype").val() !== $("#user_pass_change").val()) {
        alert('Password tidak sama');
        $("#user_pass_change_retype").val('');
        valid = false;
    }

    if (valid) {
        $.ajax({
           url : baseUrl+"user_admin/change_password",
           type: "POST",
           dataType:'json',
           data : {
               user_pass : $("#user_pass_change").val()
               },
           success: function(data){
               if (data['message'] === 'success') {
                   alert('Ganti Password berhasil');
                    window.location.replace(baseUrl+"login/logout");
               }

           }
        });
    }
}
    
function add_users(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"user_admin/add/"+id);
    } else {
        window.location.replace(baseUrl+"user_admin/add");
    }
    
}

function add_data(baseUrl, ctrlName, id,funcName) {
    if (!funcName || funcName === '') {
        funcName ='add';
    }
    if (id && id != '') {
        window.location.replace(baseUrl+ctrlName+"/"+funcName+"/"+id);
    } else {
        window.location.replace(baseUrl+ctrlName+"/"+funcName);
    }
    
}

function delete_data(baseUrl,controllerName,page) {
    if (!page) {
        page = 'index';
    }
    var dataDelete = new Array();
    $(".delcheck").each(function(){
        if($(this).is(":checked")) {
            var rawData = {
                id:$(this).val()
            };
            dataDelete.push(rawData);
            }
    });
    
    if (dataDelete.length > 0) {
        var confirmBox = confirm("Anda Yakin ingin menghapus Data ?");
        if (confirmBox==true) {
            $.ajax({
               url : baseUrl+controllerName+"/delete",
               type: "POST",
               dataType:'json',
               data : {
                   dataDelete : dataDelete

            //                asrs_data:JSON.stringify(data_tables)
                   },
               success: function(data){
                   if (data['success']) {
                       alert(data['message']);
                        if (data['url'] == '') {
                            window.location.replace(baseUrl+controllerName+"/"+page);
                        } else {
                            window.location.replace(baseUrl+controllerName+'/'+data['url']);
                        }
                   }

               }
            });
        } 
        
    }

}

function check_pass(formName) {
    var valid = true;
    if ($("#user_pass").val() !== '' || $("#user_pass_retype").val() !== '') {
        if ($("#user_pass_retype").val() !== '') {
            if ($("#user_pass").val() !== $("#user_pass_retype").val()) {
                alert('Password dont match');
                valid = false;
            }
        } else {
            alert('Retype Password');
            valid = false;
        }
    }
    if (valid) {
        $("#"+formName+"").submit();
    }
}
function add_menu(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"menu/add/"+id);
    } else {
        window.location.replace(baseUrl+"menu/add");
    }
    
}

function add_content(baseUrl, id) {
    if (id && id != '') {
        window.location.replace(baseUrl+"content/add/"+id);
    } else {
        window.location.replace(baseUrl+"content/add");
    }
    
}

function auth_edit(baseUrl, groupCode) {
    window.location.replace(baseUrl+"group/auth_edit/"+groupCode);
}

function cancelButton(baseUrl,controller) {
    window.location=baseUrl+controller+"/index";
}

function delrowdata(t) {
    $(t).parent().parent().remove();
}

function export_data(baseUrl,ctrl) {
    $.ajax({
        url : baseUrl+ctrl+"/export_csv",
        type: "POST",
        dataType:'html',
        data : {
//                search:$(obj).val() 
            },
        success: function(data)
        {
        }
    });
}

function show_password() {
    if ($("#pass").attr('type') ==='password') {
        $("#pass").attr('type','text');
    } else if ($("#pass").attr('type') ==='text') {
        $("#pass").attr('type','password');
    }
}

function get_report(baseUrl,controller,formName,id) {
    $(".overlay").show();
    $.ajax({
        url : baseUrl+controller+"/paging",
        type: "POST",
        dataType:'json',
        data : $('#'+formName+'').serialize() ,
        success: function(data)
        {
            if (data['result']) {
                $(".overlay").hide();
                $("#"+id).DataTable().clear().destroy();
                if ($("#"+id).children("tbody").length > 0) {
                    $("#"+id+" > tbody").html('');
                    $("#"+id+" > tbody").html(data['template']);
                } 
                else {
                    $("#"+id+"").html('');
                    $("#"+id+"").html(data['template']);
                }

//                if (data['pnumber'] === 0) {
//                    data['pnumber'] = 1;
//                }
//                $("#limit").val(data['limit']);
//                $(".pnumber").val(data['pnumber']);
//                $(".pnumber").html(data['pnumber']);
//                $("#totaldata").val(data['totaldata']);
//                $("#totaldata_view").text('of '+Math.ceil(data['totaldata']/10));
//                var table = $('#overtime_report_list').DataTable( {
//                    ajax: "data.json"
//                } );
                
                $("#"+id+"").DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                  });
//                initPaging();
            }
        }
    });
}

function cetak_excel_report(formName,exportType) {
    var valid = true;
    if (valid) {
        $("#export_type").val(exportType);
        $('#'+formName+'').submit();
    }
}

function add_category(baseUrl,controller,elm){
    $.ajax({
        url : baseUrl+controller+"/category_list",
        type: "POST",
        dataType:'json',
        data : {},
        success: function(data)
        {
            if (elm=='') {
                $(data['htmldata']).appendTo('#product_add > tbody');
            } else {
                $(data['htmldata']).appendTo('#'+elm+' > tbody');
            }
            
            
        }
    });
}
function delcategory(t) {
    console.log($(t).parents("div:first").parent());
    $(t).parents("div:first").parent().remove();
}

function formatRupiah(obj, prefix) {
   var separator; 
  var number_string = $(obj).val().replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);
  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if (ribuan) {
    separator = sisa ? "." : "";
    rupiah += separator + ribuan.join(".");
  }

  rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
  $(obj).val(prefix == undefined ? rupiah : rupiah ? rupiah : "");
//  $(obj).val(prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "");
//  return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function get_category(baseUrl,controller,obj) {
    $.ajax({
        url : baseUrl+controller+"/get_categories",
        type: "POST",
        dataType:'json',
        data : {
                menuid:$(obj).val() 
            },
        success: function(data)
        {
            if (data['htmldata'] !=='') {
                $("#category_add > tbody").html('');
                $(data['htmldata']).appendTo('#category_add > tbody');
            } else {
                $("#category_add > tbody").html('');
            }
            
            
        }
    });
}

function set_number() {
    $('input.number').on('input', function() {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
      });
}

function roundDown(number, decimals) {
    decimals = decimals || 0;
    return ( Math.ceil( number * Math.pow(10, decimals) ) / Math.pow(10, decimals) );
}

function backpage(baseUrl,ctrl){
    window.location.replace(baseUrl+ctrl+"/index");
}

function add_verification(baseUrl,controller,elm,obj){
    $.ajax({
        url : baseUrl+controller+"/verification_list",
        type: "POST",
        dataType:'json',
        data : {
//                search:$(obj).val() 
            },
        success: function(data)
        {
            $(data['htmldata']).appendTo($(obj).parent().next('div').children().children().find('tbody'));
        }
    });
}

function process_order(baseUrl,controller,formName,id) {
    $(".overlay").show();
    $.ajax({
        url : baseUrl+controller+"/paging",
        type: "POST",
        dataType:'json',
        data : $('#'+formName+'').serialize() ,
        success: function(data)
        {
            if (data['result']) {
                $(".overlay").hide();
                $('#'+id+"").DataTable().clear().destroy();
                if ($("#"+id).children("tbody").length > 0) {
                    $("#"+id+" > tbody").html('');
                    $("#"+id+" > tbody").html(data['template']);
                } 
                else {
                    $("#"+id+"").html('');
                    $("#"+id+"").html(data['template']);
                }
                
                $('#'+id+"").DataTable({
                    'paging'      : true,
                    'lengthChange': false,
                    'searching'   : false,
                    'ordering'    : true,
                    'info'        : true,
                    'autoWidth'   : false
                  });
            }
        }
    });
}

function cetak_excel_order(formName,type) {
    var valid = true;
    if (valid) {
        $('#'+formName+'').submit();
    }
}

function detail_order(baseUrl,ctrl,id) {
    $.ajax({
        url : baseUrl+ctrl+"/detail",
        type: "POST",
        dataType:'json',
        data : {
                id:id
            },
        success: function(data)
        {
//            if (data['prdc_cost']) {
                $("#detail_order").modal('show');
                $("#reg_nmbr").html(data['orderdata']['order_reg_nmbr']);
                $("#order_user_name").html(data['orderdata']['user_name']);
                $("#order_ctgr_name").html(data['orderdata']['ctgr_name']);
                $("#order_prdc_name").html(data['orderdata']['prdc_name']);
                $("#order_lctn_name").html(data['orderdata']['lctn_name']);
                $("#schd_date").html('<p>Date : '+data['orderdata']['order_schd_date']+'</p>\n\
                <p>'+data['orderdata']['schd_desc']+' : '+data['orderdata']['schd_time_from']+' : '+data['orderdata']['schd_time_to']+'</p>');
//            }
        }
    });
}

function add_product_order(baseUrl,controller,elm){
    $.ajax({
        url : baseUrl+controller+"/add_product_order",
        type: "POST",
        dataType:'json',
        data : {
            },
        success: function(data)
        {
            $(data['htmldata']).appendTo('#'+elm+' > tbody');
        }
    });
}

function delproduct(t) {
    $(t).parent().parent().remove();
}

function sum_total_row(obj) {
    var parent = $(obj).parent().closest('tr');
    var totalRow = 0;
    totalRow = parseInt($(obj).val() * parent.children().find(".price_info").val());
    parent.children().find('.total_row').val(totalRow);
    sum_total_all();
}

function get_price(obj) {
    $(obj).parent().closest('tr').children().find(".price_info").val($(obj).find('option:selected').attr('price'));
}

function sum_total_all() {
    var totalPrice = 0;
    $(".total_row").each(function () {
        totalPrice += parseInt($(this).val());
    });
    
    $("#order_cost").val(parseInt(totalPrice));
    $("#order_ppn").val(parseInt(totalPrice) *0.1);
    $("#order_total_cost").val(parseInt($("#order_cost").val()) + parseInt($("#order_ppn").val()));
}

function payment_order() {
    var payment = 0;
    if ($("#order_payment").val() !== "" && parseInt($("#order_payment").val()) > parseInt(0)) {
        payment = parseInt($("#order_payment").val())-parseInt($("#order_total_cost").val());
        $("#order_change").val(payment);
    } else {
        $("#order_change").val(0);
    }
}