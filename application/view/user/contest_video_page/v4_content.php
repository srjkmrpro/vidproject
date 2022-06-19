 
 <style type="text/css">
   
.comment-main{
   background-color: #74C2E1;
   box-shadow: 1px 2px 6px 2px #005B9A;
}
.comment-main ul{
   list-style: none;
}
.sub-cmt-img{
   width: 55px !important;
    height: 55px !important;
    border-radius: 50%;
} 
.list-unstyled li a{
   font-size: 30px;
   color:red;
}
.main-cmt-img{
    width: 40px !important;
    height: 40px !important;
    border-radius: 50%;
}
.border-bottom{
   font-size: 13px;
   border-bottom: 1px solid #d3d3d3;
}
.user-comment{
   background-color: #f3f3f3 !important;
    box-shadow: 0px 5px 8px -4px #c1c1c1;
}
.user-comment-desc, .user-comment span{
   color: #a0a0a0;
}
.user-comment-desc p{
   font-size: 12px;
   display: inline-block;
   float: left;
}
.send-icon i{
   font-size: 20px;
   background: #f3f3f3;
   padding: 6px 5px;
   border-radius: 50%;
   color: #74C2E1;
   height: 35px;
   width: 35px;
}
.user-comment:before{
    content: "";
    height: 0;
    width: 0;
    top: 0;
    left: -10px;
    position: absolute;
    border-style: solid;
    border-width: 13px 0 0 13px;
   border-color: #f3f3f3 transparent transparent transparent; 
}
 </style>
 <style>
/*-- Global Selectors --*/
a{
    color:#47649F;
}

body{
    font-family:'helvetica';    
}

/*-- Bootstrap Override Style --*/


/*-- Content Style --*/
.post-footer-option li{
    float:left;
    margin-right:50px;
    padding-bottom:15px;
}

.post-footer-option li a{
    color:#AFB4BD;
    font-weight:500;
    font-size:0/5rem;
}

.photo-profile{
    border:1px solid #DDD; 
    border-radius: 50%;   
}

.anchor-username h4{
    font-weight:bold;    
}

.anchor-time{
    color:#000;
    font-size:12px;
    margin-top:-8px;

}

