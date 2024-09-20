<script>
    $("document").ready(function(){
        
        //Dispaly Home Notification
        <?php echo $homemsg; ?>
        
        $("#thetranspin").val(null);

        $("#hideEye").click(function(){
            $("#hideEyeDiv").show(); $("#openEyeDiv").hide();
            $("#openEye").show(); $("#hideEye").hide();
        });

        $("#openEye").click(function(){
            $("#openEyeDiv").show(); $("#hideEyeDiv").hide();
            $("#hideEye").show(); $("#openEye").hide();
        });

        $(".the-submit-form").submit(function(){
            $('.the-form-btn').removeClass("gradient-highlight");
            $('.the-form-btn').addClass("btn-secondary");
            $('.the-form-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
        });

        
        
        //Update Profile Password
        $("#passForm").submit(function(e){
            e.preventDefault();

            if($("#new-pass").val() != $("#retype-pass").val()){
                swal("Error!","New Password & Retype Password Don't Match.","error");
                return 0;
            }

            $('#update-pass-btn').removeClass("gradient-highlight");
            $('#update-pass-btn').addClass("btn-secondary");
            $('#update-pass-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');
            
            
            $.ajax({
                url:'home/includes/route.php?update-pass',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    
                    if(resp == 0){
                        swal('Alert!!',"Password Updated Successfully.","success");
                        $("#old-pass").val("");
                        $("#new-pass").val("");
                        $("#retype-pass").val("");
                    }
                    else if(resp == 1){
                        swal('Alert!!',"Old Password Is Incorrect.","error");
                        $("#old-pass").val("");
                        $("#new-pass").val("");
                        $("#retype-pass").val("");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                    $('#update-pass-btn').removeClass("btn-secondary");
                    $('#update-pass-btn').addClass("gradient-highlight");
                    $('#update-pass-btn').html("Update Password");

                }
            });

        });

        //Update Transaction Pin
        $("#pinForm").submit(function(e){
            e.preventDefault();

            if($("#new-pin").val() != $("#retype-pin").val()){
                swal("Error!","New Pin & Retype Pin Don't Match.","error");
                return 0;
            }

            if($("#old-pin").val().length < 4){$(this).val(null); swal("Opps!!","Pin Length Should Be Four Digits.","info"); return;}
            if($("#new-pin").val().length < 4){$(this).val(null); swal("Opps!!","Pin Length Should Be Four Digits.","info"); return;}
            if($("#retype-pin").val().length < 4){$(this).val(null); swal("Opps!!","Pin Length Should Be Four Digits.","info"); return;}

            $('#update-pin-btn').removeClass("gradient-highlight");
            $('#update-pin-btn').addClass("btn-secondary");
            $('#update-pin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating ...');
            
            
            $.ajax({
                url:'home/includes/route.php?update-pin',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    
                    if(resp == 0){
                        swal('Alert!!',"Pin Updated Successfully.","success");
                        $("#old-pin").val("");
                        $("#new-pin").val("");
                        $("#retype-pin").val("");
                    }
                    else if(resp == 1){
                        swal('Alert!!',"Old Pin Is Incorrect.","error");
                        $("#old-pin").val("");
                        $("#new-pin").val("");
                        $("#retype-pin").val("");
                    }
                    else{
                        swal('Alert!!',"Unknow Error, Please Contact Our Customer Support","error");
                    }

                    $('#update-pin-btn').removeClass("btn-secondary");
                    $('#update-pin-btn').addClass("gradient-highlight");
                    $('#update-pin-btn').html("Update Pin");

                }
            });

        });

        $("#old-pin").on("keyup",function(){
            if(isNaN($(this).val())){$(this).val(null); swal("Opps!!","Please Enter A Numeric Value.","info"); }
        });

        $("#new-pin").on("keyup",function(){
            if(isNaN($(this).val())){$(this).val(null); swal("Opps!!","Please Enter A Numeric Value.","info"); }
        });

        $("#retype-pin").on("keyup",function(){
            if(isNaN($(this).val())){$(this).val(null); swal("Opps!!","Please Enter A Numeric Value.","info"); }
        });

        
        // ----------------------------------------------------------------------------
        // Airtime Management
        // ----------------------------------------------------------------------------

        $("#transpinbtn").click(function(){
            let actionbtn = $(this).attr("action-btn");
            $("#transkey").val($("#thetranspin").val());
            $("#"+actionbtn).click();
        });

        $("#networktype").on("change",function(){
            $("#airtimeamount").val(null);
            $("#amounttopay").val(null);
            $("#discount").val(null);
        });

        $("#airtimeamount").on("keyup",function(){
            var airtimediscount = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
            if(!airtimediscount == ""){airtimediscount=JSON.parse(airtimediscount); }
            var amounttopay=0;
            var discount=0;
            var useraccount = getCookie("loginAccount");
            useraccount=useraccount.replace(/%3D/g,"=");
            useraccount=atob(useraccount);
            useraccount = parseInt(useraccount);
            
            var amount = $("#airtimeamount").val();
            amount = parseInt(amount);
            
            if($("#networkid").val() == "" || $("#networkid").val() == null){
                swal("Opps!!","Please Select A Network First.","info");
                $("#airtimeamount").val(null);
                return 0;
            }

            for (i=0; i< airtimediscount.length; i++){
                if(airtimediscount[i].aNetwork == $("#networkid").val() && airtimediscount[i].aType == $("#networktype").val()){
                    if(useraccount == 3 || useraccount =='3'){discount=airtimediscount[i].aVendorDiscount;}
                    else if(useraccount == 2 || useraccount =='2'){discount=airtimediscount[i].aAgentDiscount;}
                    else{discount=airtimediscount[i].aUserDiscount;}
                    discount=parseInt(discount);
                    amounttopay=(amount * discount)/100;
                    discount=100 - discount;
                }
            }

            $("#amounttopay").val(amounttopay);
            $("#discount").val(discount+"%");

        });


        //Purchase Airtime
        $("#airtimeForm").submit(function(e){
           

            if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
                e.preventDefault();
                $("#transpinbtn").attr("action-btn","airtime-btn");
                
                let msg = "You are about to purchase an ";
                msg+='"'+$('#networkid').find(":selected").attr('networkname') + '"' + " airtime of ";
                msg+='"' + $("#airtimeamount").val() + '"' + " for the phone number " + '"' + $("#phone").val() +'"';
                msg+=" <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#airtime-btn').removeClass("gradient-highlight");
            $('#airtime-btn').addClass("btn-secondary");
            $('#airtime-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
        });

        // ----------------------------------------------------------------------------
        // Cable Plan Management
        // ----------------------------------------------------------------------------

        //If provider selected, get plans
        $("#cableid").on("change",function(){
            if($("#cableid").val() == '' || $("#cableid").val() == null){
                swal("Opps!!","Please Select A Provider First.","info"); 
            }
            else{
                let provider = $("#cableid").val();
                let useraccount = getCookie("loginAccount");
                let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                let options = "<option value=''>Select Plan</option>";
                let price = 0;

                useraccount=useraccount.replace(/%3D/g,"=");
                useraccount=atob(useraccount);
                useraccount = parseInt(useraccount);

                if(!plans == ""){
                    
                    plans=JSON.parse(plans); 
                   
                    for(i=0; i < plans.length; i++){
                        
                        if(useraccount == 3 || useraccount =='3'){price = plans[i].vendorprice;}
                        else if(useraccount == 2 || useraccount =='2'){price = plans[i].agentprice;}
                        else{price = plans[i].userprice; }

                        if(plans[i].cableprovider == provider){
                            options+= "<option value='"+plans[i].cpId+"' cableprice='"+price+"' planname='"+plans[i].name+" (N"+plans[i].price+")("+plans[i].day+" Days) '>"+plans[i].name+" (N"+plans[i].price+")("+plans[i].day+" Days) </option>";
                        }
        
                    }

                }

                $("#cableplan").html(options);
                $("#amounttopay").val(null);
               
            }
        });

        //If Cable Plan Is Selected, Get And Set The Price
        $("#cableplan").on("change",function(){
            $("#amounttopay").val("N"+$('#cableplan').find(":selected").attr('cableprice'));
            $("#cabledetails").val($('#cableplan').find(":selected").attr('planname'));
        });

        //Verify cableplan
        $("#verifycableplanForm").submit(function(e){
           
           $('#cable-btn').removeClass("gradient-highlight");
           $('#cable-btn').addClass("btn-secondary");
           $('#cable-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

       //Purchase Cable Plan
       $("#cableplanForm").submit(function(e){
           

           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","cable-btn");
               
               let msg = "You are about to purchase ";
               let cableplan = $('#cabledetails').val();
               msg+='"'+cableplan+" for the IUC Number " + '"' + $("#iucnumber").val() +'"';
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#cable-btn').removeClass("gradient-highlight");
           $('#cable-btn').addClass("btn-secondary");
           $('#cable-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

        // ----------------------------------------------------------------------------
        // Recharge Card Pin Management
        // ----------------------------------------------------------------------------
        
        //If Network selected, get plans
        $("#airtimepin-networkid").on("change",function(){
            if($("#airtimepin-networkid").val() == '' || $("#airtimepin-networkid").val() == null){
                swal("Opps!!","Please Select A Network First.","info"); 
            }
            else{
                let network = $("#airtimepin-networkid").val();
                 let useraccount = getCookie("loginAccount");
                let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                let options = "<option value=''>Select Amount</option>";
                let price = 0;
                let networkname = $('#airtimepin-networkid').find(":selected").attr('networkname');

                
                useraccount=useraccount.replace(/%3D/g,"=");
                useraccount=atob(useraccount);
                useraccount = parseInt(useraccount);

                if(!plans == ""){
                    
                    plans=JSON.parse(plans); 
                
                    for(i=0; i < plans.length; i++){
                        
                        if(useraccount == 3 || useraccount =='3'){price = plans[i].aVendorPrice;}
                        else if(useraccount == 2 || useraccount =='2'){price = plans[i].aAgentPrice;}
                        else{price = plans[i].aUserPrice; }

                        if(plans[i].aNetwork == network){
                            options+= "<option value='"+plans[i].aId+"' price='"+price+"' amount='"+plans[i].planSize+"'>"+plans[i].planSize+"</option>";
                        }
        
                    }

                }

                $("#airtimepin-amount").html(options);
                $("#amounttopay").val(null);
               
            }
        });

        //If Airtime Pin Plan Is Selected, Get And Set The Price
        $("#airtimepin-amount").on("change",function(){
             let networkname = $('#airtimepin-networkid').find(":selected").attr('networkname');
            $("#amounttopay").val("N"+$('#airtimepin-amount').find(":selected").attr('price'));
            $("#available-pins").html($("#"+networkname+$('#airtimepin-amount').find(":selected").attr('amount')+"pins").html());
             $("#available-pins").show();
        });
        
        $("#airtimepin-quantity").on("keyup",function(){
       
           if($("#airtimepin-networkid").val() == '' || $("#airtimepin-networkid").val() == null){
               swal("Opps!!","Please Select A Network First.","info"); 
                $("#airtimepin-quantity").val(null);
           }
           else if($("#airtimepin-amount").val() == '' || $("#airtimepin-amount").val() == null){
               swal("Opps!!","Please Select A An Amount First.","info"); 
                $("#airtimepin-quantity").val(null);
           }
           else{
               let price = parseInt($('#airtimepin-amount').find(":selected").attr('price'));
               let quantity = parseInt($("#airtimepin-quantity").val());
               let amounttopay = 0;
               if(quantity > 0){ amounttopay = price * quantity; }
               else{swal("Alert!!","Please Enter A Valid Quantity","error"); }
               $("#amounttopay").val("N"+amounttopay);
           }
          
       });

        //Purchase Exam Pin
       $("#rechargepinForm").submit(function(e){
           
           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","rechargepin-btn");
               
               let msg = "You are about to purchase ";
               msg+=$("#airtimepin-quantity").val()+' unit of N'+$('#airtimepin-amount').find(":selected").attr('amount')+' ';
               msg+=$('#airtimepin-networkid').find(":selected").attr('networkname')+" recharge card pin at the price of "+$("#amounttopay").val()+" with the card name "+$("#businessname").val();
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#rechargepin-btn').removeClass("gradient-highlight");
           $('#rechargepin-btn').addClass("btn-secondary");
           $('#rechargepin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

        // ----------------------------------------------------------------------------
        // Exam Pin Management
        // ----------------------------------------------------------------------------

        $("#examid").on("change",function(){
            $("#amounttopay").val(null);
            $("#examquantity").val(null);
        });

        $("#examquantity").on("keyup",function(){
            
            if($("#examid").val() != null || $("#examquantity").val() != null){
                let price = parseInt($('#examid').find(":selected").attr('providerprice'));
                let quantity =parseInt($("#examquantity").val());
                let amount = 0;
                
                if(!(quantity > 0)){quantity=0;}
                if(!(price > 0)){price=0;}

                amount = price * quantity;

                $("#amounttopay").val("N"+amount);
            }
            else{$("#amounttopay").val("0");}

        });

        //Purchase Exam Pin
       $("#exampinForm").submit(function(e){
           
           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","exampin-btn");
               
               let msg = "You are about to purchase ";
               let exampindetails = $('#examid').find(":selected").attr('providername');
               msg+=$("#examquantity").val()+' token of  '+exampindetails+' ';
               msg+=" pin at the price of "+$("#amounttopay").val();
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#exampin-btn').removeClass("gradient-highlight");
           $('#exampin-btn').addClass("btn-secondary");
           $('#exampin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });


        // ----------------------------------------------------------------------------
        // Electricity Management
        // ----------------------------------------------------------------------------

        //If Amount Input, Get And Set The Price
        $("#meteramount").on("keyup",function(){
            let amount = parseInt($('#meteramount').val());
            let electricitycharges = parseInt($('#electricitycharges').text());
            let amounttopay = amount + electricitycharges;
            $("#amounttopay").val("N"+amounttopay);
            $("#electricitydetails").val($('#electricityid').find(":selected").attr('providername'));
        });

        $("#verifyelectricityplanForm").submit(function(e){
           let amount= parseInt($('#meteramount').val());
           
           if(amount < 1000){
            e.preventDefault();
            swal("Alert!!","Minimum Unit Purchase Is N1000.","error");
            return null;
           }

           $('#electricity-btn').removeClass("gradient-highlight");
           $('#electricity-btn').addClass("btn-secondary");
           $('#electricity-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

       //Purchase Electricity Plan
       $("#electricityForm").submit(function(e){
           

           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","electricity-btn");
               
               let msg = "You are about to purchase ";
               let electricitydetails = $('#electricitydetails').val();
               msg+='"'+electricitydetails+" ("+$("#metertype").val()+") for the Meter Number " + '"' + $("#meternumber").val() +'"';
               msg+=" at the price of "+$("#amounttopay").val();
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#electricity-btn').removeClass("gradient-highlight");
           $('#electricity-btn').addClass("btn-secondary");
           $('#electricity-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

        // ----------------------------------------------------------------------------
        // Data Plan Management
        // ----------------------------------------------------------------------------

        //If  notwork selected, empty data type, plan, amount
        $("#networkid").on("change",function(){
            $("#datagroup").val(null);
            $("#dataplan").val(null);
            $("#amounttopay").val(null);

            let sme = $('#networkid').find(":selected").attr('sme');
            let sme2 = $('#networkid').find(":selected").attr('sme2');
            let gifting = $('#networkid').find(":selected").attr('gifting');
            let corporate = $('#networkid').find(":selected").attr('corporate');
            let coupon = $('#networkid').find(":selected").attr('coupon');
            let vtu = $('#networkid').find(":selected").attr('vtu');
            let sharesell = $('#networkid').find(":selected").attr('sharesell');
            let momo = $('#networkid').find(":selected").attr('momo');
            let networkname = $('#networkid').find(":selected").attr('networkname');
            let thegroup='<option value="">Select Type</option>';

                //Check If Network Is Disabled
                if(sme=="On"){
                    thegroup+='<option value="SME">SME</option>';
                } 
                
                 //Check If Network Is Disabled
                if(sme2=="On"){
                    thegroup+='<option value="SME2">SME2</option>';
                } 
                
                //Check If Network Is Disabled
                if(coupon=="On"){
                   thegroup+='<option value="Coupon">Coupon</option>';
                }


                //Check If Network Is Disabled
                if(gifting=="On"){
                   thegroup+='<option value="Gifting">Gifting</option>';
                }

                //Check If Network Is Disabled
                if(corporate=="On"){
                   thegroup+='<option value="Corporate">Corporate</option>';
                }

                //Check If Network Is Disabled
                if(vtu=="On"){
                   thegroup+='<option value="VTU">VTU</option>';
                }

                //Check If Network Is Disabled
                if(sharesell=="On"){
                   thegroup+='<option value="Share And Sell">Share And Sell</option>';
                }

                //Check If Network Is Disabled
                if(momo=="On"){
                   thegroup+='<option value="Momo">Momo Airtime</option>';
                }

                $("#datagroup").html(thegroup);
                $("#networktype").html(thegroup);
        });

        //If data type selected, get plans
        $("#datagroup").on("change",function(){
            if($("#networkid").val() == '' || $("#networkid").val() == null){
                swal("Opps!!","Please Select A Network First.","info"); 
            }
            else{
                let network = $("#networkid").val();
                let datagroup = $("#datagroup").val();
                let useraccount = getCookie("loginAccount");
                let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
                let options = "<option value=''>Select Plan</option>";
                let price = 0;
                let networkname = $('#networkid').find(":selected").attr('networkname');

                
                useraccount=useraccount.replace(/%3D/g,"=");
                useraccount=atob(useraccount);
                useraccount = parseInt(useraccount);

                if(!plans == ""){
                    
                    plans=JSON.parse(plans); 
                
                    for(i=0; i < plans.length; i++){
                        
                        if(useraccount == 3 || useraccount =='3'){price = plans[i].vendorprice;}
                        else if(useraccount == 2 || useraccount =='2'){price = plans[i].agentprice;}
                        else{price = plans[i].userprice; }

                        if(plans[i].datanetwork == network && plans[i].type == datagroup){
                            options+= "<option value='"+plans[i].pId+"' dataprice='"+price+"' dataname='"+plans[i].name+" "+plans[i].type+" (N"+price+")("+plans[i].day+" Days) '>"+plans[i].name+" "+plans[i].type+" (N"+price+")("+plans[i].day+" Days)</option>";
                        }
        
                    }

                }

                $("#dataplan").html(options);
                $("#amounttopay").val(null);
               
            }
        });

        //If Data Plan Is Selected, Get And Set The Price
        $("#dataplan").on("change",function(){
            $("#amounttopay").val("N"+$('#dataplan').find(":selected").attr('dataprice'));
        });

        //Purchase Data
        $("#dataplanForm").submit(function(e){
           

           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","data-btn");
               
               let msg = "You are about to purchase ";
               let dataplan = $('#dataplan').find(":selected").attr('dataname');
               msg+='"'+$('#networkid').find(":selected").attr('networkname') + '" ' + dataplan +" plan of ";
               msg+='"' + $("#amounttopay").val() + '"' + " for the phone number " + '"' + $("#phone").val() +'"';
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#data-btn').removeClass("gradient-highlight");
           $('#data-btn').addClass("btn-secondary");
           $('#data-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

       // ----------------------------------------------------------------------------
       // Data Pin
       // ----------------------------------------------------------------------------

       //If data type selected, get plans
       $("#datapingroup").on("change",function(){
           
           if($("#datanetworkid").val() == '' || $("#datanetworkid").val() == null){
               swal("Opps!!","Please Select A Network First.","info"); 
               return 0;
           }
           
           let network = $("#datanetworkid").val();
           let datagroup = $("#datapingroup").val();
           let useraccount = getCookie("loginAccount");
           let plans = '<?php echo (!empty($data2) && is_string($data2)) ? $data2 : ""; ?>';
           let options = "<option value=''>Select Plan</option>";
           let price = 0;
           let networkname = $('#datanetworkid').find(":selected").attr('networkname');
           

           useraccount=useraccount.replace(/%3D/g,"=");
           useraccount=atob(useraccount);
           useraccount = parseInt(useraccount);

           if(!plans == ""){
               
               plans=JSON.parse(plans); 
           
               for(i=0; i < plans.length; i++){
                   
                   if(useraccount == 3 || useraccount =='3'){price = plans[i].vendorprice;}
                   else if(useraccount == 2 || useraccount =='2'){price = plans[i].agentprice;}
                   else{price = plans[i].userprice; }

                   if(plans[i].datanetwork == network && plans[i].type == datagroup){
                       options+= "<option value='"+plans[i].dpId+"' dataprice='"+price+"' dataname='"+plans[i].name+" "+plans[i].type+" (N"+price+")("+plans[i].day+" Days) '>"+plans[i].name+" "+plans[i].type+" (N"+price+")("+plans[i].day+" Days)</option>";
                   }
   
               }

           }

           $("#datapinplan").html(options);
           $("#amount").val(null);
           $("#amounttopay").val(null);


   });

   //If Data Plan Is Selected, Get And Set The Price
   $("#datapinplan").on("change",function(){
       $("#amount").val($('#datapinplan').find(":selected").attr('dataprice'));
   });

   $("#datapinquantity").on("change",function(){
       
       if($("#datanetworkid").val() == '' || $("#datanetworkid").val() == null){
           swal("Opps!!","Please Select A Network First.","info"); 
       }
       else{
           let price = parseInt($("#amount").val());
           let quantity = parseInt($("#datapinquantity").val());
           let amounttopay = 0;
           if(quantity > 0){ amounttopay = price * quantity; }
           else{swal("Alert!!","Please Enter A Valid Quantity","error"); }
           $("#amounttopay").val("N"+amounttopay);
       }
      
   });

   //Purchase Data Pin
   $("#datapinForm").submit(function(e){
      

      if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
          e.preventDefault();
          $("#transpinbtn").attr("action-btn","datapin-btn");
          
          let dataplan = $('#datapinplan').find(":selected").attr('dataname');
          let msg = "You are about to purchase " + $("#datapinquantity").val()+" data pin of ";
         
          msg+='"'+$('#datanetworkid').find(":selected").attr('networkname') + '" ' + dataplan +" plan at ";
          msg+='"' + $("#amounttopay").val() + '"' + " with business name " + '"' + $("#businessname").val() +'"';
          msg+=" <br/> Do you wish to continue?"

          $("#continue-transaction-prompt-msg").html(msg);
          $("#continue-transaction-prompt-btn").click();

          return;
      }

      $('#datapin-btn').removeClass("gradient-highlight");
      $('#datapin-btn').addClass("btn-secondary");
      $('#datapin-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
      
  });



        // ----------------------------------------------------------------------------
        // Wallet Management
        // ----------------------------------------------------------------------------


        $("#transfertype").on("change",function(){
            if($(this).val() == "wallet-wallet"){
                $("#walletreceiver").show();
                $("#walletreceiverinput").attr("required","required");
            }else{$("#walletreceiver").hide();  $("#walletreceiverinput").removeAttr("required");}
            $("#amounttopay").val("N0.00");
        });

        $("#wallettransferamount").on("keyup",function(){
            let amount = parseInt($('#wallettransferamount').val());
            let charges = parseInt($('#wallettowalletcharges').text());
            if($("#transfertype").val() == "wallet-wallet"){amounttopay = amount+charges;} else{amounttopay = amount+0;}
            $("#amounttopay").val("N"+amounttopay);
        });

        //Submit Transfer Request
        $("#transferForm").submit(function(e){
           
           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","transfer-btn");
               
               let msg = "You are about to perform a  ";
               let action ="Wallet To Wallet";
            
               if($("#transfertype").val() == 'referral-wallet'){action ="Referal To Wallet Transfer"; receiver="your main wallet.";}
               else {action ="Wallet To Wallet Transfer"; receiver=$("#walletreceiverinput").val();}
               
               msg+=action+" of N"+$('#wallettransferamount').val()+ " to "+receiver;
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#transfer-btn').removeClass("gradient-highlight");
           $('#transfer-btn').addClass("btn-secondary");
           $('#transfer-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
        });

        // ----------------------------------------------------------------------------
        // Contact Page Management
        // ----------------------------------------------------------------------------

        //Send Contact Message
        $("#message-form").submit(function(e){
            e.preventDefault();

            $('#message-btn').removeClass("gradient-highlight");
            $('#message-btn').addClass("btn-secondary");
            $('#message-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending ...');
            
            
            $.ajax({
                url:'home/includes/route.php?save-message',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success:function(resp){
                    
                    if(resp == 0){
                        swal('Alert!!',"Message Sent Successfully, We Would Get Back To You Soon.","success");
                        $("#message-form")[0].reset();
                    }
                    else{
                        swal('Alert!!',"Unexpected Error, Please Contact Our Customer Support Team.","error");
                    }

                    $('#message-btn').removeClass("btn-secondary");
                    $('#message-btn').addClass("gradient-highlight");
                    $('#message-btn').html("Send Message");

                }
            });

        });

        // ----------------------------------------------------------------------------
        // Alpha Topup Management
        // ----------------------------------------------------------------------------
		
		//If Alpha Plan Is Selected, Get And Set The Price
        $("#alphaplan").on("change",function(){
        let useraccount = getCookie("loginAccount");
           useraccount=useraccount.replace(/%3D/g,"=");
           useraccount=atob(useraccount);
           useraccount = parseInt(useraccount);

            if(useraccount == 3){$("#amounttopay").val("N"+$('#alphaplan').find(":selected").attr('vendor'));}
            if(useraccount == 2){$("#amounttopay").val("N"+$('#alphaplan').find(":selected").attr('agent'));}
            else{$("#amounttopay").val("N"+$('#alphaplan').find(":selected").attr('user'));}
        });
		
		//Purchase Alpha Plan
        $("#alphaplanForm").submit(function(e){
           

           if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
               e.preventDefault();
               $("#transpinbtn").attr("action-btn","alpha-plan-btn");
               
               let msg = "You are about to purchase ";
               let dataplan = $('#alphaplan').find(":selected").attr('plan');
               msg+= dataplan + " Alpha Topup at " + $("#amounttopay").val() + " for the phone number " + '"' + $("#phone").val() +'"';
               msg+=" <br/> Do you wish to continue?"

               $("#continue-transaction-prompt-msg").html(msg);
               $("#continue-transaction-prompt-btn").click();

               return;
           }

           $('#alpha-plan-btn').removeClass("gradient-highlight");
           $('#alpha-plan-btn').addClass("btn-secondary");
           $('#alpha-plan-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
           
       });

       /* Smile Data -----------------------------------------------------------------*/
        
       $('.smile-act').hide();
        $('.smile-phonet').hide();
        $('.smile-phone').hide();
        
        //If Data Plan Is Selected, Get And Set The Price
        $("#smiledataplan").on("change",function(){
            let per = parseInt($("#smilediscount").val());
            let amount =  parseInt($('#smiledataplan').find(":selected").attr('dataprice'));
            let discount = (amount * per) / 100;
            $("#smileamounttopay").val("N"+discount);
        });
        
        $('#actype').change(function(){
            $(".smile-phone").removeAttr("pattern");
            $('.smile-phone').removeAttr('maxlength');
            $('.smile-phone').removeAttr('minlength');
            $(".smile-phone").val("");
          
            if($(this).val() == 'PhoneNumber'){
                $('.smile-phone').show();
                 $('.smile-phonet').show();
                $('.smile-phone').attr('required', true);
                 $('.smile-phone').removeAttr('maxlength');
                 $('.smile-phone').removeAttr('minlength');
                $('.smile-phone').attr('pattern', '^234[0-9]{10}$');
                $('.smile-phone').attr('minlength', '13');
                $('.smile-phone').attr('maxlength', '13');
                $(".smile-phone").val("234");
                 $('.smile-act').hide();
            }
            else if($(this).val() == 'AccountNumber'){
                $('.smile-act').show();
                $('smile-phone').attr('required', true);
                $('.smile-phone').attr('minlength', '10');
                $('.smile-phone').attr('maxlength', '10');
                $('.smile-phone').show();
                $(".smile-phone").removeAttr("pattern");
                
                 $('.smile-phonet').hide();
            }
            else {
                $('.smile-act').hide();
                $('.smile-phone').hide();
            }
        });
    
        //Purchase Smile Data
        $("#smiledataplanForm").submit(function(e){
               
    
               if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
                   e.preventDefault();
                   $("#transpinbtn").attr("action-btn","data-btn");
                   
                   let msg = "You are about to purchase ";
                   let dataplan = $('#smiledataplan').find(":selected").attr('dataname');
                   msg+='"'+$('#smiledataplan').find(":selected").attr('networkname') + '" ' + dataplan; // +" plan of ";
                   //msg+='"' + $("#smileamounttopay").val() + '"' + " for the phone number " + '"' + $("#phone").val() +'"';
                  // msg+=" <br/> Do you wish to continue?"
    
                   $("#continue-transaction-prompt-msg").html(msg);
                   $("#continue-transaction-prompt-btn").click();
    
                   return;
               }
    
               $('#data-btn').removeClass("gradient-highlight");
               $('#data-btn').addClass("btn-secondary");
               $('#data-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
               
        });

      


       //Airtime To Cash Start ...................................................................................................
        
        //Show Airtime Transfer Details
        $("#airtimetocashnetwork").on("change",function(){
            $network = $("#airtimetocashnetwork").val();
            if($network == "MTN"){$("#AIRTELCodeBox").hide(); $("#GLOCodeBox").hide(); $("#9MobileCodeBox").hide(); $("#MTNCodeBox").show(); }
            if($network == "GLO"){$("#AIRTELCodeBox").hide(); $("#MTNCodeBox").hide(); $("#9MobileCodeBox").hide(); $("#GLOCodeBox").show(); }
            if($network == "9MOBILE"){$("#AIRTELCodeBox").hide(); $("#GLOCodeBox").hide(); $("#MTNCodeBox").hide(); $("#9MobileCodeBox").show(); }
            if($network == "AIRTEL"){$("#9MobileCodeBox").hide(); $("#GLOCodeBox").hide(); $("#MTNCodeBox").hide(); $("#AIRTELCodeBox").show(); }
        });
        
        //Set Airtime Amount Rate
        $("#airtimetocashamount").on("keyup",function(){
            
             if($("#airtimetocashnetwork").val() == "" || $("#airtimetocashnetwork").val() == null){
                swal("Opps!!","Please Select A Network First.","info");
                $("#airtimetocashamount").val(null);
                return 0;
            }
            else{
                $amount = parseInt($("#airtimetocashamount").val());
                $per =  parseInt($('#airtimetocashnetwork').find(":selected").attr('providerrate'));
                $amounttopay = ($amount * $per)/100;
                $("#amounttopay").val("N"+$amounttopay);
                
            }
            
        });
        
        //Submit Airtime To Cash Request
        $("#airtimetocashform").submit(function(e){
           

            if($("#thetranspin").val() == null || $("#thetranspin").val() == ''){
                e.preventDefault();
                $("#transpinbtn").attr("action-btn","airtimetocash-btn");
                
                let msg = "You are about to submit an Airtime To Cash request of ";
                msg+='"N' + $("#airtimetocashamount").val() + '"' + " from phone number " + '"' + $("#airtimetocashphone").val() +'"';
                msg+=" <br/> Do you wish to continue?"

                $("#continue-transaction-prompt-msg").html(msg);
                $("#continue-transaction-prompt-btn").click();

                return;
            }

            $('#airtimetocash-btn').removeClass("gradient-highlight");
            $('#airtimetocash-btn').addClass("btn-secondary");
            $('#airtimetocash-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Processing ...');
            
        });
        
        //Airtime To Cash END .....................................................................................................
        
        // ----------------------------------------------------------------------------
        // Manual Fund Management
        // ----------------------------------------------------------------------------
    
        //Manul Fund Request
        $("#manualfundform").submit(function(e){
                e.preventDefault();
    
                $('#manual-fund-btn').removeClass("gradient-highlight");
                $('#manual-fund-btn').addClass("btn-secondary");
                $('#manual-fund-btn').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending ...');
                
                
                $.ajax({
                    url:'home/includes/route.php?manual-fund-request',
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    success:function(resp){
                        
                        if(resp == 0){
                            swal('Alert!!',"Funding Request Sent Successfully, Your Account Would Be Credited In Due Time.","success");
                            $("#manualfundform")[0].reset();
                        }
                        else{ swal('Alert!!',"Unexpected Error, Please Contact Our Customer Support Team."+resp,"error"); }
    
                        $('#manual-fund-btn').removeClass("btn-secondary");
                        $('#manual-fund-btn').addClass("gradient-highlight");
                        $('#manual-fund-btn').html("Send Funding Request");
    
                    }
                });
    
        });
        

      
    });


    function copyToClipboard(url){
              var $temp=$("<input>");
              $("body").append($temp);
              $temp.val(url).select();
              document.execCommand("copy");
              $temp.remove();
              swal("Success!!","Copied To Clipboard Successfully","success");
    }

    function calculatePaystackCharges(){
        let charges = $("#paystackcharges").val();
        let amount = $("#amount").val();
        amount = parseInt(amount);
        charges = parseFloat(charges);

        if(amount > 2500){
            let amounttopay = amount;
            let discount= 0;

            discount = ((amount * charges)/100) + 100;
            amounttopay = amount - discount;

            $("#amounttopay").val("N"+amounttopay);
            $("#charges").val("N"+discount);
        }
        else{
            let amounttopay = amount;
            let discount= 0;

            discount = (amount * charges)/100;
            amounttopay = amount - discount;

            $("#amounttopay").val("N"+amounttopay);
            $("#charges").val("N"+discount);
        }

    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    }
    
    function verifyNetwork(){
        var selNetwork=$('#networkid').find(":selected").attr('networkname');
        var verNetwork="";
        var phoneT = document.getElementById('phone').value;
        var phoneStr = phoneT.substr(0,4);
        
        if(phoneT==="" || phoneT.length<6)
        {
            document.getElementById('verifyer').innerHTML = "";
        }
        else{
        if(/0702|0704|0803|0806|0703|0706|0813|0816|0810|0814|0903|0906|0913|0916/.test(phoneStr))
        {
            verNetwork="MTN";
        }
        else if(/0805|0807|0705|0815|0811|0905|0915/.test(phoneStr))
        {
            verNetwork="GLO";
        }
        else if(/0702|0704|0803|0806|0703|0706|0813|0816|0810|0814|0903|0906|0913|0916/.test(phoneStr))
        {
            verNetwork="GIFTING";
        }
        else if(/0802|0808|0708|0812|0701|0901|0902|0907|0912|0911|0904/.test(phoneStr))
        {
            verNetwork="AIRTEL";
        }
        else if(/0809|0818|0817|0908|0909|/.test(phoneStr))
        {
            verNetwork="9MOBILE";
        }
        else if(/0804/.test(phoneStr))
        {
            verNetwork="NTEL";
        }
        else
        {
            verNetwork="Unable to identify network !";
        }
        if (selNetwork=="ETISALAT") {
                selNetwork="9MOBILE";}
                
            if (verNetwork==selNetwork)
            {
                var ic = "<i class = 'fas fa-check-circle' style ='color: #4BB543;'></i>";
            }
            else 
            {
                ic = "<i class = 'fas fa-exclamation-triangle' style ='color:#B33A3A'></i>";
            }
        
        document.getElementById('verifyer').innerHTML = "Identified Network: <b>"+verNetwork+"  "+ic+"</b><br><b> Note: </b> Ignore warning for <b>Ported Numbers</b>";
    }}


    function selectNetworkByIcon(name){
        $("option[networkname]").removeAttr("selected");
        $("option[networkname='"+name+"']").attr("selected","selected");
        let sme = $('#networkid').find(":selected").attr('sme');
            let gifting = $('#networkid').find(":selected").attr('gifting');
            let corporate = $('#networkid').find(":selected").attr('corporate');
            let networkname = $('#networkid').find(":selected").attr('networkname');
            let thegroup='<option value="">Select Type</option>';

                //Check If Network Is Disabled
                if(sme=="On"){
                    thegroup+='<option value="SME">SME</option>';
                }

                //Check If Network Is Disabled
                if(gifting=="On"){
                   thegroup+='<option value="Gifting">Gifting</option>';
                }

                //Check If Network Is Disabled
                if(corporate=="On"){
                   thegroup+='<option value="Corporate">Corporate</option>';
                }
                $("#datagroup").html(thegroup);
    }

    
    function selectExamByIcon(name){
        $("option[providername]").removeAttr("selected");
        $("option[providername='"+name+"']").attr("selected","selected");
    }
    
    

  function toggleSelect() {
    var select = document.getElementById("beneficiary");
    var input = document.getElementById("phoneInput");
    
    if (select.style.display === "none") {
        select.style.display = "block";
        input.style.display = "none";
    } else {
        select.style.display = "none";
        input.style.display = "block";
    }
} 

 function insertPhone() {
    var select = document.getElementById("beneficiarySelect");
    var phoneInput = document.getElementById("phone");
    var selectedValue = select.value;
    
    // Check if the selected value is "add"
    if (selectedValue === "add") {
        window.location.href = 'beneficiary';
    } else {
        phoneInput.value = selectedValue;
    }
}
    

    
</script>