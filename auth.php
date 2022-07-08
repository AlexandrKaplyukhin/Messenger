<?php include("include/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

    <script src="logreg.js"></script>
</head>
<body style="overflow:hidden; background: url(https://static.pantone.ru/public/HYDKJEJ6KPaw3KJnPP9s3A/gradient-1080x675.jpg) no-repeat; background-size: 100%;

 ">
    <?php
        if (isset($_POST['go_reg'])){

            $g = mysqli_query($connections, "SELECT * FROM `users` WHERE `login`='{$_POST['login']}'");

            if (mysqli_num_rows($g) == 0){
                $info = array(
                    'location' => trim($_POST['mest_jit']),
                    'born' => trim($_POST['rodil']),
                    'job' => trim($_POST['rab']),
                    'study' => trim($_POST['uch']),
                    'type' => trim($_POST['polog']),
                    'hobby' => trim($_POST['evlech']),
                    'email' => trim($_POST['mail']),
                    'background' =>"img/background.jpg",
                    'avatar' => "img/avatar.jpg",
                    'friends' => array()
                    
                );
                $info_json = (json_encode($info,JSON_UNESCAPED_UNICODE));
                $posts = json_encode(array(),JSON_UNESCAPED_UNICODE);
                $pass = password_hash($_POST['password'],PASSWORD_DEFAULT);
                mysqli_query($connections, "INSERT INTO `users` (`name`, `login`, `password`, `info_json`, `posts_json`) VALUES ('{$_POST['login']}', '{$_POST['login']}', '{$pass}', '{$info_json}', '{$posts}')");
                echo("<script>document.location.href  = '/index.php'</script>");
            }else{
                echo("Эти данные уже используются."); 
            }

            
        }
        if (isset($_POST['go_log'])){
            $loginEx = mysqli_query($connections, "SELECT * FROM `users` WHERE `login`='{$_POST['login']}'");
            
            if (mysqli_num_rows($loginEx) == 1){
                $loginExFetch = mysqli_fetch_assoc($loginEx);
                if (password_verify($_POST['password'], substr( $loginExFetch['password'], 0, 60 ))){

                    $_SESSION['user'] = $loginExFetch;
                    echo("<script>document.location.href  = '/index.php'</script>");
                }else{
                    echo("Неверные данные");
                }
            }else{
                echo("Неверные данные");
            }
        }
    ?>
    <style>
body{
    background-color: linear-gradient( 123deg, #FFFFFF 0%, #00B2FF 100%), linear-gradient(236deg, #BAFF99 0%, #005E64 100%), linear-gradient(180deg, #FFFFFF 0%, #002A5A 100%), linear-gradient(225deg, #0094FF 20%, #BFF4ED 45%, #280F34 45%, #280F34 70%, #FF004E 70%, #E41655 85%, #B30753 85%, #B30753 100%), linear-gradient(135deg, #0E0220 15%, #0E0220 35%, #E40475 35%, #E40475 60%, #48E0E4 60%, #48E0E4 68%, #D7FBF6 68%, #D7FBF6 100%);
background-blend-mode: overlay, overlay, overlay, darken, normal;

}
        input{
            font-size:2vw;
            margin-top:2vw;
            border-style: solid;
            background:unset;
        }
        #login{
            position:absolute;
            width:fit-content; box-shadow: 0px 5px 20px rgb(20,20,20); padding:1vw; margin-top: 30vh;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;

            transition:0.5s;
        }
        #reg{
            position:absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            width:fit-content; box-shadow: 0px 5px 20px rgb(20,20,20); padding:1vw; margin:0 auto; margin-top: 10vh;
            transition:0.5s;
            margin-top:200vh;
        }
    </style>
    <p style="position:absolute; bottom:0;right:0; ">В браузерах MSEdge, Explorer и подобных, вёрстка может отображаться некорректно</p>
    <div id="login" style="background-color:white; <?php if (isset($_POST['go_reg'])) {echo("margin-top:-100vh;"); }else{echo("margin-top:30vh;");} ?>">
        <form action="#" method="POST">    
            <h1>Вход: </h1>
            <input type="text" placeholder="Логин" name="login" minlength="4" required><br>
            <input type="password" placeholder="Пароль" name="password" minlength="6" required>
            <p style="text-align:right; margin-top:1vw;cursor:pointer;" onclick="toRegister()" >Регистрация</p>
            <input type="submit" value="Вход" style="width:100%;" name="go_log">
            
        </form>
    </div>


    <div id="reg" style=" <?php if (isset($_POST['go_reg'])) {echo("margin-top:10vh;");}else{echo("margin-top:200vh;");   } ?>">
        <form action="#" method="POST">        
            <h1>Регистрация: </h1>
            <div style="display:flex;">
                <div style="margin-right:2vw;">
                    <input type="text" placeholder="Логин*" name="login" minlength="4" required><br>
                    <input type="password" placeholder="Пароль*" name="password" minlength="6" required><br>
                    <input type="email" placeholder="Mail*" name="mail" required><br>
                </div>
                <div>
                    <input type="text" placeholder="Место жительства" name="mest_jit"><br>
                    <input type="text" placeholder="Родился" name="rodil"><br>
                    <input type="text" placeholder="Работает" name="rab"><br>
                    <input type="text" placeholder="Учился/Учится" name="uch"><br>
                    <input type="text" placeholder="Семейное положение" name="polog"><br>
                    <input type="text" placeholder="Увлечение" name="evlech"><br>
                </div>
            </div>
            <p style="text-align:right; margin-top:1vw;cursor:pointer;" onclick="toLogin()" >Вход</p>
            <input type="submit" value="Зарегистрироватся" style="width:100%;" name="go_reg">
        </form>
    </div>
</body>
</html>