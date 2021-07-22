<?php

    session_start();

    $link = mysqli_connect("localhost", "root", "", "vknow");

    error_reporting(0);

    if (mysqli_connect_errno()) {
        
        error_reporting(E_ALL);
        exit();
        
    }

  

    if ($_GET['function'] == "logout") {
        
        session_unset();
        
    }

       

    function displayTweets($type) {
        
        global $link;
        
        if ($type == 'public') {
            
            $whereClause = "";
                
        } else if ($type == 'isFollowing') {
            
            $query = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id']);
            $result = mysqli_query($link, $query);
            
            $whereClause = "";
            
            while ($row = mysqli_fetch_assoc($result)) {
                
                if ($whereClause == "") $whereClause = "WHERE";
                else $whereClause.= " OR";
                $whereClause.= " userid = ".$row['isFollowing'];
                
                
            }
            
        } else if ($type == 'yourtweets') {
            
           $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $_SESSION['id']);
            
        } else if ($type == 'search') {
            
            echo '<p>Showing search results for "'.mysqli_real_escape_string($link, $_GET['q']).'":</p>';
            
           $whereClause = "WHERE tweet LIKE '%". mysqli_real_escape_string($link, $_GET['q'])."%'";
            
        } else if (is_numeric($type)) {
            
            $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $type)." LIMIT 1";
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
            
            echo "<h2>".mysqli_real_escape_string($link, $user['email'])."'s Comments</h2>";
            
            $whereClause = "WHERE userid = ". mysqli_real_escape_string($link, $type);
            
            
        }
        
        
        $query = "SELECT * FROM tweets ".$whereClause." ORDER BY `datetime` DESC";
        
        $result = mysqli_query($link, $query);
        
        if (mysqli_num_rows($result) == 0) {
            
            echo "There are no Comment to display.";
            
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $userQuery = "SELECT * FROM users WHERE id = ".mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
                $userQueryResult = mysqli_query($link, $userQuery);
                $user = mysqli_fetch_assoc($userQueryResult);
                
                echo "<div class='tweet'><p><a href='?page=publicprofiles&userid=".$user['id']."'>".$user['email']."</a> <span class='time'>";
                
                echo "<p>".$row['tweet']."</p>";
                
                echo "<p><a class='toggleFollow' data-userId='".$row['userid']."'>";
                
                $isFollowingQuery = "SELECT * FROM isFollowing WHERE follower = ". mysqli_real_escape_string($link, $_SESSION['id'])." AND isFollowing = ". mysqli_real_escape_string($link, $row['userid'])." LIMIT 1";
            $isFollowingQueryResult = mysqli_query($link, $isFollowingQuery);
            if (mysqli_num_rows($isFollowingQueryResult) > 0) {
                
                echo "<button class='followUnfollow'>Unfollow</button>";
                
            } else {
                
                echo "<button class='followUnfollow'>Follow</button>";
                
            }
                
                
                echo "</a></p></div>";
                
            }
            
        }
        
        
    }

    function displaySearch() {
        
        echo '<form class="form-inline">
  <div class="form-group">
    <input type="hidden" name="page" value="search">
    <input type="text" name="q" class="form-control" id="search" placeholder="Search Comments">
  </div>
  <button type="submit" class="btn btn-primary">Search</button>
</form>';
        
        
    }

    function displayTweetBox() {
        
        if ($_SESSION['id'] > 0) {
            
            echo '<div id="tweetSuccess" class="alert alert-success">Your Comment was posted successfully.</div>
            <div id="tweetFail" class="alert alert-danger"></div>
            <div class="form">
  <div class="form-group">
    <textarea class="form-control" id="tweetContent"></textarea>
  </div>
  <button id="postTweetButton" class="btn btn-primary">Post Comment</button>
</div>';
            
            
        }
        
        
    }

    function displayUsers() {
        
        global $link;
        
        $query = "SELECT * FROM users LIMIT 10";
        
        $result = mysqli_query($link, $query);
            
        while ($row = mysqli_fetch_assoc($result)) {
            
             echo "<p id='publicUser'> <span style='font-size:100px;'>&#128101;</span> <br><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
            
        }
        
        
        
    }

?>