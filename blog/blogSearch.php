<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blogSearch</title>
    <?php
        include "../include/head.php";
    ?>
</head>
<body>
    <div id="skip">
        <a href="#header">헤더 영역 바로가기</a>
        <a href="#main">컨텐츠 영역 바로가기</a>
        <a href="#footer">푸터 영역 바로가기</a>
    </div>
    <!-- // skip -->
    
    <?php include "../include/header.php";?>
    <!-- // header -->

    <main id="main">
        <section id="card" class="container">
            <h2 class="blind">게시판 영역 입니다.</h2>
            <div class="card__wrap">
                <div class="board__title3">
                    <h3>검색 결과 게시판</h3>
                    <?php
                        function msg($alert) {
                            echo "<p>총 ".$alert." 건이 검색 되었습니다.</p>";
                        }

                        if(isset($_GET['page'])) {
                            $page = (int)$_GET['page'];
                        }
                        else {
                            $page = 1;
                        }

                        $searchKeyword = $_GET['searchKeyword'];
                        $searchOption = 'title';
                        $searchKeyword = $connect -> real_escape_string(trim($searchKeyword));
                        echo $sql;
                        $sql = "SELECT b.myBlogID, b.blogTitle, b.blogContents, m.youName, b.blogRegTime, b.blogView,b.blogImgFile,b.blogCategory FROM myBlog b JOIN myMember m ON(b.myMemberID = m.myMemberID) ";
                        switch($searchOption) {
                            case "title":
                                $sql .= "WHERE b.blogTitle LIKE '%{$searchKeyword}%' ORDER BY myBlogID DESC ";
                                break;
                        }

                        $result = $connect -> query($sql);

                        $totalCount = $result -> num_rows;
                        msg($totalCount);
                    ?>
                    <a 
                        href="blog.php"
                    >이전으로</a>
                </div>
                <div class="card__inner">
                <?php
                    $viewNum = 8;
                    $viewLimit = ($viewNum * $page) - $viewNum;

                    $sql .= "LIMIT {$viewLimit}, {$viewNum};";
                    $result = $connect -> query($sql);
                    if($result) {
                        foreach($result as $blog) { 
                ?>
                            <div class="card">
                                <figure class="card__header">
                                    <img src="../assets/blog/<?=$blog['blogImgFile']?>" alt="카드1번">
                                    <a href="blogView.php?blogID=<?=$blog['myBlogID']?>" class="go" title="컨텐츠 바로가기"></a>
                                    <span class="cate"><?=$blog['blogCategory']?></span>
                                </figure>
                                <div>
                                    <a href="blogView.php?blogID=<?=$blog['myBlogID']?>">
                                        <h3 class="tit"><?=$blog['blogTitle']?></h3>
                                        <p class="desc"><?=$blog['blogContents']?></p>
                                    </a>
                                </div>
                                
                            </div>
                <?php
                        }
                    }
                ?>
                </div>
                <div class="card__pages">
                    <ul>
                        <?php
                            // 총 페이지 개수
                            $boardCount = ceil($totalCount / $viewNum);

                            // 현재 페이지를 기준으로 보여주고 싶은 개수
                            $pageCurrent = 5;
                            $startPage = $page - $pageCurrent;
                            $endPage = $page + $pageCurrent;

                            // 처음 페이지 초기화
                            if($startPage < 1) {
                                $startPage = 1;
                            }

                            // 마지막 페이지 초기화
                            if($endPage > $boardCount) {
                                $endPage = $boardCount;
                            }

                            // 이전, 처음
                            if($page !== 1) {
                                $prevPage = $page - 1;
                                echo "<li><a href='./blogSearch.php?page=1&searchKeyword={$searchKeyword}'>&lt;&lt;</a></li>";
                                echo "<li><a href='./blogSearch.php?page={$prevPage}&searchKeyword={$searchKeyword}'>&lt;</a></li>";
                            }
                            
                            // 페이지 넘버 표시
                            for($i = $startPage; $i <= $endPage; $i++) {
                                $active = "";
                                if($i === $page) $active = "active";
                                echo "<li class = '{$active}'><a href='./blogSearch.php?page={$i}&searchKeyword={$searchKeyword}'>$i</a></li>";
                            }

                            // 다음, 마지막
                            if($page > 1 && $page != $endPage) {
                                $nextPage = $page + 1;
                                echo "<li><a href='./blogSearch.php?page={$nextPage}&searchKeyword={$searchKeyword}'>&gt;</a></li>";
                                echo "<li><a href='./blogSearch.php?page={$boardCount}&searchKeyword={$searchKeyword}'>&gt;&gt;</a></li>";
                            }
                        ?>
                    </ul>
                </div>
            </div> 
        </section>
    </main>
    <!-- // main -->
    
    <?php include "../include/footer.php";?>
    <!-- //footer -->
</body>
</html>