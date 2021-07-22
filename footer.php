<footer class="footer">

    <div class="container">
        
        <p id="copyright">&copy; All rights reserved to VKnow 2021</p>
    
    </div>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="loginModalTitle">Login</h4>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger" id="loginAlert"></div>
        <form>
            <input type="hidden" id="loginActive" name="loginActive" value="1">
  <fieldset class="form-group">
    <label for="email">Email</label>
    <input name="email" type="email" class="form-control" id="email" placeholder="Email id">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </fieldset>
  <fieldset class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password">
  </fieldset>
</form>
      </div>
      <div class="modal-footer">
          <span id="haveAccount">Don't have an account? </span> <a id="toggleLogin">Sign up  </a>
       
        <button type="button" id="loginSignupButton" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>


<script>

    $("#toggleLogin").click(function() {
        
        if ($("#loginActive").val() == "1") {
            
            $("#loginActive").val("0");
            $("#loginModalTitle").html("Sign Up");
            $("#loginSignupButton").html("Sign Up");
            $("#toggleLogin").html("Login");
            $("#haveAccount").html("Already have an account? ");
            
        } else {
            
            $("#loginActive").val("1");
            $("#loginModalTitle").html("Login");
            $("#loginSignupButton").html("Login");
            $("#toggleLogin").html("Sign up");
            $("#haveAccount").html("Don't have an account? ");
            
        }
        
        
    })
    
    $("#loginSignupButton").click(function() {
        
        $.ajax({
            type: "POST",
            url: "actions.php?action=loginSignup",
            data: "email=" + $("#email").val() + "&password=" + $("#password").val() + "&loginActive=" + $("#loginActive").val(),
            success: function(result) {
                if (result == "1") {
                    
                    window.location.assign("http://localhost:8080/completeweb/#");
                    
                } else {
                    
                    $("#loginAlert").html(result).show();
                    
                }
            }
            
        })
        
    })

    $(".toggleFollow").click(function() {
        
        var id = $(this).attr("data-userId");
        
        $.ajax({
            type: "POST",
            url: "actions.php?action=toggleFollow",
            data: "userId=" + id,
            success: function(result) {
                
                if (result == "1") {
                    
                    $("a[data-userId='" + id + "']").html("<button class='followUnfollow'>Follow</button>");
                    
                } else if (result == "2") {
                    
                    $("a[data-userId='" + id + "']").html("<button class='followUnfollow'>Unfollow</button>");
                    
                }
            }
            
        })
        
    })
    
    $("#postTweetButton").click(function() {
        
        $.ajax({
            type: "POST",
            url: "actions.php?action=postTweet",
            data: "tweetContent=" + $("#tweetContent").val(),
            success: function(result) {
                
                if (result == "1") {
                    
                    $("#tweetSuccess").show();
                    $("#tweetFail").hide();
                    
                } else if (result != "") {
                    
                    $("#tweetFail").html(result).show();
                    $("#tweetSuccess").hide();
                    
                }
            }
            
        })
        
    })
    
</script>


  </body>
</html>