<!DOCTYPE html>
<html>
<head>
<style>
bpdy {
	font-family : Arial,Helvetica,sans-serif;
}
form {
	border : 3px solid red ;
}
input[type=text] {
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
<h2> <marquee> login form </marquee> </h2>
<div class="container">


<form action="php/forgot_password.php" method="post" >

<label for ="que">
<b> what is your phone number </b> </label>
<input type="text" placeholder=" enter your phone" name="phone" required>

<button Type="submit" >submit </button>
</form>

</a>
<label>
<input type="checkbox" checked="checked" name="remember">
 remember me </label>
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