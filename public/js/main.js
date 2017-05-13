/**
 * Created by 90930034 on 19/03/2017.
 */


$(document).ready(function () {
    t_e_cost=0;
    $("div[id^='Confirmed_']").each(function()
    {
        $(this).css('background-color','#2275d7') ;
    });
    $("div[id^='Edited_']").each(function()
    {
        $(this).css('background-color','#bd4147') ;
    });
      $("a[id^='data-row']").each(function()
    {
        $(this).click(function(e) {
            $(this).closest('div.panel-default').children('div.panel-body').toggle('display');

            e.preventDefault();
        });
    });
    $("a[id^='site-more-links']").each(function(index)
    {
        $(this).click(function(e) {
            var $morelinks='more-links'+(index+1);
            $(this).closest('article').children('div').eq(0).toggle('display');
            e.preventDefault();
        });
    });
    $("button[id^='addroom']").each(function(index)
    {
        $(this).click(function(e) {
            var _token=$("input[name='_token']")[0];
            var siteID=(this.id).split("_")[1];
            var roomID='roomID'+siteID;
            var roomType='roomType'+siteID;
            var msgID='addroommsg'+siteID;
            var id=$("input[name=" + roomID + "]")[0];
            var type=$("input[name=" + roomType + "]")[0];
            var msg=$("p[name=" + msgID + "]")[0];
            if(id.value.trim().length < 1 || type.value.trim().length < 1)
            {
                $(msg).css('display','block').css('color','red');
                $(msg).text("ID and Type are required");
                $(msg).delay(3000).fadeOut();
            }
            else
            {
                var data = {
                    _token: _token.value,
                    siteid: siteID,
                    roomid: id.value.trim(),
                    roomtype: type.value.trim(),
                };
                $.ajax({
                    type: "POST",
                    url: "addroom",
                    data: data,
                    success: function (data) {
                        console.log(data);
                        if(data=='error')
                        {
                            $(msg).css('display','block').css('color','red');
                            $(msg).text("Room ID Already Existed ");
                            $(msg).delay(3000).fadeOut();
                            $(id).val("");
                            $(type).val("");
                        }
                        else
                        {
                            $(msg).css('display','block').css('color','blue');
                            $(msg).text("Room Added Successfully");
                            $(msg).delay(3000).fadeOut();

                        }
                    }
                }, "json");
            }
            e.preventDefault();
        });
    });
    $(document.body).on('click', '.adduser' ,function() {
         $(".msg").delay(100).fadeOut();
        $(".error").delay(100).fadeOut();
        $("#update_user").css('display','none');
        $("#add_new_user").css('display','block');
        e.preventDefault();
    });
    $(document.body).on('click', '.delservice' ,function(e) {
       $(this).closest(".service-container").remove();
        e.preventDefault();
    });
    $(document.body).on("click", $("a[class='updateuser_26']"),function(e) {
        var action = (e.data.context.activeElement.className).split("_")[0];
        if(action=="updateuser")
        {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_user").css('display', 'none');
            $("#update_user").css('display', 'block');
            console.log();
            var userid = (e.data.context.activeElement.className).split("_")[1];
            var data = {
                /*  _token: _token.value,*/
                userid: userid,
            };
            $.ajax({
                type: "GET",
                url: "getUserInfo",
                data: data,
                success: function (data) {
                    //console.log(data);
                    $("#id").val(data["id"]);
                    var form_controls = $("#update_user > form .input");
                    var title = form_controls[0];
                    $(title).prop("value", data["title"])
                    var fullname = form_controls[1];
                    $(fullname).val(data["fullname"])
                    var email = form_controls[2];
                    $(email).val(data["email"])
                    var accesslevel = form_controls[3];
                    $(accesslevel).prop("value", data["accesslevel"])
                    console.log(data["accesslevel"]);
                    var address = form_controls[4];
                    $(address).val(data["address"])
                    var mobile = form_controls[5];
                    $(mobile).val(data["mobile"])
                    var phone = form_controls[6];
                    $(phone).val(data["phone"])
                    var fax = form_controls[7];
                    $(fax).val(data["fax"]);
                }
            }, "json");
            e.preventDefault();
        }
        if(action=="deleuser")
        {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_user").css('display', 'none');
            $("#update_user").css('display', 'block');
            var userid = (e.data.context.activeElement.className).split("_")[1];
            var data = {
                /*  _token: _token.value,*/
                userid: userid,
            };
            $.ajax({
                type: "GET",
                url: "delUser",
                data: data,
                success: function (data) {
                    console.log(data);
                    if (data == "y") {
                        $("span.msg").css('display','block').css('color','white');
                        $("span.msg").text("User Deleted!");
                        $("span.msg").delay(3000).fadeOut();
                        loadUsersData();
                        //window.location.href = '/users';
                    }
                    else
                    {

                    }
                }
            }, "json");
            e.preventDefault();
        }
        if(action=="blockuser")
        {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_user").css('display', 'none');
            $("#update_user").css('display', 'block');
            var userid = (e.data.context.activeElement.className).split("_")[1];
            var data = {
                /*  _token: _token.value,*/
                userid: userid,
            };
            $.ajax({
                type: "GET",
                url: "blockUser",
                data: data,
                success: function (data) {
                    console.log(data);
                    if (data == "y") {
                        $("span.msg").css('display','block').css('color','white');
                        $("span.msg").text("User Blocked!");
                        $("span.msg").delay(3000).fadeOut();
                        loadUsersData();
                       // window.location.href = '/users';
                    }
                    else
                    {

                    }
                }
            }, "json");
            e.preventDefault();
        }
        if(action=="unblockuser")
        {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_user").css('display', 'none');
            $("#update_user").css('display', 'block');
            var userid = (e.data.context.activeElement.className).split("_")[1];
            var data = {
                /*  _token: _token.value,*/
                userid: userid,
            };
            $.ajax({
                type: "GET",
                url: "unblockUser",
                data: data,
                success: function (data) {
                    console.log(data);
                    if (data == "y") {
                        $("span.msg").css('display','block').css('color','white');
                        $("span.msg").text("User Unlocked!");
                        $("span.msg").delay(3000).fadeOut();
                        loadUsersData();
                    }
                    else
                    {

                    }
                }
            }, "json");
            e.preventDefault();
        }
        if(action=="updatesite")
        {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_site").css('display','none');
            $("#update_site").css('display','block').css('position','absolute')
            .css('top','75px').css('width','80%')
            .css('z-index','1000').css('background-color','white');
            $("#add_room").css('display','none');
             var siteid = (e.data.context.activeElement.className).split("_")[1];
             //alert(siteid);
            var data = {


                /*  _token: _token.value,*/
                siteid: siteid,
            };
            $.ajax({
                type: "GET",
                url: "getSiteInfo",
                data: data,
                success: function (data) {
                    console.log(data);
                    $("#id").val(data["id"]);
                    var form_controls =$("#update_site > form .input");
                    var name=form_controls[0];
                    $(name).val(data["name"]);
                    var description=form_controls[1];
                    $(description).val(data["description"])
                    var clnCostPH=form_controls[2];
                    $(clnCostPH).val(data["clnCostPH"]);
                    var state=form_controls[3];
                    $(state).val(data["state"]);
                    var city=form_controls[4];
                    $(city).val(data["city"]);
                    var suburb=form_controls[5];
                    $(suburb).val(data["suburb"]);
                    var address=form_controls[6];
                    $(address).val(data["address"])
                    var mobile=form_controls[7];
                    $(mobile).val(data["mobile"])
                    var phone=form_controls[8];
                    $(phone).val(data["phone"])
                    var fax=form_controls[9];
                    $(fax).val(data["fax"]);
                    var supervisor=form_controls[10];
                    $(supervisor).val(data["supervisor"]);
                    var owner=form_controls[11];
                    $(owner).val(data["site_owner"]);
                }
            }, "json");
            e.preventDefault();

        }
        if(action=="addroom") {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_site").css('display', 'none');
            $("#update_site").css('display', 'none');
            $("#add_room").css('display', 'block').css('position', 'absolute')
                .css('top', '75px').css('width', '80%')
                .css('z-index', '1000').css('background-color', 'white');
            var siteid = (e.data.context.activeElement.className).split("_")[1];
            $("#siteid").val(siteid);
            e.preventDefault();
        }
    });
    $(document.body).on('click', '.addsite' ,function() {
        $(".msg").delay(100).fadeOut();
        $(".error").delay(100).fadeOut();
        //$("#add_new_site").css('display','block');
        $("#add_new_site").css('display','block').css('position','absolute')
            .css('top',"75px").css('width','80%')
            .css('z-index','1000').css('background-color','white');
        $("#add_room").css('display','none');
        $("#update_site").css('display','none');
        e.preventDefault();
    });
    $("a[class='adduser']").each(function(index)
    {
        $(this).click(function(e) {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#update_user").css('display','none');
            $("#add_new_user").css('display','block');
            e.preventDefault();
         });
    });
    $("a[class^='updateuser_']").each(function(index)
    {
        $(this).click(function(e) {
            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_user").css('display','none');
            $("#update_user").css('display','block');
            var userid=(this.id).split("_")[1];
            var data = {
              /*  _token: _token.value,*/
                userid: userid,
            };
            $.ajax({
                type: "GET",
                url: "getUserInfo",
                data: data,
                success: function (data) {
                    //console.log(data);
                    $("#id").val(data["id"]);
                    var form_controls =$("#update_user > form .input");
                    var title=form_controls[0];
                    $(title).prop("selectedIndex",data["title"])
                    var fullname=form_controls[1];
                    $(fullname).val(data["fullname"])
                    var email=form_controls[2];
                    $(email).val(data["email"])
                    var accesslevel=form_controls[3];
                    $(accesslevel).prop("selectedIndex",data["accesslevel"])
                    var address=form_controls[4];
                    $(address).val(data["address"])
                    var mobile=form_controls[5];
                    $(mobile).val(data["mobile"])
                    var phone=form_controls[6];
                    $(phone).val(data["phone"])
                    var fax=form_controls[7];
                    $(fax).val(data["fax"]);
                }
            }, "json");
            e.preventDefault();
        });

    });
    $("a[id^='by_']").each(function(index)
    {
        $(this).click(function(e) {
            var sortid=(this.id).split("_")[1];
            window.location.href = '/users?sortby='+sortid;
            /*  $(".msg").delay(100).fadeOut();
              $(".error").delay(100).fadeOut();
              var sortid=(this.id).split("_")[1];
              var data = {
                  /!*  _token: _token.value,*!/
                  sortid: sortid,
              };
              $.ajax({
                  type: "GET",
                  url: "getAllUsers",
                  data: data,
                  success: function (data) {
                      //console.log(data);
                      var source   = $("#users-template").html();
                      var template = Handlebars.compile(source);
                      var context = data;
                      var html= template(context);
                       $('.data-items-viewer').prop('outerHTML',html);
                   }
              }, "json");
              e.preventDefault();*/
        });

    });
    $("a[class^='updatesite']").each(function(index)
    {
        $(this).click(function(e) {

            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_site").css('display','none');
            $("#update_site").css('display','block');
            $("#add_room").css('display','none');

            var siteid=(this.id).split("_")[1];
            var data = {
                /*  _token: _token.value,*/
                siteid: siteid,
            };
            $.ajax({
                type: "GET",
                url: "getSiteInfo",
                data: data,
                success: function (data) {
                     console.log(data);
                    $("#id").val(data["id"]);
                    var form_controls =$("#update_site > form .input");
                    var name=form_controls[0];
                    $(name).val(data["name"]);
                    var description=form_controls[1];
                    $(description).val(data["description"])
                    var clnCostPH=form_controls[2];
                    $(clnCostPH).val(data["clnCostPH"]);
                    var state=form_controls[3];
                    $(state).val(data["state"]);
                    var city=form_controls[4];
                    $(city).val(data["city"]);
                    var suburb=form_controls[5];
                    $(suburb).val(data["suburb"]);
                    var address=form_controls[6];
                    $(address).val(data["address"])
                    var mobile=form_controls[7];
                    $(mobile).val(data["mobile"])
                    var phone=form_controls[8];
                    $(phone).val(data["phone"])
                    var fax=form_controls[9];
                    $(fax).val(data["fax"]);
                    var supervisor=form_controls[10];
                     $(supervisor).val(data["supervisor"]);
                }
            }, "json");
            e.preventDefault();
        });

    });
    $("a[class^='addsite']").each(function(index)
    {
        $(this).click(function(e) {

            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_site").css('display','block');
            $("#update_site").css('display','none');
            $("#add_room").css('display','none');

            e.preventDefault();
        });

    });
    $("a[class^='addroom_']").each(function(index)
    {
        $(this).click(function(e) {

            $(".msg").delay(100).fadeOut();
            $(".error").delay(100).fadeOut();
            $("#add_new_site").css('display','none');
            $("#update_site").css('display','none');
            $("#add_room").css('display','block');
            var siteid=(this.id).split("_")[1];
            $("#siteid").val(siteid);
            e.preventDefault();
        });

    });
    $("#add_service").click(function(){
        var serviceid=$(".service-container").length;
        serviceid=serviceid+1;
         var servicegtype=$("#servicegtype").prop("checked");
        if(servicegtype==true){
            var type=$("#rooms option:selected").val();
            var typemsg=$("#rooms option:selected").text();
            var rst=$.trim($("#room_s").val());
            var rend=$.trim($("#room_e").val());
            var note=$("#service_note").val();
            var service = {
                "serviceid":serviceid,
                "servicegtype":servicegtype,
                "type":type,
                "typemsg":typemsg,
                "rst":rst,
                "rend":rend,
                "note":note
            };
        }
        else {
            var type=$("#rooms option:selected").val();
            var typemsg=$("#rooms option:selected").text();
            var room= $.trim($("#room1").val());
            var note=$.trim($("#service_note").val());
            var service = {
                "serviceid":serviceid,
                "servicegtype":servicegtype,
                "type":type,
                "typemsg":typemsg,
                "room":room,
                "note":note
            };
        }
        error=0;
        error_msg="";
        if(servicegtype==true && (rst.length <1 || rst.rend <1)) {
            error=1;
            error_msg="Please select rooms";
        }
        if(servicegtype==false && room.length <1) {
            error=1;
            error_msg="Please select rooms";
        }
        console.log(error);
        if(error==1){
            $("#service_add_error").text(error_msg);
            $("#service_add_error").fadeIn(2000).fadeOut(1000);
        }
        else {
            var source = $("#clean-service-template").html();
            var template = Handlebars.compile(source);
            var context = service;
            var html = template(context);
            $('#selected-rooms').append(html);
            serviceid=serviceid+1;
        }
       /* if(roomid!=-1 && $.trim(service).length >0)
        {
            var found=false;
            $("#room_services ul li[id^='service_']").each(function(){
              if($(this).prop("id").split("_")[1]==roomid)
                  found=true;
            });
            if(found==true)
            {
                $("#service_add_error > label").text('Room already selected!');
                $("#service_add_error").fadeIn(1000).fadeOut(2000);
            }
            else
            {
                $("#room_services ul").append(
                    "<li id='service_"+roomid+"'>" +
                    "<label id='"+roomid+"'>" + roomname + ":"  + service + "</label> " +
                    "<a href='#'> <img src='img/del.jpg'></a>  </li>");
            }
        }
        else
        {
            $("#service_add_error > label").text('Please select Room and Service!');
            $("#service_add_error").fadeIn(1000).fadeOut(2000);
        }*/

    });
    loadUsersData();
    loadSitesData();
    $(".close").click(function(){
        $(this).closest(".form-content").slideUp(1000);
        $(".msg").delay(100).fadeOut();
        $(".error").delay(100).fadeOut();
        $("table.display").css('display', 'block');
    });
    $("#close-model").click(function(){
         window.location.href = '/addsite';

    });
    $('input[name="identifierFD"]').keyup(function()
    {
        var room=$(this);
        var roompre=$(this).val().trim();
        var siteid=$("#siteid").val();
        if(($(this).val().trim().length >= 1))
        {
            var data = {
                /*  _token: _token.value,*/
                siteid: siteid,
                roompre:roompre
            };
            $(room).autocomplete(
                {
                    source: function(request,response)
                    {
                        $.ajax(
                            {
                                type: "GET",
                                url:'getRooms',
                                data:data,
                                success: function(data)
                                {
                                    response($.map(data, function (item) {
                                        return{
                                            value: item.identifierFD,
                                            label: item.identifierFD + ' (' +item.type + ')',
                                        }
                                    }));
                                }
                            }
                        );
                    },
                    select: function(event) {

                    },
                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
                    },
                }
            )
        }
    });
    $('input[name="room1"]').keyup(function()
    {
        var room=$(this);
        var roompre=$(this).val().trim();
        var siteid=$("#siteid").val();
        if(($(this).val().trim().length >= 1))
        {

            var data = {
                /*  _token: _token.value,*/
                siteid: siteid,
                roompre:roompre
            };
            $(room).autocomplete(
                {
                    source: function(request,response)
                    {
                        $.ajax(
                            {
                                type: "GET",
                                url:'getRooms',
                                data:data,
                                success: function(data)
                                {
                                    response($.map(data, function (item) {
                                        return{
                                            value: item.identifierFD,
                                            label: item.identifierFD + ' (' +item.type + ')',
                                        }
                                    }));
                                }
                            }
                        );
                    },
                    select: function(event) {

                    },
                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
                    },
                    minLength: 0,
                }
            )
        }
    });
    $('input[name="room_s"]').keyup(function()
    {
        var room=$(this);
        var roompre=$(this).val().trim();
        var siteid=$("#siteid").val();
        if(($(this).val().trim().length >= 1))
        {

            var data = {
                /*  _token: _token.value,*/
                siteid: siteid,
                roompre:roompre
            };
            $(room).autocomplete(
                {
                    source: function(request,response)
                    {
                        $.ajax(
                            {
                                type: "GET",
                                url:'getRooms',
                                data:data,
                                success: function(data)
                                {
                                    response($.map(data, function (item) {
                                        return{
                                            value: item.identifierFD,
                                            label: item.identifierFD + ' (' +item.type + ')',
                                        }
                                    }));
                                }
                            }
                        );
                    },
                    select: function(event) {

                    },
                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
                    },
                }
            )
        }
    });
    $('input[name="room_e"]').keyup(function()
    {
        var room=$(this);
        var roompre=$(this).val().trim();
        var siteid=$("#siteid").val();
        if(($(this).val().trim().length >= 1))
        {

            var data = {
                /*  _token: _token.value,*/
                siteid: siteid,
                roompre:roompre
            };
            $(room).autocomplete(
                {
                    source: function(request,response)
                    {
                        $.ajax(
                            {
                                type: "GET",
                                url:'getRooms',
                                data:data,
                                success: function(data)
                                {
                                    response($.map(data, function (item) {
                                        return{
                                            value: item.identifierFD,
                                            label: item.identifierFD + ' (' +item.type + ')',
                                        }
                                    }));
                                }
                            }
                        );
                    },
                    select: function(event) {

                    },
                    open: function(event, ui) {
                        $(".ui-autocomplete").css("z-index", 1000);
                    },
                }
            )
        }
    });
    $("#servicegtype").change(function()
    {
        $room=$("#sel_room");
        $room1=$("#sel_room1");
        $room2=$("#sel_room2");
        if($(this).prop("checked")==true)
        {
            $room.css('display','none');
            $room1.css('display','block');
            $room2.css('display','block');
        }
        else
        {
            $room.css('display','block');
            $room1.css('display','none');
            $room2.css('display','none');
        }
    });
    $("#add_service_link").click(function() {
        $("#add_service_form").slideDown("5000");
    }) ;
    $("a.del_service").click(function() {
       alert('clicked');
    });
    var jobtype=$('input[name=jobtype]');
    $(jobtype).change(function()
    {
        var checked=jobtype.filter(":checked");
        if(checked.val()=="All")
        {
            $(".panel-default").each(function(){
                $(this).css('display','block');
            });
        }
        if(checked.val()=="Submitted")
        {
            $(".panel-default").each(function(){
                $(this).css('display','none');
            });

            $("div[id^=Submitted]").each(function(){
                $(this).parent("div").css('display','block');
             });

        }
        if(checked.val()=="Confirmed")
        {
            $(".panel-default").each(function(){
                $(this).css('display','none');
            });

            $("div[id^=Confirmed]").each(function(){
                $(this).parent("div").css('display','block');
            });
        }
        if(checked.val()=="Edited")
        {
            $(".panel-default").each(function(){
                $(this).css('display','none');
            });

            $("div[id^=Edited]").each(function(){
                $(this).parent("div").css('display','block');
            });
        }
        if(checked.val()=="Finished")
        {
            $(".panel-default").each(function(){
                $(this).css('display','none');
            });

            $("div[id^=Finished]").each(function(){
                $(this).parent("div").css('display','block');
            });
        }
        if(checked.val()=="Reported")
        {
            $(".panel-default").each(function(){
                $(this).css('display','none');
            });

            $("div[id^=Reported]").each(function(){
                $(this).parent("div").css('display','block');
            });
        }

    });

    $("input[name^=hours_]").change(function() {
        nc=$("#ncost").val();
        sc=$("#scost").val();
        ac=$("#acost").val();
        switch($(this).attr('name')) {
            case 'hours_n':
                n_total = $(this).attr('name') + "_t";
                n_val = parseInt($(this).val());
                if (isNaN(n_val))
                    t_val = $("input[name='hours_total']").val("0");
                else {
                    t_n_val = n_val * parseInt(nc);
                    t_n_old_val = $("input[name=" + n_total + "]").val();
                    $("input[name=" + n_total + "]").val(t_n_val);
                    t_val = parseInt($("input[name='hours_total']").val());
                    $("input[name='hours_total']").val(t_val + t_n_val - t_n_old_val);
                }
                break;
            case 'hours_s':
                s_total = $(this).attr('name') + "_t";
                s_val = parseInt($(this).val());
                if (isNaN(s_val))
                    s_val = $("input[name='hours_total']").val("0");
                else {
                    t_s_val = s_val * parseInt(sc);
                    t_s_old_val = $("input[name=" + s_total + "]").val();
                    $("input[name=" + s_total + "]").val(t_s_val);
                    s_val = parseInt($("input[name='hours_total']").val());
                    $("input[name='hours_total']").val(s_val + t_s_val - t_s_old_val);
                }
                break;
            case 'hours_a':
                s_total = $(this).attr('name') + "_t";
                s_val = parseInt($(this).val());
                if (isNaN(s_val))
                    t_val = $("input[name=hours_total]").val("0");
                else {
                    t_s_val = s_val * parseInt(ac);
                    t_s_old_val = $("input[name=" + s_total + "]").val();
                    $("input[name=" + s_total + "]").val(t_s_val);
                    t_val = parseInt($("input[name='hours_total']").val());
                    t_val = $("input[name=hours_total]").val(t_val + t_s_val - t_s_old_val);
                }
                break;
            case 'hours_o':
                s_val = parseInt($(this).val());
                t_val = parseInt($("input[name='hours_total']").val());
                if (isNaN(s_val)) {
                    $(this).val("0");
                    s_val = 0;
                }
                else {
                    //t_e_old_val = $("input[name=" + s_total + "]").val();
                    $("input[name='hours_total']").val(s_val + t_val-t_e_cost);
                }
                break;
        }
        t_e_cost=parseInt($("input[name='hours_o']").val());
    });
});
function updateTotalCost()
{

}
function loadUsersData()
{
    $.getJSON('getAllUsers', function(response) {
        $('#users-table').dataTable({
            data: response,
            destroy: true,
            columns: [
                { data: function(value)
                {
                    return value[0].fullname;
                }},
                { data: function(value)
                {
                    return value[0].email.trim();
                }},
                { data: function(value)
                {
                    return value[0].role.accesslevel;
                }},
                { data: function(value)
                {
                     if(value[0].status==1)
                        return value[0].fullname;
                    else
                        return "<span style='color: red;'> User Blocked </span>"
                }},
                { data: function(value)
                {
                    link="<a href='#' class='adduser'> <img src='/img//add_new_user.jpg'></a>";
                    link=link+"<a href='#' id='deluser_" +value[0].id+ "'class='deleuser_" + value[0].id+  "'> <img src='/img//del_user.jpg'></a>";
                    if(value[0].status==1)
                        link=link+"<a href='#' id='blockuser_" +value[0].id+ "'class='blockuser_" + value[0].id+  "'> <img src='/img//block_user.jpg'></a>";
                    else
                        link=link+"<a href='#' id='unblockuser_" +value[0].id+ "'class='unblockuser_" + value[0].id+  "'> <img src='/img//unblock.jpg'></a>";
                    link=link+"<a href='#' id='updateuser_" +value[0].id+ "'class='updateuser_" + value[0].id+  "'> <img src='/img//update_user.jpg'></a>";

                    //"<a href='#' id='updateuser_"+ value[0].id + "'" + "class='updateuser_" + value[0].id  + "'> <img scr={{url(/img/update_user.jpg)}}/> </a>";
                    return link;
                    /*<a href="#" class={{'blockuser_'.$user->id  }}>{{ Html::image('img/block_user.jpg', 'Add New User ') }} </a>
                     <a href="#" class="adduser">{{ Html::image('img/add_new_user.jpg', 'Block User ') }} </a>""*/
                }},
            ]
        });
        window.someGlobalOrWhatever = response.balance
    });
}
function loadSitesData()
{
    $.getJSON('getAllSites', function(response) {
         $('#sites-table').dataTable({
            data: response,
            destroy: true,
            columns: [
                { data: function(value)
                {
                     return value[0].name;
                }},
                { data: function(value)
                {
                    return value[0].city;
                }},
                { data: function(value)
                {
                    return value[1].fullname;

                }},
                { data: function(value)
                {
                    return "$ "+ value[0].clnCostPH;
                }},
                { data: function(value)
                {
                    link="<a href='#' class='addsite'> <img src='/img/addsite.png'> </a>";
                    link=link+ "<a href='#' id='addroom_"+value[0].id+"' class='addroom_" +value[0].id +"'>" +
                        " <img src='/img/add_room.jpg'> </a>";

                    link=link+"<a id='updatesite_" +value[0].id + "' href='#' class='updatesite_" +value[0].id+ "'>" +
                        " <img src='/img/update_user.jpg'></a>";
                    return link;
                 }}
            ]
        });
        window.someGlobalOrWhatever = response.balance
    });
}
