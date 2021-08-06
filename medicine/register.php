<!DOCTYPE html>
<html>
<head>
<style>
body {
	font-family : Arial,Helvetica,sans-serif;
		
}
form {
	border : 3px solid red ;
}
input[type=text],input[type=password] {
	width : 100%;
	padding  : 1px 20px;
	margin : 8px;
	display : inline-block;
	border : 1px solid blue;
	box-sizing : border-box;
}
button {
	
	background-color : green;
	color : white;
	padding : 14px 20ox;
	margin : 8px;
	border : none;
	cursor : pointer;
	width : 100%;
}
.container {
	padding : 16px;
	background-color : pink;
}
.footer {
	margin:0px;
	padding:15px 0px 20px 0px;
	width:942px;
        background:#D8D8D8;
	float:left;
}
p.copyright-text {
	margin:0px;
	padding:3px 0px 3px 0px;
	font-family:AR DESTINE, Helvetica, sans-serif;
	font-size:21px;
	text-decoration:none;
	color:black;
	font-weight:normal;
	text-align:center;
}
.copyright {
	border:0px;
21	height:1px;
	width:1px;
}
</style>
</head>
<body>
<h2> <marquee> register form </marquee> </h2>
<h2> <a href="login.php" >Already Registered</a> </h2>
<div class="container">

<form action="php/register.php" method="post" >

<label for ="fname">
<b> full name </b> </label>
<input type="text" placeholder=" enter your full name" name="fname" required>

<label for ="eadd">
<b> email address </b> </label>
<input type="text" placeholder=" enter your email address" name="email" required>
<label for ="phno">
<b> phone number </b> </label>
<input type="text" placeholder=" enter phone number" name="phone" required>
<label for ="uname">
<b> user name </b> </label>
<input type="text" placeholder=" enter user name" name="user_name" required>
<label for="psw">
<b> password </b> </label>
<input type="password" placeholder="enter password" name="password" required>
<label for="cpsw">
<b> conform password </b> </label>
<input type="password" placeholder="enter password" name="rep_password" required>

<button type="submit" > submit </button>


</form>

</a>
<label>
<input type="checkbox" checked="checked" name="register">
</label>
<div class="footer">
<p class="copyright-text">
<footer>
Copyright 2021. Designed by VRR  
</footer>
</p>
</div>
</div>
</body>
</html>