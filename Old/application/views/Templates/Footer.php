<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
<script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>

</body>

<script>
  
$(document).ready(function() {

  if(document.getElementById("typing")){
  document.getElementById("typing").style.display = "none";
  }
  

    $('.Likebtn').click(function(e) {
      var postid = event.target.title;
      console.log(event.target.title);
      
      var url = "<?php echo base_url(); ?>posts/like2";
      //var post_id = $(this).closest("div.post").attr("id");
            jQuery.ajax({
                type: "POST",
                url: url,
                dataType: "html",
                data: {id: postid},
                success:function(result)
                {
                  var found = $.parseJSON(result);                                                  
    
                  var contents = document.getElementById('submit'+postid).innerHTML;
                  contentnew=contents.trim();
                  console.log(contentnew);
                  
                  change();
                  Like();                  
                  
                  function change(contentsnew){
                    var like = "Like";
                    var liked = "You liked this";
                    if (contentnew == liked)
                    {
                    document.getElementById('submit'+postid).textContent=like;                    
                    }
                    else
                    {
                    document.getElementById('submit'+postid).textContent=liked;
                    }
                  }

                  function Like(){
                   if (found[0]==0){
                     document.getElementById(postid).innerHTML=('');
                   }
                   else if (found[0]>1)
                   {
                   document.getElementById(postid).innerHTML=String(found[0])+' likes';
                   } 
                   else 
                   { 
                     document.getElementById(postid).innerHTML=String(found[0])+' like'; 
                   }
                  }             
              }
                
          });
          e.preventDefault();
    });
    $('.commentsubmit').click(function(e) {
            var postid = event.target.title;
            if ($('textarea#addcomment'+postid).val() != ""){
            var comment = $('textarea#addcomment'+postid).val();

            console.log(event.target.title);
            console.log(comment);
            var url = "<?php echo base_url(); ?>comments/createComment";
            //var post_id = $(this).closest("div.post").attr("id");
                  jQuery.ajax({
                      type: "POST",
                      url: url,
                      dataType: "html",
                      data: {
                        id: postid,
                        comment: comment
                      },
                      success:function(result)
                      {
                        var dt = new Date();
                        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                        var parentNode = document.querySelector('.viewcommentsingle'+ postid);
                        $('<div class="post viewcommentsingle'+postid+' row"><div class="col-1"><img class="profile "src="'+'<?php echo base_url('assets/images/'.$this->session->userdata('Picture'))?>'+'"></div><div class="col-11"><div class="row"><P>'+'<?php echo $this->session->userdata('FirstName')?>'+' '+'<?php echo $this->session->userdata('LastName')?>'+'</P></div><div class="row"><P>Posted Now</P></div></div><p> '+comment+'</p></div>').prependTo('.viewcomments'+ postid);
                        var response = $.parseJSON(result);  
                        $('textarea#addcomment'+postid).val("");
                        console.log(response);
                        if (response[1]==0){
                          document.getElementById('comment'+postid).innerHTML=('');
                        }
                        else if (response[1]>1)
                        {
                        document.getElementById('comment'+postid).innerHTML=String(response[1])+' Comments';
                        } 
                        else 
                        { 
                          document.getElementById('comment'+postid).innerHTML=String(response[1])+' Comment'; 
                        }
                        
                        
                    }
                      
                });
            }
                e.preventDefault();
          });

          //////////view comments function on click//////////////////////////////
          $('.viewcomment').click(function(e) {
            var postid = event.target.title;
            console.log(postid);
            
            var x = document.getElementById('viewcomment'+postid)

            /////////////if div contains class name hidden, change to show, else change to hidden////////////////////////////////
            if(x.className =="form-row hidden")
            {
            document.getElementById('viewcomment'+postid).setAttribute("class", "form-row show");
            getcomment();
            }
            else
            {
              document.getElementById('viewcomment'+postid).setAttribute("class", "form-row hidden");
              $(".viewcommentsingle"+postid).remove();
            } 

           
            /////////////retrieve comments for post and append to div when clicking view comments/////////
            function getcomment(){                  
             var url = "<?php echo base_url(); ?>comments/getComments";            
                  jQuery.ajax({
                      type: "POST",
                      url: url,
                      dataType: 'json',
                      data: {
                        id: postid
                      },
                      success:function(result)
                      {
                       var response = result;                   

                      var i=0

                      //////foreach comment found, append to parent////////////
                      $.each(response, function(index, value)
                        { 
                          $('<div class="post viewcommentsingle'+value.Post_id+' row"><div class="col-1"><img class="profile "src="<?php echo base_url(); ?>assets/images/'+value.Picture+'"></div><div class="col-11"><div class="row"><P>'+value.FirstName+' '+value.LastName+'</P></div><div class="row"><P>'+value.created_at+'</P></div></div><p> '+value.comment+'</p></div>').appendTo('.viewcomments'+ postid);
                        i++
                        });
                    }                      
                });                               
            e.preventDefault();  
          }        
          });          

});


     function changeCssClass(friendfind)
        {
            if(document.getElementById(friendfind).className=='minimize')
            {
                document.getElementById(friendfind).className = 'maximize';

                var url = "<?php echo base_url(); ?>users/getFriends";            
                  jQuery.ajax({
                      type: "POST",
                      url: url,
                      dataType: 'json',
                      success:function(result)
                      {
                       var response = result; 
                       console.log(result);                 

                      var i=0

                      //////foreach comment found, append to parent////////////
                      $.each(response, function(index, value)
                        { 
                          $('<ul class="Friend" id="'+value.Usertwo_id+'"><a href="<?php echo base_url('Message/')?>'+value.Usertwo_id+'">'+value.FirstName+' '+value.LastName+'</a></ul>').appendTo('.friendList'); 

                        });
                    }                      
                });                               
           
            }
            else
            {
                document.getElementById(friendfind).className = 'minimize';
                $(".Friend").remove();
            }
        }


</script>
</html>




