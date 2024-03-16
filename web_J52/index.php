<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index.php</title>
    <link rel="stylesheet" href="./bootstrap/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>


<body>

    <div id="app">

        <div class="bgi1">
            <p class="battle">Welcome to<br>Shanghai<br>Battle!</p>
        </div>

        <!-- navbar -->

        <header>
            <nav class="container">
                <a href="index.php" class="text-success">玩家留言</a>
                <a href="contest.php">玩家參賽</a>
                <a href="login.php">網站管理</a>
            </nav>
        </header>

        <!-- imformation -->

        <div class="container" style="margin-top: 30vh;" v-show="!isAddMsg" style="display: none;">

            <div class="card h-auto d-flex text-center">
                <div class="card-header text-white"
                    style="background-color: rgb(90, 180, 120); display: flex; justify-content: space-between;">
                    <button class="btn rootBtn" @click="addMsg">新增留言</button>
                    <h3 class="m-2" style="font-weight: 900;">玩家留言列表</h3>
                    <button class="btn rootBtn">玩家留言管理</button>
                </div>
                <div class="card-body"
                    style="background-color: rgba(90, 180, 120, .1); overflow: scroll; height: 20em;">
                    <table v-for="msg in msg" :key="msg.id"
                        class="mx-auto table table-striped table-bordered table-hover w-75">
                        <tr>
                            <td rowspan="4" class="bg-dark" style="width: 200px; height: 200px;">
                                <img :src="msg.uploadImg" class="img-thumbnail w-100 h-100" style="object-fit: cover;">
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" style="font-size: 1.5em;">{{ msg.msgContent }}
                            </th>
                        </tr>
                        <tr>
                            <td style="height: 1em;">E-mail: {{ msg.email }}</td>
                            <td style="height: 1em;">電話: {{ msg.tel }}</td>
                        </tr>
                        <tr>
                            <td style="height: 1em;">發表於: {{ msg.issTime }}</td>
                            <td style="height: 1em;">刪除於: {{ msg.delTime }}</td>
                        </tr>
                        <tr>
                            <td>
                                <h3 style="color: #e1e1e1; background-color: #4a6783; margin: 0; border-radius: 10px;">
                                    {{msg.name }}</h3>
                            </td>
                            <td colspan="2">
                                <button class="btn warningBtn" style="width: 10em;" @click="editOrDel(msg.id)">Edit
                                    (編輯)</button>
                                <button class="btn dangerBtn" style="width: 10em;" @click="editOrDel(msg.id)">Delete
                                    (刪除)</button>
                                <h3 style="color: #f00; display: none;">*已刪除*</h3>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card h-auto d-flex text-center my-5">
                <div class="card-header text-white"
                    style="background-color: rgb(125, 125, 125); display: flex; justify-content: center;">
                    <h3 class="m-2" style="font-weight: 900;">最新消息與賽制公告區塊</h3>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>

        <div class="container" style="width: 40vw; margin-top: 10vh;" v-show="isAddMsg" style="display: none;">

            <form @submit.prevent="submit" action="./api/db.php" method="post" v-show="isAddMsg"
                style="display: none; background-color: rgba(174, 187, 201, .5);">

                <button class="btn rootBtn" type="button" style="position: absolute; top: 1em; right: 1em;"
                    @click="reAddMsg">回留言列表</button>

                <h1 class="text-center text-white"
                    style="font-weight: 900; background-color: rgb(90, 180, 120); border-radius: 10px; padding: .5em;">
                    玩家留言-新增</h1>

                <div class="row mt-4">
                    <input type="text" class="col" name="name" v-model="name" placeholder="姓名" required>
                </div>

                <div class="row mt-4">
                    <input type="email" class="col" name="email" v-model="email" pattern="(.*\..*@.*)|(.*@.*\..*)"
                        placeholder="E-mail (須包含@及至少一個.)" required>
                </div>

                <div class="row mt-4">
                    <input type="tel" class="col" name="tel" v-model="tel" pattern="((-+\d+)|(\d+-+))+(\d+)?"
                        placeholder="電話 (只能包含數字及-)" required>
                </div>

                <div class="row mt-4">
                    <textarea name="msgContent" class="col" name="msgContent" v-model="msgContent" placeholder="留言內容"
                        style="height: auto; transition: 0s;" required></textarea>
                </div>

                <div class="row mt-4">
                    <label for="file" class="col-5 btn rootBtn">圖片上傳</label>
                    <input type="file" id="file" name="uploadImage" @change="uploadImage" style="display: none;"
                        required accept="image/*">
                    <input type="text" class="col-5 ml-auto" name="msgNumber" v-model="msgNumber" pattern="\d{4}"
                        placeholder="留言序號 (四位數字)" required>
                </div>

                <div class="row mt-4">
                    <button type="reset" class="btn rootBtn col-5" style="height: 5vh;">重設</button>
                    <button type="submit" class="btn rootBtn col-5 ml-auto" style="height: 5vh;">送出</button>
                </div>
            </form>


        </div>

    </div>


    <!-- script -->

    <script src="./jquery/jquery.js"></script>
    <script src="./jquery/jquery-ui.min.js"></script>
    <script src="./bootstrap/bootstrap.js"></script>
    <script src="./jquery/vue_2.6.14.js"></script>

    <script>

        new Vue({
            el: "#app",
            data() {
                return {
                    isAddMsg: false,
                    isDel: false,
                    name: "",
                    email: "",
                    tel: "",
                    uploadImg: "",
                    msgContent: "",
                    msgNumber: "",
                    issTime: "",
                    editTime: "",
                    delTime: "",
                    msg: []
                }
            },
            methods: {
                addMsg() {
                    this.isAddMsg = true
                },
                reAddMsg() {
                    this.isAddMsg = false
                },
                uploadImage() {
                    let file = $("#file").prop("files")[0]
                    if (file) {
                        let reader = new FileReader()
                        reader.onload = (e) => {
                            this.uploadImg = e.target.result
                        }
                        reader.readAsDataURL(file)
                    }
                },
                submit() {
                    let playerMsgNew = {
                        name: this.name,
                        email: this.email,
                        tel: this.tel,
                        uploadImg: this.uploadImg,
                        msgContent: this.msgContent,
                        msgNumber: this.msgNumber
                    }
                    $.post('./api/new.php', playerMsgNew, () => {
                        location.reload()
                    })
                },
                loadMsg() {
                    $.getJSON("./api/disp.php", (r) => {
                        this.msg = r
                    })
                },
                editOrDel(id) {
                    const msgNum = prompt("請輸入留言編號刪除")
                    if (msgNum) {
                        $.post("./api/veriMsgNum.php", { id: id, msgNum: msgNum }, (r) => {
                            if (r == 1) {
                                this.delRecord(id)
                                sessionStorage.setItem("isDel", "true")
                                this.isDel = true
                            } else {
                                alert("無效的留言編號，笑死")
                            }
                        })
                    }
                },
                delRecord(id) {
                    $.post("./api.edit.php", { id: id, del: 1 }, () => {

                    })
                }
            },
            mounted() {
                this.loadMsg()
            }
        })

    </script>

</body>

</html>