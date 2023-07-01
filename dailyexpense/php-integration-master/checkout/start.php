<!DOCTYPE html>
<html>
  <head>
    <title>Cashfree-PG TestForm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <br>
    <br>
    <div class="container fluid">
      <h1 align="center">Cashfree PG Test Form</h1>
      <div class="alert alert-info">
        <strong>Note: </strong> Please insert your <span class="label label-info">Secret_key</span> in request and response files.
      </div>
      <div class="alert alert-info">
        <strong>Note: </strong> Please change <span class="label label-info">$mode</span> to "TEST" in request.php if using Test appId/secretKey credentials. Access test credentials <a href="https://test.gocashfree.com/merchant/pg#api-key">here</a> and production credentials <a href="https://merchant.cashfree.com/merchant/pg#api-key">here</a>.
      </div>
      <form id="redirectForm" method="post" action="request.php">
        <div class="form-group">
          <label>App ID:</label><br>
          <input class="form-control" name="appId" value="TEST414071efae7e51680dff6983dd170414"/>
        </div>
        <div class="form-group">
          <label>Order ID:</label><br>
          <input class="form-control" name="orderId" value="<?php echo "ORDER-".rand(111,999); ?> "/>
        </div>
        <div class="form-group">
          <label>Order Amount:</label><br>
          <input class="form-control" name="orderAmount" value="10"/>
        </div>
        <div class="form-group">
          <label>Order Currency:</label><br>
          <input class="form-control" name="orderCurrency" value="INR" placeholder="Enter Currency here (Ex. INR)"/>
        </div>
        <div class="form-group">
          <label>Order Note:</label><br>
          <input class="form-control" name="orderNote" placeholder="Enter Order Note here (Ex. Test order)"/>
        </div>    
        <div class="form-group">
          <label>Name:</label><br>
          <input class="form-control" name="customerName" placeholder="Enter your name here (Ex. John Doe)"/>
        </div>
        <div class="form-group">
          <label>Email:</label><br>
          <input class="form-control" name="customerEmail" placeholder="Enter your email address here (Ex. Johndoe@test.com)"/>
        </div>
        <div class="form-group">
          <label>Phone:</label><br>
          <input class="form-control" name="customerPhone" placeholder="Enter your phone number here (Ex. 9999999999)"/>
        </div>
        <div class="form-group">
          <label>Return URL:</label><br>
          <input class="form-control" name="returnUrl" value="http://localhost/php-integration-master/checkout/response.php"/>
        </div>        
        <div class="form-group">
          <label>Notify URL:</label><br>
          <input class="form-control" name="notifyUrl" placeholder="Enter the URL to get server notificaitons (Ex. www.example.com)"/>
        </div>
        <button type="submit" class="btn btn-primary btn-block" value="Pay">Submit</button>
        <br> 
        <br>
      </form>
    </div>
    <br>    
    <br>    
    <br>    
    <br>    
  </body>
</html>

