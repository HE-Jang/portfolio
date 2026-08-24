console.log('admin.js loaded');

$(document).ready(function() {
    // HTML 태그에 심어둔 URL을 변수로 가져옵니다.
    var $tableEl = $('#userTable');
    var urlGetData = $tableEl.data('url-get-data');
    var urlGetOne = $tableEl.data('url-get-one');
    var urlInsert = $tableEl.data('url-insert');
    var urlUpdate = $tableEl.data('url-update');
    var urlDelete = $tableEl.data('url-delete');

    // DataTables 초기화 (HTML thead 순서와 columns 개수를 5개로 일치시킴)
    var table = $tableEl.DataTable({
        "lengthMenu": [5, 10, 15, 20, 50],
        "order": [
            [3, "desc"] // 가입일(인덱스 3) 기준 정렬 등 필요에 맞게 조절
        ],
        "language": {
            "paginate": {
                "next": "다음",
                "previous": "이전"
            },
            "lengthMenu": "_MENU_ 개씩 보기",
            "info": "_TOTAL_건 중 _START_ ~ _END_ 표시",
            "infoFiltered": "(전체 _MAX_건 중 _TOTAL_건 검색됨)",
            "search": "검색:",
            "zeroRecords": "데이터가 없습니다."
        },
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": urlGetData,
            "type": "POST"
        },
        "columns": [
            { "data": "user_name" }, // 1. 이름
            { "data": "email" },     // 2. 이메일
            {                        // 3. 성별
                "data": "gender",
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return data == 1 ? '남' : (data == 2 ? '여' : '-');
                    }
                    return data;
                }
            },
            { "data": "created_at" }, // 4. 가입일
            {                         // 5. 관리 (수정/삭제 버튼)
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    var pkId = row.id ? row.id : row.user_id;
                    return `
                        <div class="btn-group-flex">
                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${pkId}">수정</button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${pkId}">삭제</button>
                        </div>
                    `;
                }
            }
        ]
    });

    function showModal() { $('#userModal').css('display', 'block'); }
    function hideModal() { $('#userModal').css('display', 'none'); }

    // 1. [신규 유저 등록] 버튼 클릭 시
    $('#btnAddUser').click(function() {
        $('#modalTitle').text('유저 정보 등록');
        $('#userForm')[0].reset();
        
        $('#user_pk').val('');                         // PK 초기화
        $('#user_id_input').prop('readonly', false);   // 신규는 아이디 입력 가능
        
        // [등록 모드] 비밀번호 입력 가능, 필수값 지정, 체크박스 숨김
        $('#user_pw').prop('disabled', false).attr('required', true).val('');
        $('#pwChangeContainer').hide();
        $('#chkChangePw').prop('checked', false);
        
        showModal();
    });

    // 모달 닫기 버튼 (.close 또는 data-dismiss="modal")
    $('[data-dismiss="modal"], .close').click(function() {
        hideModal();
    });

    // 2. [수정] 버튼 클릭 시 (단건 조회 후 모달 팝업)
    $('#userTable').on('click', '.btn-edit', function() {
        var userId = $(this).data('id');

        $.ajax({
            url: urlGetOne,
            type: "POST",
            data: { id: userId },
            dataType: "json",
            success: function(response) {
                $('#modalTitle').text('유저 정보 수정');
                $('#user_pk').val(response.id);                      // PK 세팅
                $('#user_id_input').val(response.user_id).prop('readonly', true); // 수정 시 아이디 변경 불가(읽기 전용)
                $('#user_name').val(response.user_name);
                $('#email').val(response.email);
                $('#gender').val(response.gender);
                
                // [수정 모드] 기본적으로 비밀번호 입력 잠금, 값 비우기, 체크박스 노출
                $('#user_pw').prop('disabled', true).removeAttr('required').val('');
                $('#chkChangePw').prop('checked', false);
                $('#pwChangeContainer').show();

                showModal();
            },
            error: function() {
                alert('유저 정보를 불러오는데 실패했습니다.');
            }
        });
    });

    // 3. [비밀번호 변경] 체크박스 토글 이벤트
    $('#chkChangePw').change(function() {
        if ($(this).is(':checked')) {
            // 체크하면 비밀번호 입력 가능 + 필수 입력 지정
            $('#user_pw').prop('disabled', false).attr('required', true);
        } else {
            // 체크 해제하면 다시 입력 잠금 + 값 초기화 + 필수 해제
            $('#user_pw').prop('disabled', true).removeAttr('required').val('');
        }
    });

    // 4. [저장] 버튼 클릭 시 (등록 및 수정 분기 처리)
    $('#btnSaveUser').click(function() {
        var userPk = $('#user_pk').val();
        var url = userPk ? urlUpdate : urlInsert; // PK가 있으면 수정, 없으면 등록

        $.ajax({
            url: url,
            type: "POST",
            data: $('#userForm').serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    alert('저장되었습니다.');
                    hideModal();
                    table.ajax.reload(null, false); // 테이블 새로고침 (페이지 유지)
                } else {
                    alert('저장 실패: ' + (response.message || '알 수 없는 오류'));
                }
            },
            error: function() {
                alert('서버 통신 중 오류가 발생했습니다.');
            }
        });
    });

    // 5. [삭제] 버튼 클릭 시
    $('#userTable').on('click', '.btn-delete', function() {
        if (!confirm('정말 삭제하시겠습니까?')) return;

        var userId = $(this).data('id');

        $.ajax({
            url: urlDelete,
            type: "POST",
            data: { id: userId },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    alert('삭제되었습니다.');
                    table.ajax.reload(null, false);
                } else {
                    alert('삭제 실패');
                }
            },
            error: function() {
                alert('서버 통신 중 오류가 발생했습니다.');
            }
        });
    });
});