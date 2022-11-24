<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 사이트 만들기</title>
    <?php include "../include/head.php"?>
</head>
<body>
    <div id="skip">
        <a href="#header">헤더 영역 바로가기</a>
        <a href="#main">컨텐츠 영역 바로가기</a>
        <a href="#footer">푸터 영역 바로가기</a>
    </div>
    <!-- //skip -->
    <?php include "../include/header.php"?>
    <!-- //header -->

    <main id="main">
      <section id="banner">
        <h2 class="blind">블로그 소개입니다.</h2>
        <div class="banner__inner container under">
            <div class="img">
                <img src="../assets/img/banner_bg01.jpg" alt="배너 이미지">
            </div>
            <div class="desc">
                어떤 일이라도 <em>노력</em>하고 즐기면 그 결과는 <em>빛</em>을 바란다고 생각합니다.
                신입의 <em>열정</em>과 <em>도전정신</em>을 깊숙히 새기며 <em>배움</em>에 있어 겸손함을
                유지하며 세부적인 곳까지 파고드는 멋진 <em>개발자</em>가 되겠습니다.
            </div>
        </div>
      </section>
      <!-- //banner -->
      <section id="card" class="container card__wrap">
        <h2>topic</h2>
        <a href="../blog/blogWrite.php" style="float:right;" class="write">글쓰기</a>
        <div class="card__inner">
            <?php
                // if(isset($_GET['page'])) {
                //     $page = (int)$_GET['page'];
                // }
                // else {
                //     $page = 1;
                // }
                // $viewNum = 8;
                // $viewLimit = ($viewNum * $page) - $viewNum;
                $sql = "SELECT * FROM myBlog WHERE blogDelete = 0 ORDER BY myBlogID DESC LIMIT 8";
                $result = $connect -> query($sql);

                foreach($result as $blog) { ?>
                    <div class="card">
                        <figure class="card__header">
                            <img src="../assets/blog/<?=$blog['blogImgFile']?>" alt="블로그 글">
                            <a href="../blog/blogView.php?blogID=<?=$blog['myBlogID']?>" class="go" title="컨텐츠 바로가기"></a>
                            <span class="cate"><?=$blog['blogCategory']?></span>
                        </figure>
                        <div>
                            <a href="../blog/blogView.php?blogID=<?=$blog['myBlogID']?>">
                                <h3 class="tit"><?=$blog['blogTitle']?></h3>
                                <p class="desc"><?=$blog['blogContents']?></p>
                            </a>
                        </div>
                        
                    </div>
                <?php
                }
                ?>
            <!-- // card01 -->
        </div>
    </section>
    <section id="board" class="container section">
      <h2 class="board__top">게시판 새 글</h2>
      <a href="../board/boardWrite.php" style="float:right;" class="write">글쓰기</a>
      <div class="board__inner">
        <div class="board__table table">
                    <table class="main__board">
                        <colgroup>
                            <col style="width: 5%">
                            <col>
                            <col style="width: 10%">
                            <col style="width: 10%">
                            <col style="width: 7%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>제목</th>
                                <th>등록자</th>
                                <th>등록일</th>
                                <th>조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
          $sql2 = "SELECT b.boardID, b.boardTitle, m.youName, b.regTime, b.boardView FROM myBoard b JOIN myMember m ON (b.myMemberID = m.myMemberID) ORDER BY boardID DESC LIMIT 8";
          $result = $connect -> query($sql2);
          foreach($result as $board){
        ?>
                          <tr>
                            <td><?=$board['boardID']?></td>
                            <td><a href='../board/boardView.php?boardID=<?=$board['boardID']?>'><?=$board['boardTitle']?></a></td>
                            <td><?=$board['youName']?></td>
                            <td><?=date('Y-m-d', $board['regTime'])?></td>
                            <td><?=$board['boardView']?></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                    </table>


        </div>
      </div>
    </section>

    </main>
    <!-- //main -->

    <?php include "../include/footer.php"?>
    <!-- //footer -->
</body>
</html>