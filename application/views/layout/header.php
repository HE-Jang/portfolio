<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>포트폴리오</title>
    <!-- 여기에 부트스트랩이나 CSS 파일을 연결하세요 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
</head>

<body>
    <header>
        <h1>개발 포트폴리오</h1>
    </header>
    <nav>
        <!-- 공통 메뉴 (누구나 접근 가능) -->
        <a href="/main">홈</a>
        <a href="/about">소개</a>

        <?php if ($this->session->userdata('user_id')): ?>
            <!-- 로그인한 상태에서 보이는 메뉴 -->
            <a href="/contact">연락처</a>

            <!-- 관리자 권한을 가진 유저에게만 로그아웃 바로 앞에 노출 -->
            <?php if ($this->session->userdata('role') === 'admin'): ?>
                <a href="/admin" class="admin-menu">관리자페이지</a>
            <?php endif; ?>

            <!-- 로그아웃은 항상 가장 우측(마지막)에 위치하는 것이 자연스럽습니다 -->
            <a href="/login/logout">로그아웃</a>
        <?php else: ?>
            <!-- 로그인하지 않은 상태 -->
            <a href="/login">로그인</a>
        <?php endif; ?>

    </nav>
    <main>