.post-footer-comment-wrapper{
    background-color:#F6F7F8;
}
</style>
               <div class="container-fluid pb-0">
               <div class="video-block section-padding">
                  <?php
                  foreach ($vedios as $key => $vid) {
                     if($vid==null)
                     {
                       
                     }
                     else
                     {
                        $sql1= mysqli_query($call_config->con,"select * from tbl_user_master where id='".$vid['uid']."'");
                         $res = mysqli_fetch_array($sql1);
                         $sql2= mysqli_query($call_config->con,"select * from tbl_category_master where id='".$vid['cat_id']."'");
                         $ress = mysqli_fetch_array($sql2);
                          $count=$call_config->get("SELECT COUNT(*) FROM `tbl_user_follow_master` where fuid='".$vid['uid']."'");
                          $getsubs=implode(' ',$count);                       
                        $h=$vid['hashtag'];
                        $c=$vid['cat_id'];
                        $uid=$vid['uid'];

                         ?>
<?php
$ads=$call_config->get("SELECT vtbl.id as v_id,vtbl.thumbnail as thumbnail, vtbl.file as file,atbl.id as id FROM `tbl_video_master` as vtbl RIGHT join tbl_ads_video_list_master as atbl on vtbl.id = atbl.vid ORDER BY rand() LIMIT 1");
?>
                          <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
<video autoplay preload="metadata" width="100%" height="315" id="ads_tag" poster="<?= $call_config->base_url() ?>thumbnail/<?= $ads['thumbnail'];?>" src="<?= $call_config->base_url() ?>videos/<?= $ads['file'];?>" ></video>
<video style="display: none;" width="100%" id="video_tag" height="315" poster="<?= $call_config->base_url() ?>thumbnail/<?= $vid['thumbnail'];?>" src="<?= $call_config->base_url() ?>videos/<?= $vid['file'];?>" controls frameborder="0" allowfullscreen></video>
                           </div>
<script type="text/javascript">
  var myvid = document.getElementById('ads_tag');
myvid.addEventListener('ended', function(e) {
  //myvid.src = '<?= $call_config->base_url() ?>videos/<?= $vid['file'];?>';
  $("#ads_tag").hide();
  $("#video_tag").show();
  $("#video_tag")[0].play();
  //$("#ads_tag").attr('autoplay');
  add_impression(<?= $ads['v_id'] ?>,"ads");
});
var myvideo = document.getElementById('video_tag');
myvideo.addEventListener('ended', function(e) {
  add_impression(<?= $vid['id'] ?>,"normal");
});
</script>

                           <div class="single-video-title box mb-1">
                              <h2><a href="#"><?= $vid['name'];?></a></h2>
                              <p class="mb-0"><i class="fas fa-eye"></i> <?php
$v_count=$call_config->get("SELECT count(*) as total FROM `tbl_video_impression_master` WHERE `vid`='".$vid['id']."'");
                 echo    $v_count['total'];?>  views</p>
                           </div>
                           <div class="single-video-author box mb-2">
                              
                              <div class="float-right">
                              </div>
                              <p>
                                 <a class="btn btn-sm btn-danger Vote" id="Vote" name="choice"> <i class="fas fa-thumbs-up" id="lthumb"></i> Vote </a>
                              

                                   <a class="btn btn-sm btn-danger devote" id="devote" name="choice" style="color:white;"> <i class="fas fa-thumbs-down"></i> Devote </a>
                                    <a href="#commentbox" class="btn btn-sm btn-danger" type="button" id="comments">
                                 <i class="fas fa-comment"></i> Comment </a> 
                                     
                                      
                              </p>
                              &nbsp;&nbsp;<small id="lcount"></small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <small id="ucount"></small>
                              </div>
                           
                           <div class="single-video-author box mb-3">
                              <div class="float-right">
                                <?php
                                if($uid!=$user_sess_data['sess_user_id'])
                                  {
                                    ?>
                                    <p id="sbtn"> 
                                <button class="btn btn-sm btn-danger" onclick="subscribe(<?= $uid; ?>)" type="button" id="subbtn"><span id="smsg">Subscribe</span> </button>
                                <strong></strong>
                                
                              </p>
                                <small class="ml-3"><?php
                                  if($getsubs>1)
                                  {
                                    echo  $getsubs." subscribers";
                                  }
                                  else
                                    {
                                       echo  $getsubs." subscriber";

                                    }?></small>

                               <!-- <button class="btn btn btn-outline-danger" type="button"><i class="fas fa-bell"></i></button> -->

                                          <!-- unsubscribe Modal-->
      <div class="modal fade" id="unsubscribe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Are You Sure ?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">Select "Unsubscribe" below if you Don't Wanna hear from <b><?= $res['name'];?></b></div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" onclick="unsubscribe(<?= $uid; ?>)" href="#">Unsubscribe</a>
               </div>
            </div>
         </div>
      </div>
               <!-- unsubscribe Modal end-->
                                 <?php
                             }?>
                               <script type="text/javascript">
                                 function subscribe($uid)
                                      
                                 {
                                     var fuid=$uid;
                                     var choice='subscribe';
                                       $.ajax({
                                      url:'<?php echo $call_config->base_url().'application/modal/user/utility/subscribe.php'?>',
                                      type:'POST',
                                      data:{fuid:fuid,choice:choice},
                                     
                                      success:function(data){
                                      var res=JSON.parse(data);
                                       if (res['status']==true) 
                                       {
                                        $('#smsg').html('Subscribed <span id="bell"></span>');
                                        $('#bell').append('<i class="fas fa-bell"></i>');
                                        $('#bell').css('color','#fff'); 

                                        $('#smsg').css('font-weight','Bolder');
                                        $('#smsg').css('font-size','14px');
                                         $('#smsg').css('color','#e2e2e2');
                                        
                                       }    
                                       else
                                       {
                                       
                                      $("#unsubscribe").modal({backdrop: true});
                                       }
                                          
                                      }
                                      });
                                        

                                 }

                                 function unsubscribe($uid)
                                 {
                                  var fuid=$uid;
                                  var choice='unsubscribe';
                                 
                                  $.ajax({
                                      url:'<?php echo $call_config->base_url().'application/modal/user/utility/subscribe.php'?>',
                                      type:'POST',
                                      data:{fuid:fuid,choice:choice},
                                     
                                      success:function(data){
                                      //var res=JSON.parse(data);
                                      location.reload();
                                    }
                                      });
                                 }

                               </script>
                             </div>
                              <img class="img-fluid" src="<?= $call_config->base_url() ?>app-assets/user/user_image/<?= $res['photo']?>" alt="">
                              <p><a href="<?= $call_config->base_url() ?>application/view/user/userchannel/?id=<?= base64_encode($res['id']) ?>"><strong><?= $res['name'];?></strong></a> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></p>
                              <small>Published <?= $call_config->get_time_difference('now',$vid['con']) ?></small>
                           </div>
                             
                          

                           <div class="single-video-info-content box mb-3" id="description">
                              
                              <h6>Category :</h6>
                              <p><?= $ress['cname']?></p>
                              <h6>About :</h6>
                              <p><?= $vid['description']?> </p>
                              <h6>Tags :</h6>
                              <p class="tags mb-0">
                              <?php
                              $tags=explode(',',$vid['hashtag']);
                             
                              foreach ($tags as $key => $hashtags) {?>
                                 <span><a href="#"><?= $hashtags?></a></span>
                               
                             <?php }

                              $vid=$vid['id'];

                       
                             ?>
                          </p>
                           </div>
                            <div class="single-video-title box mb-3" >
                              <h2>Comments List</h2>
                              <small class="mb-1">2 comments</small>
                               <small id="cerror" style="font-weight: bolder;font-size:12px;color:red;"></small>
                                <span class="badge badge-success">Commented</span>
                              <div class="input-group  mb-3" id="commentbox">

                              <input type="text" class="form-control" id="cmnt" placeholder="Your Comment">
                              <div class="input-group-append">
                                <button class="btn btn-success" id="post" type="button" style="height:34px;">Post</button>

                                </div>

                           </div>

                           <div class="row comment-box p-1 pr-4">
                              <?php
                     $sql="SELECT c.*,u.photo,u.name FROM `tbl_comment_master` as c 
                     left join tbl_user_master as u on c.uid = u.id where c.vid ='".$vid."' order by c.con DESC";
                     $row=$call_config->get_all($sql);
                     foreach ($row as $key => $value) {
                        ?>
                        
                        <div class="container" id="mcomment_comment<?= $value['id'] ?>">

   <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
               <section class="post-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="media">
                              <div class="media-left">
                                <a href="#">
                                  <img src="<?= $call_config->base_url() ?>app-assets/user/user_image/<?=$value['photo']?>" class="main-cmt-img" title="<?= $value['name'];?>">
                                </a>
                              </div>
                              <div class="media-body ml-2">
                                <a href="#" class="anchor-username"><h6 class=""><b><?= $value['name'];?></b></h6>
                                 
                                </a>
                                <h6 class="anchor-time"><?= $call_config->get_time_difference("now",$value['con']) ?></h6> 
                                
                              </div>
                            </div>
                        </div>
                         
                    </div>             
               </section>
               <div class="col-lg-12 pt-2">
               <section >
                   <p><?= $value['comment'];?></p>
               </section>
               </div>
               <section class="post-footer">
                   <hr>
                   <div class="post-footer-option" >
                     <?php
if ($value['uid']==$user_sess_data['sess_user_id']) {
   ?>
                        <ul>
                           <!--   <li><a ><i class="fas fa-edit"></i> Edit</a></li> -->
                            <li><a onclick="delete_comment(<?= $value['id'] ?>)" ><i class="fas fa-trash"></i> Delete</a></li>
                           
                          <!--   <li><a href="#"><i class="fas fa-share"></i> Reply</a></li> -->
                           <!--  <li><a href="#"><i class="fas fa-edit"></i> Edit</a></li> -->
                        </ul>
                           <?php
}
?>   
                   </div>
          
               </section>


            </div>

        </div> 

   </div>
</div>
                   <?php
                }
                     ?>
                </div>

                           </div>
   
                        </div>
                     </div>
<script type="text/javascript">
   function delete_comment(id)
   {
   
      form_data = new FormData();
form_data.append("id",id);
form_data.append("uid",<?= $user_sess_data['sess_user_id'] ?>);
form_data.append("vid",<?= $value['vid']; ?>);
form_data.append("ch","delete");
        $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/utility/comment.php'?>',
                     type:'POST',
                     data:form_data,
   processData: false,
  contentType: false,
                     success:function(data){
                      var res=JSON.parse(data);
                     // alert(data);
                 if (res['status']) 
                 {
                  $("#mcomment_comment"+id).hide();
                 }    
                 else
                 {
                  alert(res['message']);
                 }
                     }
                  });

   }
