// 공용 JS 파일
console.log('common.js loaded');

// 로그인 폼 체크 예시
function loginCheck(form) {
    if (form.id.value.trim() === '') {
        alert('아이디를 입력하세요');
        form.id.focus();
        return false;
    }

    if (form.pw.value.trim() === '') {
        alert('비밀번호를 입력하세요');
        form.pw.focus();
        return false;
    }

    return true;
}

const Common = {
    loginCheck(form) {
        if (!form.id.value) {
            alert('아이디 입력');
            return false;
        }
        if (!form.pw.value) {
            alert('비밀번호 입력');
            return false;
        }
        return true;
    }
};
