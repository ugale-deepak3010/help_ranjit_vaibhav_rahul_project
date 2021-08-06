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
	background-colocr : pale blue;
}
.rate {
	float : left;
	height : 46px;
	padding : 10px;
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
	height:1px;
	width:1px;
}
</style>
</head>
<body>
<h2> <marquee> feedback form </marquee> </h2>
<div class="container">

	<form action="php/feedback_form.php" method="post" >

<label for="fname">
<b> Full name</b> </label>
<input type="text" placeholder="enter your name" name="full_name" required>
<label for="phno">
<b> Phone number </b> </label>
<input type="text" placeholder="enter your phone number" name="phone" required>
<label for="eid">
<b> Email id </b> </label>
<input type="text" placeholder="enter your email id" name="email" required>
<label for="add">
<b> Address </b> </label>
<input type="text" placeholder="enter your address" name="address" required>
<label for="ci">
<b> City </b> </label>
<input type="text" placeholder="enter your city" name="city" required>
<label for="pc">
<b> Pincode </b> </label>
<input type="text" placeholder="enter your pincode" name="pin_code" required>
<label for="st">
<b> State </b> </label>
<input type="text" placeholder="enter your state" name="state" required>
<label for="co">
<b> Country </b> </label>
<input type="text" placeholder="enter your country" name="country" required>
<label for="com">
<b> Comment </b> </label>
<input type="text" placeholder="enter your comment" name="comment" required>
<label for="ra">
<b> Rate us </b> </label>

<label>
<input type="radio" name="star" value="1" />
<spam class="icon">* </spam>
</label>
<label>
<input type="radio" name="star" value="2" />
<spam class="icon">* </spam>
<spam class="icon">* </spam>
</label>
<label>
<input type="radio" name="star" value="3" />
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
</label>
<label>
<input type="radio" name="star" value="4" />
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
</label>
<label>
<input type="radio" name="star" value="5" />
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
<spam class="icon">* </spam>
</label>

<button type="submit" >submit </button>

<br><br><br>
</form>
</a>
<div class="footer">
<p class="copyright-text">
<footer>
Copyright 2021. Designed by VRR  
</footer>
</p>
</div>
</div>
</div>
</body>
</html>