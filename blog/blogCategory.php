<?php 
    include "../connect/connect.php";
    include "../connect/session.php";

    $category = $_GET['category'];

    if(isset($_GET['page'])){
      $page = (int) $_GET['page'];
  } else {
      $page = 1;
  }
  $viewNum = 6;
  $viewLimit = ($viewNum * $page) - $viewNum;
    
    //데이터 저장
    $categorySql = "SELECT * FROM myBlog WHERE blogDelete = 0 AND blogCategory = '$category' ORDER BY myBlogID DESC LIMIT {$viewLimit}, {$viewNum}";
    $categoryResult = $connect -> query($categorySql);
    $categoryInfo = $categoryResult -> fetch_array(MYSQLI_ASSOC);
    $categoryCount = $categoryResult -> num_rows;
?> 

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 사이트 만들기 - 블로그</title>

    <?php include "../include/head.php" ?>
</head>
<body>
    <div id="skip">
        <a href="#header">헤더 영역 바로가기</a>
        <a href="#main">컨텐츠 영역 바로가기</a>
        <a href="#footer">푸터 영역 바로가기</a>
    </div>
    <!-- //skip -->

    <?php include "../include/header.php" ?>
    <!-- //header -->

    <main id="main">
        <section id="blog" class="container">
            <div class="blog__inner">
                <div class="blog__title">
                    <h2 class="blog__title__h1"><?=$categoryInfo['blogCategory']?></h2>
                    <p><?=$categoryInfo['blogCategory']?>와 관련된 글이 <?=$categoryCount?>개 있습니다.</p>
                </div>
                <div class="blog__contents">
                   <div class="card__inner horizon column2">
<?php foreach($categoryResult as $blog){ ?>
        <div class="card">
            <figure class="card__header">
                <img src="../assets/blog/<?=$blog['blogImgFile']?>" alt="vscode에 scss설치하기">
                <a href="blogView.php?blogID=<?=$blog['myBlogID']?>" class="go" title="컨텐츠 바로가기"></a>
                <span class="cate"><?=$blog['blogCategory']?></span>
            </figure>
            <div class="card__contents">
              <div class="title">
                <a href="blogView.php?blogID=<?=$blog['myBlogID']?>">
                    <h3><?=$blog['blogTitle']?></h3>
                    <p><?=$blog['blogContents']?></p>
                </a>
              </div>

            </div>
        </div>
<?php    }?>

                   </div>
                </div>
                <!-- //blog__contents -->

                <div class="blog__aside">
                    <div class="aside__intro">
                        <div class="img">
                            <img src="../assets/img/banner_bg01.jpg" alt="배너 이미지">
                        </div>
                        <div class="desc">
                            어떤 일이라도 <em>노력</em>하고 즐기면 그 결과는 <em>빛</em>을 바란다고 생각합니다.
                        </div>
                    </div>
                    <article class="aside__cate">
                        <h3>카테고리</h3>
                        <ul class="cate">
                            <li><a href="blogCategory.php?category=javascript">javascript</a></li>
                            <li><a href="blogCategory.php?category=jquery">jquery</a></li>
                            <li><a href="blogCategory.php?category=html">HTML</a></li>
                            <li><a href="blogCategory.php?category=css">CSS</a></li>
                        </ul>
                    </article>
                    <article class="aside__cate">
                        <h3>최신 글</h3>
                        <ul class="co">
                        <?php
    $blogNewSql = "SELECT * FROM myBlog WHERE blogDelete = 0 ORDER BY myBlogID DESC LIMIT 4";
    $blogNewResult = $connect -> query($blogNewSql);
    
    foreach($blogNewResult as $blogNew) {?>
        <li>
            <a href="blogView.php?blogID=<?=$blogNew['myBlogID']?>"><span><img src="../assets/blog/<?=$blogNew['blogImgFile']?>" alt="<?=$blogNew['blogTitle']?>"></span>
                 <em><?=$blogNew['blogTitle']?></em>
            </a>
        </li>
  <?php  } ?>
                        </ul>
 
                    </article>
                    <article class="aside__cate">
                        <h3>인기 글</h3>
                        <?php
    $blogNewSql = "SELECT * FROM myBlog WHERE blogDelete = 0 ORDER BY myBlogID DESC LIMIT 4";
    $blogNewResult = $connect -> query($blogNewSql);
    
    foreach($blogNewResult as $blogNew) {?>
        <li>
            <a href="blogView.php?blogID=<?=$blogNew['myBlogID']?>"><span><img src="../assets/blog/<?=$blogNew['blogImgFile']?>" alt="<?=$blogNew['blogTitle']?>"></span>
                 <em><?=$blogNew['blogTitle']?></em>
            </a>
        </li>
  <?php  } ?>
                    </article>
                    <article class="aside__cate">
                        <h3>최신 댓글</h3>
                        <ul class="comt">
                        <?php
    $commentNewSql = "SELECT * FROM myComment WHERE commentDelete = 0 ORDER BY myCommentID DESC LIMIT 5";
    $commentNewResult = $connect -> query($commentNewSql);
    foreach($commentNewResult as $commentNew) { ?>
        <li>
            <a href="blogView.php?blogID=<?=$commentNew['myBlogID']?>"><?=$commentNew['commentMsg']?></a>
        </li>
  <?php }?>
                        </ul>
                    </article>
                </div>
        </section>
    </main>
    <!-- //main -->

    <?php include "../include/footer.php" ?>
    <!-- //footer -->
</body>
</html>