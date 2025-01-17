<?php
use Phppot\Member;

if (!empty($_POST["login-btn"])) {
    require_once __DIR__ . '/Model/Member.php';

    
    $secretKey = '6Le2hbMqAAAAAOMjtKJH--hzEZnnZMdKQxgjNNJX';
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($url . '?secret=' . $secretKey . '&response=' . $responseKey . '&remoteip=' . $userIP);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        $loginResult = "reCAPTCHA verification failed. Please try again.";
    } else {
        $member = new Member();
        $loginResult = $member->loginMember();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="assets/css/phppot-style.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/user-registration.css" type="text/css" rel="stylesheet" />
    <script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="phppot-container">
        <div class="sign-up-container">
            <div class="login-signup">
                <a href="user-registration.php">Sign up</a>
            </div>
            <div class="signup-align">
                <form name="login" action="" method="post" onsubmit="return loginValidation()">
                    <div class="signup-heading">Login</div>
                    <?php if (!empty($loginResult)) { ?>
                        <div class="error-msg"><?php echo $loginResult; ?></div>
                    <?php } ?>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Username<span class="required error" id="username-info"></span>
                            </div>
                            <input class="input-box-330" type="text" name="username" id="username">
                        </div>
                    </div>
                    <div class="row">
                        <div class="inline-block">
                            <div class="form-label">
                                Password<span class="required error" id="login-password-info"></span>
                            </div>
                            <input class="input-box-330" type="password" name="login-password" id="login-password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="g-recaptcha" data-sitekey="6Le2hbMqAAAAAFD09rDGnfNeW7JEpHl4R5Lx8H2s"></div>
                    </div>
                    <div class="row">
                        <input class="btn" type="submit" name="login-btn" id="login-btn" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loginValidation() {
            var valid = true;
            $("#username").removeClass("error-field");
            $("#password").removeClass("error-field");

            var UserName = $("#username").val();
            var Password = $('#login-password').val();

            $("#username-info").html("").hide();

            if (UserName.trim() == "") {
                $("#username-info").html("required.").css("color", "#ee0000").show();
                $("#username").addClass("error-field");
                valid = false;
            }
            if (Password.trim() == "") {
                $("#login-password-info").html("required.").css("color", "#ee0000").show();
                $("#login-password").addClass("error-field");
                valid = false;
            }
            if (valid == false) {
                $('.error-field').first().focus();
                valid = false;
            }
            return valid;
        }
    </script>
</body>
</html>
