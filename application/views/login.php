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
    <form action="/login/login_process" method="post" onsubmit="return Common.loginCheck(this)">
        <p><input type="text" name="id" placeholder="ID"></p>
        <p><input type="password" name="pw" placeholder="Password"></p>
        <button type="submit">로그인</button>
    </form>
    <div class="test-account-box" style="margin-top: 20px; padding: 15px; background: #f0f7ff; border: 1px solid #d1e7ff; border-radius: 6px; font-size: 0.9rem; color: #084298;">
        <strong>체험용 계정:</strong> test / <strong>비밀번호:</strong> 1234<br>
        <small style="color: #666;">* 이 계정은 읽기 전용으로 제공됩니다.</small>
    </div>
</div>