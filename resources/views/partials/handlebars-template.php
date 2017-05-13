<script id="entry-template" type="text/x-handlebars-template">
    <div class="entry">
        <h1> Raed </h1>
        <h1>{{title}}</h1>
        <div class="body">
            {{body}}
        </div>
    </div>
</script>
<script id="users-template" type="text/x-handlebars-template">
    <table class="data-items-viewer">
        <tbody>
        {{#.}}
        <tr>
        <td style="width: 25%;"> {{fullname}}  </td>

        <td style="width: 40%;"> {{email}}  </td>
            <td style="width: 15%;"> {{accesslevel}} </td>
            <td style="width: 20%;">
                <a href='#'  id=updateuser_{{this.id}}  class='updateuser_{{this.id}}' >
                    <img src="../img/update_user.jpg" alt="Edit User"/>
                </a>
                <a href="#" id="blockuser_{{id}}" class="blockuser_{{id}}">
                    <img src="../img/block_user.jpg" alt="Block User"/>
                </a>
                <a href="#" class="adduser">
                    <img src="../img/add_new_user.jpg" alt="Add User"/>
                </a>
            </td>
        </tr>
     {{/.}}
        </tbody>
    </table>
</script>
<script id="clean-service-template" type="text/x-handlebars-template">
            <div style="border-radius: 10px; border: grey 1px solid;" class="service-container">
             <div class="panel panel-default" style="float:right; width:100%;">
                <input name="serviceid_{{serviceid}}" type="hidden" value={{serviceid}} />
                <input name="servicegtype_{{serviceid}}" type="hidden" value={{servicegtype}}>
                <input name="servicetype_{{serviceid}}" type="hidden" value={{type}}>
                <input name="room_{{serviceid}}" type="hidden" value={{room}}>
                <input name="rmst_{{serviceid}}" type="hidden" value={{rst}}>
                <input name="rend_{{serviceid}}" type="hidden" value={{rend}}>
                <input name="snote_{{serviceid}}" type="hidden" value={{note}}>

                <div class="panel-heading">
                    <span style="display:block; width: 100%; color:white;"> Rooms
                      {{#if room }} ({{room}}) {{/if}}
                      {{#if rst }}  ({{rst}} : {{rend}}) {{/if}}
                    </span>
               </div>
                    <div class="panel-body" style="display: block; font-size: 1.4em; color:white; padding:10px;">
                    <span style="display:block; width: 100%; color:white;"> {{typemsg}} </span>
                    <span style="display:block; width: 100%; color:darkred; margin-top: 5px;">   {{ note}} </span>
                     </div>
            </div>
             <div class="field-wrap">
                 <div>
                     <label style="font-weight: bold; color:#2b2b2b">
                         Delete Service
                     </label>
                     <a href="#" class="delservice" name="delservice_"  ><img src='img/del.jpg' alt="Logo"> </a>
                 </div>
             </div>
            </div>
</script>


