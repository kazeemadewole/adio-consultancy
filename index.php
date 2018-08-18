<?php 
require_once('user.php');
require_once('database.php');
 ?>

<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootsrap css goes here-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
  </script>
  </head>
<body>
    <?php require_once('top_header.php');  ?>
  <section>
     <h4>Software Enginner Application Portal</h4>
<div id="page">
 <?php if(isset($_POST['submit'])){
  $user = new user();
  $user->reg();
}?>
<span>
  <?php
  if (!empty($user->message)){
  echo $user->message;
}
?></span>
<form action="" method="post">
    <table style="">
      <tr><td>First name:</td><td><input type="text"  name="firstnames" ></td></tr>

      <tr ><td>Surname:</td><td><input type="text" name="surname" ></td></tr>
      <tr><td>Phone Number:</td><td><input type="number" name="phonenumber" ></td></tr>
      <tr><td>Email Address:</td><td><input type="email" name="email" ></td></tr>
      <tr><td>Cover letter:</td><td><textarea name="coverletter"></textarea></td></tr>
       <tr><td>Upload Passport:</td><td><input type="file" name="passport" ></td></tr>
        <tr><td>Upload Resume:</td><td><input type="file" name="resume" ></td></tr>
        <tr><td><input type="submit" value="Submit"  name="submit"></td></tr>

    </table>
   
    
</form>
</div>
</section>

  </section>
  <?php require_once('footer.php');?>
</body>