</script>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="adblock">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                                 <div class="main-title">
                                    
                                    <h6>You may Vote <i class="fas fa-heart text-danger"> </i> these</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">

                                 <?php
// $count=$call_config->get("select COUNT(*) as total  from  tbl_video_master as v left join tbl_category_master as c on v.cat_id=c.id where v.hashtag='".$h."'");
// if ($count['total']>0) {
// $sql="select v.*,c.cname  from  tbl_video_master as v left join tbl_category_master as c on v.cat_id=c.id where v.hashtag='".$h."' LIMIT 12";
// $row=$call_config->get_all($sql);
// }
// else
// {
$sql="SELECT b.*,c.cname FROM `tbl_contest_video_master` as a JOIN tbl_video_master as b ON b.id=a.vid JOIN tbl_category_master AS c ON b.cat_id=c.id WHERE a.`contestid`='".$vedios[0]['contestid']."' AND a.vid <> '".$vid."' AND b.status='1' LIMIT 12";
$row=$call_config->get_all($sql);


                                  
                 foreach ($row as $key => $value) {
                  $views=$call_config->get("SELECT COUNT(*) as total FROM `tbl_video_impression_master` WHERE `vid`='".$value['id']."'");
                                    ?>


                                 <div class="video-card video-card-list">
                                    <div class="video-card-image">
                                       <a class="play-icon" href="<?= $call_config->base_url() ?>application/view/user/vedio_page/?id=<?= base64_encode($value['id'])?>"><i class="fas fa-play-circle"></i></a>
                                       <a href="#"><img class="img-fluid" src="<?= $call_config->base_url() ?>thumbnail/<?= $value['thumbnail'] ?>" alt=""></a>
                                       <div class="time"></div>
                                    </div>
                                    <div class="video-card-body">
                                       
                                       <div class="video-title">
                                          <a href="#"><?= $value['name'] ?></a>
                                       </div>
                                       <div class="video-page text-success">
                                          <?= $value['cname'] ?>  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                          <?= $views['total'];?> views &nbsp;<i class="fas fa-calendar-alt"></i> <?= $call_config->get_time_difference("now",$value['con']) ?>
                                       </div>
                                    </div>
                                 </div>
                                  <?php
                                 }

                                 ?>
                               
                                
                                
                                 <div class="adblock mt-0">
                                    <div class="img">
                                       Google AdSense<br>
                                       336 x 280
                                    </div>
                                 </div>
                               
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>


                    <?php }
                     # code...
                  }
                  

                  ?>

                
               </div>
            </div>
            <script type="">
               
               $(document).ready(function()
               {    var vid= <?= $vid?>;
                     var fuid=<?= $uid ?>;
               choice_check();
               function choice_check(){
                     var vid= <?= $vid?>;
                     var choice='Vote';
                     var fuid=<?= $uid ?>;
                     $('#Vote').css('color','#fff');
                   $('#Vote').css('background','#ff253a');
                   $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/choice_check.php'?>',
                     type:'POST',
                     data:{vid:vid,choice:choice},
                     success:function(data){
                        //alert(data);
                       if(parseInt(data)==1)
                       {
                          $("#Vote").removeAttr('href');
                           $('#Vote').css('color','#e2e2e2');
                            $('#Vote').css('background','#ff253a');
                             
                             $('#Vote').html('<i class="fas fa-thumbs-up"></i> Voted')
                              //$("a").removeAttr('href');
                            $('#devote').html('<i class="fas fa-thumbs-down"></i> Devote');
                       }
                       else if(parseInt(data)=="0")
                       {
                         $('#devote').html('<i class="fas fa-thumbs-down"></i> Devoted');
                         $('#Vote').html('<i class="fas fa-thumbs-up"></i> Vote')
                           $("#devote").removeAttr('href');
                        $('#devote').css('color','#e2e2e2');
                        $('#devote').css('background','#ff253a');
                         //ths.find('i').addClass('fas fa-thumbs-down');
                       // $("a").removeAttr('href');
                  
                        $("#devote").attr("disabled", true); 
                       }
                       else
                       {
                        $("#Vote").attr("disabled", false);
                        $("#devote").attr("disabled", false);
                          }
                     }
                  })
                   }
                     //count_votes
                     count_votes();
                     function count_votes(){
                         $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/count_votes.php'?>',
                     type:'POST',
                     data:{vid:vid},
                     success:function(data){
                   //alert(data);
                     if(data=="failed")
                     {
                        alert('cant count');
                     }
                     else if(data==1){
                        
                         $("#lcount").html('<i class="fas fa-thumbs-up"></i>'+ " " + data + " "+ "Vote")
                       
                     }
                     else{
                        
                        $("#lcount").html('<i class="fas fa-thumbs-up"></i>'+ " " + data + " "+ "Votes")
                     }
                    
                      
                     }
                  })
                       }
                         //count_devotes
                         count_devotes();
                         function count_devotes(){
                         $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/count_devotes.php'?>',
                     type:'POST',
                     data:{vid:vid},
                     success:function(data){
                   
                     if(data=="failed")
                     {
                        alert('cant count');
                     }
                     else if(data==1){
                        
                         $("#ucount").html('<i class="fas fa-thumbs-down"></i>'+ " " + data + " "+ "Devote" )
                       
                     }
                     else{
                        
                        $("#ucount").html('<i class="fas fa-thumbs-down"></i>'+ " " + data + " "+ "Devotes" )
                     }
                    
                      
                     }
                  })
                       }
                         // count_subscription

                     $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/utility/Subscribe_check.php'?>',
                     type:'POST',
                     data:{fuid:fuid},
                     success:function(data){
                      if(data=='Subscribed')
                      {
                       $('#smsg').html('Subscribed <span id="bell"></span>');
                       $('#bell').append('<i class="fas fa-bell"></i>') ;
                        $('#bell').css('color','#fff');                     
                      $('#smsg').css('font-weight','Bolder');
                      $('#smsg').css('font-size','14px');
                       $('#smsg').css('color','#e2e2e2');
                     }
                     else
                     {
                       $('#smsg').html('Subscribe');
                     }
                     }
                  })
               
