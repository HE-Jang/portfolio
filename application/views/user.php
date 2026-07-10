<!-- 안내 문구 및 상단 영역 -->
<div class="user-list-header" style="margin-bottom: 20px;">
    <h2>관리자 - 유저 목록 관리</h2>
    <p class="alert alert-info">
        * 안내: 검색창에 성별로 검색하거나, 이름/이메일로 검색할 수 있습니다.
    </p>
</div>

<div class="tableDiv">
    <!-- 테이블 영역 -->
    <table id="userTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>이름</th>
                <th>이메일</th>
                <th>성별</th>
                <th>가입일</th>
            </tr>
        </thead>
        <tbody>
            <!-- dataTable 자리 -->
        </tbody>
    </table>
</div>
<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/assets/js/datatable.js"></script>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "lengthMenu": [5, 10, 15, 20, 50],
            "order": [
                [2, "asc"]
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
            "pageLength": 10, // 초기 5개 설정
            "ajax": {
                "url": "<?php echo site_url('user/get_data'); ?>",
                "type": "POST"
            },
            "columns": [{
                    "data": "user_name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "gender", // DB의 실제 필드명 (1, 2)
                    "render": function(data, type, row) {
                        // 화면 표시(display)할 때만 '남'/'여'로 변환
                        if (type === 'display') {
                            return data == 1 ? '남' : (data == 2 ? '여' : '-');
                        }
                        // 검색(filter)이나 정렬(sort) 시에는 원래 숫자(1, 2)를 사용하도록 그대로 반환
                        return data;
                    }
                },
                {
                    "data": "created_at"
                }
            ]
        });
    });
</script>