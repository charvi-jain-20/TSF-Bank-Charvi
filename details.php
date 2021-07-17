<!DOCTYPE html>
<html>
<head>
    <title>TSF Bank</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
     @import url("https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700");
* {
  font-family: 'Times New Roman', Times, serif;
  box-sizing: border-box;
  color: #333;
  font-size: 100%;
  line-height: 1.5;
}
body {
  background: -webkit-linear-gradient(skyblue, lightblue);
  margin: 0;
    background-size: auto;
    background-repeat: no-repeat;
}
nav {
  --duration: .5s;
  --easing: ease-in-out;
  position: relative;
  width: 250px;
  margin: 20px;
}
nav ol {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
nav li {
  margin: -4px 0 0 0;
}
nav a {
  display: block;
  text-decoration: none;
  background: #fff;
  transform-origin: 0 0;
  transition: transform var(--duration) var(--easing), color var(--duration) var(--easing);
  transition-delay: var(--delay-out);
  border-radius: 4px;
  padding: 1em 1.52em;
}
nav a:hover {
  background: #efefef;
}
nav .sub-menu a {
  font-size: .9em;
  color: #666666;
  border-left: 2em solid white;
  padding: .75em;
  background: linear-gradient(to right, #dddddd 2px, #ffffff 2px);
}
nav .sub-menu a:hover {
  background: linear-gradient(to right, #dddddd 2px, #efefef 2px);
}
nav header {
  font-weight: 600;
  display: block;
  background: rgba(255, 255, 255, 0.5);
  transform-origin: 0 0;
  transition: transform var(--duration) var(--easing), color var(--duration) var(--easing);
  transition-delay: var(--delay-out);
  border-radius: 4px;
  padding: 1em 1.52em;
}
nav header span {
  border: none;
  background: transparent;
  font-size: 1.5em;
  padding: 0;
  cursor: pointer;
  line-height: 1;
  float: right;
}
nav footer button {
  position: absolute;
  top: 0;
  left: 0;
  border: none;
  padding: calc(1em - 2px);
  width: 100%;
  transform-origin: 0 0;
  transition: transform var(--duration) var(--easing);
  transition-delay: calc(var(--duration) + (.1s * (var(--count) / 2)));
  cursor: pointer;
  outline: none;
  background: #cdcdcd;
  opacity: 0;
}
nav.closed a,
nav.closed header {
  transform: translateY(calc(var(--top) * -1)) scaleY(0.1) scaleX(0.2);
  transition-delay: var(--delay-in);
  color: transparent;
}
nav.closed footer button {
  transition-delay: 0s;
  transform: scaleY(0.7) scaleX(0.2);
}
    </style>
</head>
<body>
    <div class="topnav">
        <h3>T S F</h3><img class="logo" src="images/logo.jpg" height="50px" width="50px">
        <a href="history.php">Transaction History</a>
        <a href="users.php">Customers</a>
        <a class="active" href="index.html">Home</a>
    </div>
    <table>
        <tr>
            <th>Account Number</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Balance</th>
        </tr>
    
    <?php
        session_start();
        include('config.php');
        $_SESSION['user'] = $_GET['user'];
        $_SESSION['sender'] = $_SESSION['user'];
        if (isset($_SESSION['user'])) 
        {
            $user = $_SESSION['user'];
            $sql = "SELECT * FROM users WHERE user_name='$user'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)) 
            {
                echo "<tr>";
                echo "<td>" . $row["user_acc_no"] . "</td><td>" . $row["user_name"] . "</td>
                      <td>" . $row["user_email"] . "</td><td>" . $row["user_gender"] . "</td>
                      <td>" . $row["user_balance"] . "</td>";
                echo "</tr>";
            }
          }
    ?>
    <div class="heading">
      <h2>MAKE  A  TRANSACTION</h2>
    </div>
    <div class="card-container">
    <?php
        if ($_GET['message'] == 'success') 
        {
            echo "<p style='color:green;' class='messagehide'>Transaction completed successfully</p>";
        }
        if ($_GET['message'] == 'transactionDenied') 
        {
            echo "<p style='color:red;' class='messagehide'>Transaction Failed </p>";
        }
    ?>
    <form action="transfer.php" method="POST">

    <!-- Make Transaction -->
    <br>
    <b class="info">To: </b>
        <select name="reciever" id="dropdown" class="textbox1" required>
            <option selected="true" disabled>Select Recipient</option> 
             <?php
                include('config.php');
                $user = $_SESSION['user'];
                $sql="SELECT * FROM users WHERE user_name!='$user'";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($res)) 
                {
                    echo ("<option>".$row['user_name']."</option>");
                }
            ?> 
        </select>
        <br><br>
        <b class="info">From:</b>
        <span>
            <input id="myinput" name="sender" class="textbox2" disabled type="text" value='<?php echo "$user"; ?>'>
        </span>
        <br>
        <br>
        <b class="info">Amount: &#8377;</b>
        <input name="amount" type="number" min="100" class="textbox3" required>
        <br>
        <br>
        <a href="transfer.php">
          <button id="transfer" name="transfer" class="transfer-button">Transfer</button>
        </a>
      </form>
    </div>
    <br>
    <br>
    <div class="heading">
      <h2>CUSTOMER  DETAILS</h2>
    </div>
    </table>

    <nav class="menu">
        <header>Menu<span>×</span></header>
        <ol>
            <li class="menu-item"><a href="index.html">Home</a></li>
            <li class="menu-item"><a href="users.php">Customers</a></li>
            <li class="menu-item"><a href="history.php">Transaction History</a></li>
        </ol>
        <footer><button aria-label="Toggle Menu">Toggle</button></footer>
    </nav>
  
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>
       var $els = $('.menu a, .menu header');
    var count = $els.length;
    var grouplength = Math.ceil(count/3);
    var groupNumber = 0;
    var i = 1;
    $('.menu').css('--count',count+'');
    $els.each(function(j){
        if ( i > grouplength ) {
            groupNumber++;
            i=1;
        }
        $(this).attr('data-group',groupNumber);
        i++;
    });
    
    $('.menu footer button').on('click',function(e){
        e.preventDefault();
        $els.each(function(j){
            $(this).css('--top',$(this)[0].getBoundingClientRect().top + ($(this).attr('data-group') * -15) - 20);
            $(this).css('--delay-in',j*.1+'s');
            $(this).css('--delay-out',(count-j)*.1+'s');
        });
        $('.menu').toggleClass('closed');
        e.stopPropagation();
    });
    
    // run animation once at beginning for demo
    setTimeout(function(){
        $('.menu footer button').click();
        setTimeout(function(){
            $('.menu footer button').click();
        }, (count * 100) + 500 );
    }, 1000);
    </script>

<footer class='foot'>
<div id="social">
    <a class="facebookBtn smGlobalBtn" href="https://www.facebook.com/thesparksfoundation.info" target="_blank"></a>
    <a class="twitterBtn smGlobalBtn" href="https://twitter.com/tsfsingapore" target="_blank"></a>
    <a class="instagramBtn smGlobalBtn" href="https://www.instagram.com/thesparksfoundation.info/" target="_blank"></a>
    <a class="linkedinBtn smGlobalBtn" href="https://www.linkedin.com/company/the-sparks-foundation/mycompany/" target="_blank"></a>
  </div>
  <p>Official Website: <a href='https://internship.thesparksfoundation.info/' target="_blank">https://internship.thesparksfoundation.info/</a></p>
  <p>&#169; Made By: Charvi Jain GRIP Batch July 2021</p>
</footer>

</body>
</html>