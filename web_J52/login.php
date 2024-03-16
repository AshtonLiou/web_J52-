<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>login.php</title>
</head>

<body>

    <div id="app">

        <div class="bgi3">
            <p class="battle">Welcome to<br>Shanghai<br>Battle!</p>
        </div>

        <!-- navbar -->

        <header>
            <nav class="container">
                <a href="index.php">玩家留言</a>
                <a href="contest.php">玩家參賽</a>
                <a href="login.php" class="text-success">網站管理</a>
                <button @click="logout" v-show="isLogin" class="bn"
                    style="display: none; position: absolute; right: 10px; background-color: rgba(255, 255, 255, .8); color: black;">登出</button>
            </nav>
        </header>

        <!-- login -->


        <main class="container" style="width: 40vw; margin-top: 10vh;" v-show="!isLogin" style="display: none;">

            <div id="alertVeri" style="position: fixed; top: 1em; right: 1em; font-weight: 900;"></div>
            <div id="alertAccPw" style="position: fixed; top: 1em; left: 1em; font-weight: 900;"></div>

            <form action="./api/loginDb.php" method="post" v-show="!isLogin" style="display: none; background: linear-gradient(rgba(111, 164, 255, .6),rgba(121, 97, 147, .6));">

                <h1 class="text-center text-white" style="font-weight: 900;">網站管理--登入</h1>

                <div class="row mt-4">
                    <input type="text" class="col" name="acc" v-model="acc" placeholder="帳號" required>
                </div>

                <div class="row mt-4">
                    <input type="password" class="col" name="pw" v-model="pw" placeholder="密碼" required>
                </div>

                <div class="row mt-4">
                    <input type="text" class="col" name="veri" v-model="veri" placeholder="驗證碼" required>
                </div>

                <div class="row mt-4 align-items-center jusitfy-content-around">
                    <span id="captcha" class="col-4 text-center m-auto">{{ captcha }}</span>
                    <button type="button" class="btn rootBtn col-5" @click="reGenerate" style="height: 5vh;">驗證碼重新產生</button>
                </div>

                <hr>

                <div class="row mt-4">
                    <button type="reset" class="btn rootBtn col" style="height: 5vh;">重設</button>
                </div>

                <div class="row mt-4">
                    <button type="button" class="btn rootBtn col" style="height: 5vh;" @click="login">送出</button>
                </div>

            </form>

        </main>

        <!-- manage -->

        <div class="container" v-show="isLogin" style="display: none;">
            <div class="border border-dark d-flex jusitfy-content">
                <button class="bn">留言管理</button>
                <button class="bn">賽制管理</button>
            </div>
            <div class="border border-dark" style="height: 500px;"></div>
        </div>

    </div>

    <script src="./jquery/jquery.js"></script>
    <script src="./jquery/jquery-ui.min.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script src="./jquery/vue_2.6.14.js"></script>

    <script>

        new Vue({
            el: "#app",
            data() {
                return {
                    captcha: "",
                    isLogin: false,
                    acc: "",
                    pw: "",
                    veri: ""
                }
            },
            methods: {
                reGenerate() {
                    this.captcha = Math.floor(Math.random() * 8999 + 1000)
                },
                login() {
                    if (this.veri == this.captcha) {
                        $.post("./api/loginDb.php", { acc: this.acc, pw: this.pw }, (r) => {
                            if (parseInt(r) == 1) {
                                localStorage.setItem("isLogin", "true")
                                this.isLogin = true
                                this.acc = ""
                                this.pw = ""
                                this.veri = ""
                                this.reGenerate()
                            } else {
                                $("#alertAccPw").append('<div class="alert alert-warning alert-dismissible border border-warning fade show text-center text-danger" style="width: 15vw;">' +
                                    '<span>帳號或密碼錯誤，哈哈可憐</span>' +
                                    '<button type="button" class="close" data-dismiss="alert">' +
                                    '<span>&times;</span>' +
                                    '</button>' +
                                    '</div>')

                                $("input[name='acc'], input[name='pw']").addClass("border border-warning")

                                $("form").addClass("shake")

                                setTimeout(() => {
                                    $("form").removeClass("shake")
                                }, 300)
                            }
                        })
                    } else {
                        $("#alertVeri").append('<div class="alert alert-danger alert-dismissible border border-danger fade show text-center text-danger" style="width: 15vw;">' +
                            '<span>驗證碼錯誤，哈哈笑死</span>' +
                            '<button type="button" class="close" data-dismiss="alert">' +
                            '<span>&times;</span>' +
                            '</button>' +
                            '</div>')

                        $("input[name='veri']").addClass("border border-danger")

                        $("form").addClass("shake")

                        setTimeout(() => {
                            $("form").removeClass("shake")
                        }, 300)
                    }
                },
                logout() {
                    this.isLogin = false
                    localStorage.setItem("isLogin", "false")
                }
            },
            mounted() {
                this.isLogin = localStorage.getItem("isLogin") == "true"
                this.reGenerate()
            },
        })

    </script>
</body>

</html>