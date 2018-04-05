<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kantana Admin Page</title>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

input[type=submit]{
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

input[type=submit]:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
#outer{
    width: 100%;

    /* Firefox */
    display: -moz-box;
    -moz-box-pack: center;
    -moz-box-align: center;

    /* Safari and Chrome */
    display: -webkit-box;
    -webkit-box-pack: center;
    -webkit-box-align: center;

    /* W3C */
    display: box;
    box-pack: center;
    box-align: center;
}
#inner{
    width: 50%;
}
</style>
</head>
<body id="outer">
  <div id="inner">
  <h2>Kantana Admin</h2>
    <form action="" method="post">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="imgcontainer">
        <img src="<?php echo base_url(); ?>asset/img/img_avatar2.png" href="" alt="Avatar" class="avatar">
      </div>

      <div class="container">

        <?php
          echo "<div class='mess_error'>";
          echo "<ul>";
          if(validation_errors() != ''){
            echo "<li>".validation_errors()."</li>";
          }
          echo "</ul>";
          echo "</div>";
          if(isset($mess) && $mess != ''){
            echo "<div class='mess_succ'>";
            echo "<ul>";
            echo "<li>$mess</li>";
            echo "</ul>";
            echo "</div>";
          }
        ?>
        <label for="login_id"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="login_id" required>

        <label for="login_pass"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="login_pass" required>

        <input type="submit" value="Login" />
      </div>

    </form>
  </div>
</body>
</html>
