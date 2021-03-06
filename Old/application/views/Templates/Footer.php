<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" defer></script>
</main>
</body>

<script>
  $(document).ready(function() {

    //Change font size functions if user is logged in//
    <?php if ($this->session->userdata('logged_in')) : ?>
      var font = <?php echo $this->session->userdata('TextSize') ?>

      //set font size amount in %.
      var requestedfont;
      if (font == 1) {
        requestedfont = 100;
      } else if (font == 2) {
        requestedfont = 105;
      } else if (font == 3) {
        requestedfont = 110;
      }


      //run checkFontSize
      checkFontSize();

      //retrieve all divs into a variable
      function checkFontSize() {
        var elems = document.querySelectorAll("div");

        //for each element, called scale font size
        [].forEach.call(elems, function(el) {
          scaleFontSize(el);
        });
      }

      //scale font size function
      function scaleFontSize(element) {

        //change font size
        element.style.fontSize = requestedfont + '%';

        //if element scroll width is greater than client width, reduce letter spacing.
        if (element.scrollWidth > element.clientWidth) {
          element.style.letterSpacing = "-0.05em";
        }
        //if element scroll width is still greater than client width, reduce letter spacing and set font size back to 100%.
        if (element.scrollWidth > element.clientWidth) {
          element.style.letterSpacing = "0";
          element.style.fontSize = "100%";
        }
      }
    <?php endif ?>
    //check if user is logged in//
    <?php if ($this->session->userdata('logged_in')) : ?> {
        //if user recieved admin socket call, append accept button to myModal popup 
        socket.on("admin", function(data) {
          console.log(data);
          $('<a class="text-center" id="accept" href="<?php echo base_url(); ?>Messages/' + data.userId + '"><h2 class="acceptbtn">Accept</h2></a>').appendTo('.adminpop');
          document.getElementById('myModal').title = data.userId;
          modal.style.display = "block";
          var data = data;
        });
      }
      //if user accepts chat request from admin, emit accepted
      $("body").on("click", '#accept', function(e) {
        socket.emit("accepted", {
          userId: <?php echo $this->session->userdata('user_id') ?>,
          recieverId: document.getElementById('myModal').title,
        });
      });
    <?php endif ?>

    //set typing element to display none on first load
    if (document.getElementById("typing")) {
      document.getElementById("typing").style.display = "none";
    }

    //like button function
    $('.Likebtn').click(function(e) {

      //get target title
      var postid = event.target.title;
      var url = "<?php echo base_url(); ?>posts/like2";

      //post like to database
      jQuery.ajax({
        type: "POST",
        url: url,
        dataType: "html",
        data: {
          id: postid
        },
        success: function(result) {
          var found = $.parseJSON(result);

          //get innerHTML of element
          var contents = document.getElementById('submit' + postid).innerHTML;
          contentnew = contents.trim();

          //call change and like function
          change();
          Like();

          //Change element text to oposite text to starting text
          function change(contentsnew) {
            var like = "Like";
            var liked = "You liked this";
            console.log(contentnew);
            if (contentnew == like) {
              document.getElementById('submit' + postid).textContent = liked;
            } else {
              document.getElementById('submit' + postid).textContent = like;
            }
          }
          //change like text depending on the number of likes
          function Like() {
            console.log(found[0]);
            if (found[0] == 0) {
              document.getElementById(postid).innerHTML = ('');
            } else if (found[0] > 1) {
              document.getElementById(postid).innerHTML = String(found[0]) + ' likes';
            } else {
              document.getElementById(postid).innerHTML = String(found[0]) + ' like';
            }
          }
        }

      });
      e.preventDefault();
    });

    //Add a comment//
    $('.commentsubmit').click(function(e) {
      var postid = event.target.title;
      if ($('textarea#addcomment' + postid).val() != "") {
        var comment = $('textarea#addcomment' + postid).val();

        var url = "<?php echo base_url(); ?>comments/createComment";

        jQuery.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            id: postid,
            comment: comment
          },
          success: function(result) {
            var dt = new Date();
            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
            var parentNode = document.querySelector('.viewcommentsingle' + postid);


            var response = $.parseJSON(result);
            console.log(response);
            $('<div id ="comment' + response[2] + '"class="post viewcommentsingle' + postid + ' comment row"><div class="col-2 col-md-1"><img class="profile "src="' + '<?php echo base_url('assets/images/' . $this->session->userdata('Picture')) ?>' + '"></div><div class="col-10 col-md-11 commentdetails"><div class="row"><P>' + '<?php echo $this->session->userdata('FirstName') ?>' + ' ' + '<?php echo $this->session->userdata('LastName') ?>' + '</P></div><div class="row"><P class="date">Posted Now</P></div></div><p class="paddingchat"> ' + comment + '</p><a class="delete" id="' + postid + '" title="' + String(response[2]) + '" >X</a></div>').prependTo('.viewcomments' + postid);


            $('textarea#addcomment' + postid).val("");
            if (response[1] == 0) {
              document.getElementById('comment' + postid).innerHTML = ('');
              document.getElementById('viewcommentid' + postid).innerHTML = ('Add Comment');
            } else if (response[1] > 1) {
              document.getElementById('comment' + postid).innerHTML = String(response[1]) + ' Comments';
              document.getElementById('viewcommentid' + postid).innerHTML = ('View Comments');
            } else {
              document.getElementById('comment' + postid).innerHTML = String(response[1]) + ' Comment';
              document.getElementById('viewcommentid' + postid).innerHTML = ('View Comments');
            }


          }

        });
      }
      e.preventDefault();
    });

    var isSliding = false;

    //////////view comments function on click//////////////////////////////
    $('.comment').click(function(e) {

      //if function has been called and not finished, prevent running again//
      if (isSliding) {
        return false;
      }

      //set isSliding (function running) to true//
      isSliding = true;

      var postid = event.target.title;
      var x = document.getElementById('viewcomment' + postid)

      /////////////if div contains class name hidden, change to show, else change to hidden////////////////////////////////
      if (x.className == "form-row hidden") {
        document.getElementById('viewcomment' + postid).setAttribute("class", "form-row show");
        getcomment();
      } else {
        document.getElementById('viewcomment' + postid).setAttribute("class", "form-row hidden");
        $(".viewcommentsingle" + postid).remove();
        isSliding = false;
      }
      <?php if ($this->session->userdata('logged_in')) : ?>

        /////////////retrieve comments for post and append to div when clicking view comments/////////
        function getcomment() {
          var url = "<?php echo base_url(); ?>comments/getComments";
          jQuery.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
              id: postid
            },
            success: function(result) {
              var response = result;

              var i = 0

              //////foreach comment found, append to parent////////////
              $.each(response, function(index, value) {
                if (value.User_id == <?php echo ($this->session->userdata['user_id']) ?> || value.posterid == <?php echo ($this->session->userdata['user_id']) ?>) {
                  $('<div class="post viewcommentsingle' + value.Post_id + '  comment row" id="comment' + value.comment_id + '"><div class="col-2 col-md-1"><img class="profile "src="<?php echo base_url(); ?>assets/images/' + value.Picture + '"></div><div class="col-10 col-md-11 commentdetails"><div class="row"><P>' + value.FirstName + ' ' + value.LastName + '</P></div><div class="row"><P class="date">' + value.created_at + '</P></div></div><p class="paddingchat"> ' + value.comment + '</p><a class="delete" id="' + value.Post_id + '" title="' + value.comment_id + '" >X</a></div>').appendTo('.viewcomments' + postid);
                  i++
                } else {
                  $('<div class="post viewcommentsingle' + value.Post_id + '  comment row"><div class="col-2 col-md-1"><img class="profile "src="<?php echo base_url(); ?>assets/images/' + value.Picture + '"></div><div class="col-10 col-md-11 commentdetails"><div class="row"><P>' + value.FirstName + ' ' + value.LastName + '</P></div><div class="row"><P class="date">' + value.created_at + '</P></div></div><p class="paddingchat"> ' + value.comment + '</p></div>').appendTo('.viewcomments' + postid);
                }

              });
              //set function running isSliding variable to false when its finished running//
              isSliding = false;
            }
          });
          e.preventDefault();
        }
      <?php endif ?>
    });

    //Delete profile button click function
    $('.deleteProfile').click(function(e) {

      var x = document.getElementById('deletebox')

      if (x.className == "row deletebox hidden") {
        document.getElementById('deletebox').setAttribute("class", "row deletebox show");
        document.getElementById('Deletebutton').setAttribute("class", "deleteProfile hidden");
      } else {
        document.getElementById('deletebox').setAttribute("class", "row deletebox hidden");
      }
    });

    //Confirm account delete button click
    $('.confirmdelete').click(function(e) {

      var x = document.getElementById('confirmationinput').value;
      var y = event.target.id;
      var url = "<?php echo base_url(); ?>users/deleteAccount";

      //Check inserted text matches Delete or dont delete.
      if (x == "Delete") {
        console.log(y + "delete now");
        jQuery.ajax({
          type: "POST",
          url: url,
          dataType: "html",
          data: {
            accountID: y,
          },
          success: function(result) {
            window.location.href = '<?php echo base_url(); ?>Home';
          }

        });
      } else {
        console.log("Wont delete");
      }
    });

    //remove friend button, on click, show confirmation box and hide option//
    $('.removeFriend').click(function(e) {

      var x = document.getElementById('confirmremove')

      if (x.className == "row removeconfirm hidden") {
        document.getElementById('confirmremove').setAttribute("class", "row removeconfirm show");
        document.getElementById('removeFriend').setAttribute("class", "deleteProfile hidden");
      } else {
        document.getElementById('deletebox').setAttribute("class", "row removeconfirm hidden");
      }
    });

    //On confirmation box click, remove friend and redirect home//
    $('.confirmedremove').click(function(e) {

      var id = event.target.id;
      var url = "<?php echo base_url(); ?>users/removeFriend";
      jQuery.ajax({
        type: "POST",
        url: url,
        dataType: "html",
        data: {
          friendID: id,
        },
        success: function(result) {
          window.location.href = '<?php echo base_url(); ?>Home';
        }
      });
    });

    //Password reminder / Forgot password click
    $('.forgot').click(function(e) {

      var x = document.getElementById('forgotten')

      if (x.className == "col forgotten hidden") {
        document.getElementById('forgotten').setAttribute("class", "col forgotten show");
        document.getElementById('forgotclick').setAttribute("class", "hidden");
      } else {
        document.getElementById('forgotten').setAttribute("class", "col forgotten hidden");
      }
    });

    //On confirmation box click, remove friend and redirect home//
    $('#getreminder').click(function(e) {
      e.preventDefault();

      //get entered value of email
      var email = document.getElementById('emailforgot').value
      console.log(email);
      var url = "<?php echo base_url(); ?>users/passwordreminder";

      jQuery.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: {
          email: email,
        },
        success: function(result) {
          var response = result;

          $.each(response, function(index, value) {
            console.log(value.Reminder);
            document.getElementById('forgotten').setAttribute("class", "col forgotten hidden");
            document.getElementById('forgotten').setAttribute("class", "col forgotten hidden");

            //Corresponsding questions set fro values stored.
            if (value.reminderquestion == "1") {
              var question = "Mothers Maiden Name";
            } else if (value.reminderquestion == "2") {
              var question = "The name of your first pet";
            } else if (value.reminderquestion == "3") {
              var question = "The first place you lived";
            } else if (value.reminderquestion == "4") {
              var question = "Your favourite holiday location";
            } else {
              var question = "Your favourite TV show";
            }
            //Append question reminder
            $('<br><br><div class="col"><p>Your password reminder was set as the following: </p><br><p>' + question + '</p></div>').appendTo('.reglink');
          });
        }
      });
    });
  });

  //DELETE Comment function
  $("body").on("click", '.delete', function(e) {
    var commentid = event.target.title;
    var comment = "comment"
    var target = comment + commentid;
    var Post_id = event.target.id;
    var url = "<?php echo base_url(); ?>comments/delete";

    jQuery.ajax({
      type: "POST",
      url: url,
      dataType: "html",
      data: {
        commentid: commentid,
        Post_id: Post_id,
      },
      success: function(result) {
        //display none for target comment
        document.getElementById(target).style.display = "none";
        var response = $.parseJSON(result);
        $('textarea#addcomment' + Post_id).val("");

        //Change option to either add comment or view comments depending on the number of comments found
        if (response[1] == 0) {
          document.getElementById('comment' + Post_id).innerHTML = ('');
          document.getElementById('viewcommentid' + Post_id).innerHTML = ('Add Comment');
        } else if (response[1] > 1) {
          document.getElementById('comment' + Post_id).innerHTML = String(response[1]) + ' Comments';
          document.getElementById('viewcommentid' + Post_id).innerHTML = ('View Comments');
        } else {
          document.getElementById('comment' + Post_id).innerHTML = String(response[1]) + ' Comment';
          document.getElementById('viewcommentid' + Post_id).innerHTML = ('View Comments');
        }
      }

    });
    e.preventDefault();
  });

  //Click event for view friends
  var friendfind = document.getElementById('friendfind');
  friendfind.style.cursor = 'pointer';
  friendfind.onclick = function() {
    changeCssClass('friendfind');
  };

  var refresh;
  ////function to minimise and maximise the friend list//////////////
  function changeCssClass(friendfind) {
    console.log(friendfind);
    if (document.getElementById(friendfind).className == 'minimize viewfriends') {
      document.getElementById(friendfind).className = 'maximize viewfriends';
      getfriends();
      ///////set interval to refresh friends list, set to 30 seconds/////////////
      refresh = setInterval(getfriends, 30000);

      //////function to retrieve all friends///////////
      function getfriends() {
        document.getElementById('friendList').innerHTML = "";
        /////ajax call to retrieve online friends///////
        var url = "<?php echo base_url(); ?>users/getOnlineFriends";
        jQuery.ajax({
          type: "POST",
          url: url,
          dataType: 'json',
          success: function(result) {
            var response = result;
            //////foreach comment found, prepend to parent to appear higher than offline users////////////
            $.each(response, function(index, value) {
              $('<ul class="Friend online" id="' + value.Usertwo_id + '"><span class="online">Online</span><a href="<?php echo base_url('Message/') ?>' + value.Usertwo_id + '">' + value.FirstName + ' ' + value.LastName + '</a></ul>').prependTo('.friendList');
            });
          }
        });

        /////ajax call to retrieve offline friends///////
        var url = "<?php echo base_url(); ?>users/getFriends";
        jQuery.ajax({
          type: "POST",
          url: url,
          dataType: 'json',
          success: function(result) {
            var response = result;
            //////foreach offline friend, append to parent////////////
            $.each(response, function(index, value) {
              $('<ul class="Friend offline" id="' + value.Usertwo_id + '"><span class="offline">Offline</span><a href="<?php echo base_url('Message/') ?>' + value.Usertwo_id + '">' + value.FirstName + ' ' + value.LastName + '</a></ul>').appendTo('.friendList');

            });
          }
        });
      }
    } else {
      /////when minimizing friend box, clear the interval and remove the contents/////
      clearInterval(refresh);
      document.getElementById(friendfind).className = 'minimize viewfriends';
      $(".Friend").remove();

    }
  }
</script>

</html>
<footer>
</footer>