// for vote
function vote(){
                     var vid= <?= $vid?>;
                     var choice='upvote';
                      //alert(choice);
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/vote.php'?>',
                     type:'POST',
                     data:{vid:vid,choice:choice},
                     success:function(data){
                        //alert(data);
                       $('#Vote').html('<i class="fas fa-thumbs-up"></i> Voted');
                       // $('#Vote').attr('id','remove_vote');
                       $('#devote').html('<i class="fas fa-thumbs-down"></i> Devote');
                      
                           $('#Vote').css('color','#e2e2e2');
                            $('#devote').css('color','white');
                            $('#Vote').css('background','#ff253a');
                     $('#Vote').find('i').addClass('fas fa-thumbs-up');
                     choice_check();
                       count_devotes();
                       count_votes();
                        }
                  })
}
                $('#Vote').click(function()
                  {  
                     var vid= <?= $vid?>;
                     // alert(vid);
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/check_vote_devote.php'?>',
                     type:'POST',
                     data:{vid:vid},
                     success:function(data){
                      // alert(data);
                        if(parseInt(data)==1)
                        {
                          remove_vote();
                        } 
                        else if(parseInt(data)=="0"){
                          vote();
                        }
                        else{
                          vote();
                        }                     
                     }
                  })
                  });
                    
