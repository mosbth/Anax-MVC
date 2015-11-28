<div id="question">
    <h4><?=$question->questionTitle?></h4>
    <p><a href="<?=$this->url->create('questions/answer/' . $question->id)?>"><button class="btn">Svara</button></a>
    
    <?php if($userId==$questioncreator) :?>
        <a href="<?=$this->url->create('questions/update/' . $question->id)?>"><button class="btn">Redigera fråga</button></a></p>
    <? endif; ?>
   
    <hr>
    <div class="row" id="question">
        <div class="gravatardiv points col-sm-2">
            <img class="gravatar" src="http://www.gravatar.com/avatar/<?=md5($question->userEmail);?>.jpg?s=100">
            

               <div id="questionpoints">
                <a href="<?=$this->url->create('questions/voteQuestion/' . $question->id . '/up')?>"><i class="fa fa-arrow-up fa-lg"></i></a>
                <?= $question->points ?>
                <a href="<?=$this->url->create('questions/voteQuestion/' . $question->id . '/down')?>"><i class="fa fa-arrow-down fa-lg"></i></a>
            </div>

        </div><!--GRAVATAR-->
        

        <!-- ============== QUESTION ================ -->
        <div id="textquestion" class="col-sm-10">
            <p class="user"><a href='<?=$this->url->create('users/id/' . $question->userId)?>'><?=$question->userAcronym?></a></p>
            <p class="timestamp"><?=$question->timestamp?></p>
            <p><?=$this->textFilter->doFilter( $question->questiontext, 'shortcode, markdown');?></p>
	
            <?php if(!empty($tags)):?>
                <?php foreach ($tags as $tag) : ?>
                    <span class="label">
                        <a href=" <?=$this->url->create('tags/id/' . $tag->id)?> "><?=$tag->tag?></a>
                    </span><!--TAG-->
                <?php endforeach; ?>
            <?php endif; ?>
        <!-- QUESTION END ===== -->
	
	
	
	
	
<!----- COMMENTS TO QUESTIONS ====== ---- -->
        <?php if(!empty($question->comments)) : ?>
        <hr>
        <? endif; ?>
			<?foreach ($question->comments as $comment) : ?>
				<div class="comment">
                    <p><a href="<?=$this->url->create('questions/voteComment/' . $comment->id . '/up')?>"><i class="fa fa-arrow-up"></i></a>
                    <?= $comment->points ?>
                    <a href="<?=$this->url->create('questions/voteComment/' . $comment->id . '/down')?>"><i class="fa fa-arrow-down"></i></a></p>
                    <?=$this->textFilter->doFilter( $comment->commentText, 'shortcode, markdown');?> <p> - <a href='<?=$this->url->create('users/id/' . $comment->userId)?>'><?=$comment->userAcronym?></a> den <?=$comment->timestamp?></p>
				</div>
				
			<?php endforeach; ?>
       <hr>
        
        <p><a href="<?=$this->url->create('questions/addComment/' . $question->id . '/question')?>">Kommentera den här frågan</a></p>
<!-- ======= END OF COMMENTS TO QUESTION ==========-->
    						
     </div><!--TEXTQUESTION-->
    </div><!--QUESTION-->   

</div>


<div id="answers">

<!-- ==================ANSWERS================ -->
<div class="row">
<div class="col-sm-12">
<h4 class="bold answerscount"><?= count($answers)?> svar</h4>
</div>
</div>
<hr>
	<?php if(!empty($answers)) : ?>
		
		<?php foreach ($answers as $answer) : ?>
			<div class="answer row">
                <div class="gravatardiv points col-sm-2">
                    <img class="gravatar" src="http://www.gravatar.com/avatar/<?=md5($answer->userEmail);?>.jpg?s=100">
                    
                    <div class="answerpoints">
                    <a href="<?=$this->url->create('questions/voteAnswer/' . $answer->id . '/up')?>"><i class="fa fa-arrow-up fa-lg"></i></a>
                        <?= $answer->points ?>
                    <a href="<?=$this->url->create('questions/voteAnswer/' . $answer->id . '/down')?>"><i class="fa fa-arrow-down fa-lg"></i></a>
                    </div><!--ANSWERPOINTS-->
                    
                    <?php if($answer->accepted == true) :?>
                        <i class="fa fa-check fa-3x"></i>
                    <? endif ?>

                
                </div><!--END OF GRAVATARDIV POINTS COL-SM-2 -->
            
            <div class="col-sm-10" id="textanswer">
                <p class="user"><a href='<?=$this->url->create('users/id/' . $answer->userId)?>'><?=$answer->userAcronym?></a></p>
                <p class="timestamp"><?=$answer->timestamp?></p> 
					<?=$this->textFilter->doFilter( $answer->answer, 'shortcode, markdown');?>
				
				
                    <?php if($userId==$questioncreator) :?>
                      <?php if($userId!=$answer->userId) :?>
                       <?php if($answer->accepted == false) :?>
                        <p><a href="<?=$this->url->create('questions/acceptAnswer/' . $answer->id)?>"><i class="fa fa-check"></i> Acceptera detta svar</a></p>
                        <? endif ?>
                        <? endif ?>
                    <? endif ?>
                    
<!-- ===================== ANSWERS END ===================== --->
       <?php if(!empty($answer->comments)) : ?>
        <hr>
        <? endif; ?>
				<?php foreach ($answer->comments as $comment) : ?>
							<div class="comment">
							<p><a href="<?=$this->url->create('questions/voteComment/' . $comment->id . '/up')?>"><i class="fa fa-arrow-up"></i></a>
                    <?= $comment->points ?>
                    <a href="<?=$this->url->create('questions/voteComment/' . $comment->id . '/down')?>"><i class="fa fa-arrow-down"></i></a></p>
                                <?=$this->textFilter->doFilter( $comment->commentText, 'shortcode, markdown');?> <p>Skickad av <a href='<?=$this->url->create('users/id/' . $comment->userId)?>'><?=$comment->userAcronym?></a> den <?=$comment->timestamp?></p>
							</div>
				<?php endforeach; ?>
				
                            <hr>
				<p><a href="<?=$this->url->create('questions/addComment/' . $question->id . '/answer/' . $answer->id)?>">Kommentera det här svaret</a></p>
					
	            </div><!--TEXTANSWER-->
			</div><!--ANSWER-->
			<hr>
		<?php endforeach; ?>
	<?php endif; ?>
	
</div>

