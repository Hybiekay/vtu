
<div class="row">
<div class="col-12">
    
    <div class="box">
        <div class="box-header with-border">
          <h4 class="box-title">Credit/Debit User Wallet</h4>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <form  method="post" class="form-submit">
                    
                <div class="form-group">
                    <label for="success" class="control-label">User Email</label>
                    <div class="">
                    <input type="email" name="email"  placeholder= "Email" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Action</label>
                    <div class="">
                    <select name="action" class="form-control" required="required">
                        <option value="">Select Action</option>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Amount</label>
                    <div class="">
                    <input type="number" name="amount" placeholder="Amount" class="form-control" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="success" class="control-label">Reason For Action</label>
                    <div class="">
                    <input type="text" name="reason" placeholder="Reason" class="form-control" required="required">
                    </div>
                </div>
                

                <div class="form-group">
                    <div class="">
                       <button type="submit" name="credit-debit-user" class="btn btn-info btn-submit"><i class="fa fa-save" aria-hidden="true"></i> Update Wallet</button>
                       <a href="subscribers" class="btn btn-success"><i class="fa fa-home" aria-hidden="true"></i> Back</a>
                    </div>
                </div>
        </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
</div>
</div>


<div class="row">
    <div class="col-12">
         <div class="box">
            <div class="box-header with-border d-flex justify-content-between">
              <h4 class="box-title">Pending Manual Funding Request</h4>
            </div>
            <div class="box-body">
				<div class="table-responsiv">
				  <table id="example1" class="table table-sm table-bordered table-striped">
					<thead>
						<tr>
							<th>Manual Funding Request</th>
					</thead>
					<tbody>
					
					<?php 
                            $cnt=1; $results=$data;
                            if($results <> "" && $results <> 1){foreach($results as $result){   ?>
                            <tr>
                                <td class="text-center">
                                       <h5 class="text-primary"><b><?php echo strtoupper($result->sFname . " " . $result->sLname); ?></b></h5>
                                       <h6><b>(<?php echo $result->sEmail?></b>)</h6>
                                       <p style="text-wrap: wrap;"><b>Amount: </b><?php echo $result->amount;?>, <b>Account: </b><?php echo $result->account;?>, <b>Method: </b><?php echo $result->method;?></p>
                                       <p><?php echo $controller->formatDate($result->dPosted);?></p>
            
                                        <p>
                                            <button class="btn btn-success mt-2" onclick="updateManualFundingStatus(<?php echo $result->tId;?>,'success','<?php echo $result->amount;?>','<?php echo $result->sEmail?>')"><i class="fa fa-check"></i></button> 
                                            <button class="btn btn-danger mt-2" onclick="updateManualFundingStatus(<?php echo $result->tId;?>,'failed','<?php echo $result->amount;?>','<?php echo $result->sEmail?>')"><i class="fa fa-close"></i></button>
                                        </p>
                                </td>
                            </tr>
                    <?php }} ?>
						
					</tbody>
					</table>
				</div>
            </div>
            <!-- /.box-body -->
          </div>
    </div>
</div>





