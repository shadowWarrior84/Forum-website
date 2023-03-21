<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


    <style>
        #ques{
            min-height: 433px
        }
    </style>
    <title>Welcome to iDiscuss - Coding Forums</title>
</head>

<body>
    
    <?php include 'partials/_dbconnect.php';?>
    <?php include 'partials/_header.php'; ?>

    <?php

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }

    ?>

    <?php 
    $showAlert = false;  
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        // Insert into thread into db
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ( '$comment', '$id', '$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! please wait for community responds.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }
    
    
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $title;  ?> forums</h1>
            <p class="lead"><?php echo $desc;  ?></p>
            <hr class="my-4">
            <p>This peer to peer forum is sahring knowledge with each other.No Spam / Advertising / Self-promote in the forums is not allowed.
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Do not PM users asking for help. ...
                Remain respectful of other members at all times.</p>
            <p>Posted by:<b> Harry</b>
            </p>
        </div>
    </div>
    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
    <h1 class="py-2">Post a comment</h1>
    <form action="'. $_SERVER['REQUEST_URI'].'" method="post">
        
            <div class="form-floating">
                <textarea class="form-control" id="comment" name="comment"
                    style="height: 100px"></textarea>
                <label for="floatingTextarea2">Type your comment</label>
                <input type="hidden" name="sno" value="'.$_SESSION['id'].'">
            </div>
            <button type="submit" class="btn btn-success my-2">Post comment</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Post a comment.</h1>
        <p class="lead">You are not logged in. Please log in to post a comment.</p>
        </div>';
    }



    ?>

    <div class="container" id="ques">
        <h1 class="py-2">Discussion</h1>
         <?php

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
    $result = mysqli_query($conn, $sql);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];
        $thread_user_id = $row['comment_by'];
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
    
     echo '   <div class="media my3">
            <img class="mr-3" src="img/userdefault.png" width="34px" alt="Generic placeholder image">
            <div class="media-body">
            <p class="font-weight-bold my-0">'.$row2['user_email'].' at '.$comment_time.' </p>
                '.$content.'
            </div>
        </div>';
    }

    if($noResult){
        echo '<div class="card my-2">
        <div class="card-header">
          No Threads Found
        </div>
        <div class="card-body">
          <h5 class="card-title">Be the first person to comment</h5>
        </div>
      </div>';
    }
    ?> 


        <!-- <div class="media my3">
            <img class="mr-3" src="img/userdefault.png" width="34px" alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">Unable to install Pyaudio in windows</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->

        
    </div>

    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>