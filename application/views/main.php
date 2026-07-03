<style>
    body {
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
    }

    .login-box {
        padding: 30px;
        background: #fff;
        border-radius: 8px;
    }

    .login-box p {
        margin-bottom: 10px;
    }

    .login-box input {
        width: 260px;
        padding: 8px;
        box-sizing: border-box;
    }

    .login-box button {
        width: 100%;
        padding: 8px;
    }
</style>

<div class="login-box">
    <h3>로그인</h3>
    <form action="/main/login" method="post" onsubmit="return Common.loginCheck(this)">
        <p><input type="text" name="id" placeholder="ID"></p>
        <p><input type="password" name="pw" placeholder="Password"></p>
        <button type="submit">로그인</button>
    </form>
</div>
<script src="/assets/js/common.js"></script>