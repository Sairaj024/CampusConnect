<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>CampusConnect</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

.hero{
    min-height:90vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.wrapper{
    width:100%;
    max-width:1100px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
}

.portal-card{
    background:white;
    border-radius:18px;
    padding:45px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    text-align:center;
}

.portal-card h2{
    margin-bottom:15px;
}

.portal-card p{
    color:#64748b;
    margin-bottom:25px;
}

.btn{
    display:block;
    width:100%;
    margin-top:15px;
    text-decoration:none;
    text-align:center;
}

.logo{
    text-align:center;
    margin-bottom:50px;
}

.logo h1{
    font-size:48px;
    color:#2563eb;
}

.logo p{
    color:#64748b;
    font-size:18px;
}

@media(max-width:850px){

.wrapper{

grid-template-columns:1fr;

}

}

</style>

</head>

<body>

<div class="hero">

<div>

<div class="logo">

<h1>🎓 CampusConnect</h1>

<p>College Placement Management Portal</p>

</div>

<div class="wrapper">

<div class="portal-card">

<h2>👨‍🎓 Student Portal</h2>

<p>

Login, apply for companies and track your applications.

</p>

<a class="btn" href="login.php">

<button class="btn">

Student Login

</button>

</a>

<a class="btn" href="register.php">

<button class="btn">

Create Account

</button>

</a>

</div>

<div class="portal-card">

<h2>🛠 Admin Portal</h2>

<p>

Manage students, companies and placement activities.

</p>

<a class="btn" href="admin/login.php">

<button class="btn">

Admin Login

</button>

</a>

</div>

</div>

</div>

</div>

</body>

</html>