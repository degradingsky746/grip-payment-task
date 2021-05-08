<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Make a donation!</title>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    
  </head>
  <body>
    <div class="first-block">
      <p>   Covid Relief Fund   </p>
      <hr>
      <p>Donations will be used for medical supplies and food<br></p>


    </div>
    <div class="main-block">
      <h1>Donate !</h1>

      <form>
        <hr>
        <label id="icon" for="name"><i class="fas fa-user"></i></label>
        <input type="text" name="name" placeholder="Name" required/>
        <label id="icon" for="name"><i class="fas fa-envelope"></i></label>
        <input type="text" name="name" placeholder="Email" required/>
        <label id="icon" for="name"><i class="fas fa-rupee-sign"></i></label>
        <input type="text" name="name" id="amount" placeholder="Amount" required/>
        <div class="btn-block">
          
          <button type="button" id="checkout-button">Proceed..</button>
        </div>
      </form>
    </div>
  </body>
  <script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    function validate(){
      return true;
    }
    var stripe = Stripe("public key");
    var checkoutButton = document.getElementById("checkout-button");
    checkoutButton.addEventListener("click", function () {
      if(validate()==true){
      document.getElementById("checkout-button").disabled = true;
      var y = document.querySelectorAll("input");
      var data = { name:y[0].value,mail:y[1].value,amount:y[2].value};

      fetch("create-checkout-session.php", {
        method: "POST",
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function (result) {
          // If redirectToCheckout fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using error.message.
          if (result.error) {
            alert(result.error.message);
          }
        })

      }
    });
  </script>
</html>