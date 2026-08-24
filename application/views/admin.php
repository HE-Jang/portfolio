<style>
    /* ----------------------------------
       간이 모달 CSS 및 레이아웃 스타일
       ---------------------------------- */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.fade {
        transition: opacity 0.15s linear;
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: 50px auto;
        max-width: 500px;
    }

    .modal-content {
        position: relative;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .modal-header h5 {
        margin: 0;
        font-size: 1.25rem;
    }

    .modal-header .close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #dee2e6;
        padding-top: 15px;
        margin-top: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
        border: 1px solid transparent;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }
</style>

<!-- 안내 문구 및 상단 영역 -->
<div class="user-list-header" style="margin-bottom: 20px;">
    <h2>관리자 - 유저 목록 관리</h2>

    <!-- 안내글과 버튼을 위아래로 나누거나, Flex로 양 끝 정렬할 때 컨테이너 활용 -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
        <p class="alert alert-info" style="margin: 0;">
            * 안내: 검색창에 성별로 검색하거나, 이름/이메일로 검색할 수 있습니다.
        </p>
        <!-- 신규 등록 버튼 (오른쪽 정렬) -->
        <button type="button" class="btn btn-primary" id="btnAddUser">신규 유저 등록</button>
    </div>
</div>

<div class="tableDiv">
    <!-- 테이블 영역 -->
    <table id="userTable" class="display" style="width:100%"
        data-url-get-data="<?php echo site_url('admin/get_data'); ?>"
        data-url-get-one="<?php echo site_url('admin/get_user_one'); ?>"
        data-url-insert="<?php echo site_url('admin/insert_user'); ?>"
        data-url-update="<?php echo site_url('admin/update_user'); ?>"
        data-url-delete="<?php echo site_url('admin/delete_user'); ?>">
        <thead>
            <tr>
                <th>이름</th>
                <th>이메일</th>
                <th>성별</th>
                <th>가입일</th>
                <th>관리</th> <!-- 수정/삭제 버튼 컬럼 -->
            </tr>
        </thead>
        <tbody>
            <!-- dataTable 자리 -->
        </tbody>
    </table>
</div>

<!-- 유저 등록/수정 모달 -->
<div class="modal" id="userModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background: #fff; padding: 20px; border-radius: 5px; max-width: 500px; margin: 50px auto;">

            <!-- 모달 헤더 -->
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <h5 class="modal-title" id="modalTitle" style="margin: 0; font-size: 1.25rem;">유저 정보 등록</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- 모달 바디 (폼) -->
            <div class="modal-body">
                <form id="userForm">
                    <!-- 수정 시 사용될 고유 PK (id: user_pk, name: user_id 또는 id) -->
                    <input type="hidden" id="user_pk" name="user_id">

                    <!-- 아이디 입력 필드 -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="user_id_input" style="display: block; margin-bottom: 5px; font-weight: bold;">아이디</label>
                        <input type="text" class="form-control" id="user_id_input" name="user_id" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <!-- 이름 입력 필드 -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="user_name" style="display: block; margin-bottom: 5px; font-weight: bold;">이름</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <!-- 이메일 입력 필드 -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">이메일</label>
                        <input type="email" class="form-control" id="email" name="email" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <!-- 성별 선택 필드 -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="gender" style="display: block; margin-bottom: 5px; font-weight: bold;">성별</label>
                        <select class="form-control" id="gender" name="gender" style="width: 100%; padding: 8px; box-sizing: border-box;">
                            <option value="1">남</option>
                            <option value="2">여</option>
                        </select>
                    </div>

                    <!-- 비밀번호 및 변경 체크박스 영역 -->
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="user_pw" style="display: block; margin-bottom: 5px; font-weight: bold;">
                            비밀번호
                            <!-- 수정 모달일 때만 나타나는 체크박스 -->
                            <span id="pwChangeContainer" style="margin-left: 10px; font-weight: normal; display: none; font-size: 0.9rem;">
                                <input type="checkbox" id="chkChangePw"> 비밀번호 변경
                            </span>
                        </label>
                        <input type="password" class="form-control" id="user_pw" name="user_pw" placeholder="비밀번호를 입력하세요" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>
                </form>
            </div>

            <!-- 모달 푸터 (버튼 영역) -->
            <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 8px 15px; cursor: pointer;">취소</button>
                <button type="button" class="btn btn-primary" id="btnSaveUser" style="padding: 8px 15px; cursor: pointer;">저장</button>
            </div>

        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/assets/js/datatable.js"></script>
<script src="/assets/js/admin.js"></script>