// for devote
function devote(){
                     var vid= <?= $vid?>;
                     var choice='devote';
                      // alert(choice);
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/vote.php'?>',
                     type:'POST',
                     data:{vid:vid,choice:choice},
                     success:function(data){
                      //  alert(data);
                      $('#devote').html('<i class="fas fa-thumbs-down"></i> Devoted');
                       // $("#devote").attr('id','remove_vote');
                       $('#Vote').css('color','white');
                           $('#devote').css('color','#e2e2e2');
                            $('#devote').css('background','#ff253a');
                           $('#Vote').html('<i class="fas fa-thumbs-up"></i> Vote');
                 
                        //ths.find('i').addClass('fas fa-thumbs-down');
                        choice_check();
                    count_devotes();
                       count_votes();
                        }
                  });
}
                   $('#devote').click(function()
                  { 
                     var vid= <?= $vid?>;
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/choice_check.php'?>',
                     type:'POST',
                     data:{vid:vid},
                     success:function(data){
                        if(parseInt(data)==1)
                        {
                          devote();
                        } 
                        else if(parseInt(data)=="0"){
                          remove_vote();
                        } 
                        else{
                          devote();
                        }                    
                     }
                  })
                    }); 
      // remove_vote
          function remove_vote()
                  { 
                     var vid= <?= $vid?>;
                     var choice='delete';
                      // alert(choice);
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/contest_video_page/vote.php'?>',
                     type:'POST',
                     data:{vid:vid,choice:choice},
                     success:function(data){
                      // alert(data);
                      $('#devote').html('<i class="fas fa-thumbs-down"></i> Devote');
                      $('#Vote').html('<i class="fas fa-thumbs-up"></i> Vote');
                        choice_check();
                    count_devotes();
                       count_votes();
                        }
                  })
                    };

    // comment box start
    $('#commentbox').hide();
    $('.badge').hide();
   $("#comments").on('click', function(event) {
       $('#commentbox').show(400);
       $('#description').hide(300);
      $('#cmnt').focus();

       // alert('test');
     $('#post').on('click', function(event)
     {
      var comment=$('#cmnt').val();
      var ch='devote';
      var getcomment='getcomment';
                      if(comment=='')
                         {
                           $('#cerror').html('Write Comment');
                           $('#cmnt').focus();

                         }
                     else{
                        $('#cerror').hide();
                      $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/utility/comment.php'?>',
                     type:'POST',
                     data:{vid:vid,ch:ch,comment:comment},

                     success:function(data){
                        $('#cmnt').val(null);
                        $('.badge').show(0);
                        $('.badge').hide(10000);
                        location.reload();
                          
                     }
                  });
                   }
                    });});


  

               });
            </script>
<script type="text/javascript">
  function add_impression(vid,type) {
          $.ajax({
                     url:'<?php echo $call_config->base_url().'application/modal/user/utility/impression.php'?>',
                     type:'POST',
                     data:{vid:vid,type:type},
                     success:function(data){
                   res=JSON.parse(data);
                  // alert(res);                 
                     }
                  })

  }
</script>
            <!-- /.container-fluid -->