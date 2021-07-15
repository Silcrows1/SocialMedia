<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
</body>

<script>
  
    $(document).ready(function() {
    $('.like').click(function(e) {
      var postid = event.target.id;
      var url = "<?php echo base_url(); ?>posts/like2";
      var post_id = $(this).closest("div.post").attr("id");
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
});
</script>
</html>




