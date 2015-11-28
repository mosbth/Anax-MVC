<div id="tabs">
   <ul class='tabs'>
    <li><a href='#tab1'>Frågor</a></li>
    <li><a href='#tab2'>Svar</a></li>
    <li><a href='#tab3'>Kommentarer</a></li>
  </ul>
<!-- USERS QUESTIONS --->
<div id="tab1">
<div id="userQuestions">
	<h4><?if(!empty($userQuestions)):?><?php echo count($userQuestions)?><? endif;?>
       Frågor ställda av <?=$user->acronym?></h4>
       
    <?if(!empty($userQuestions)):?>
    <table class="table table-striped">
        <thead>
         <tr>
             <th>Rubrik</th>
             <th class="displaynone">Skapad</th>
             <th>Svar</th>
             <th>Votes</th>
             
         </tr>
        </thead>
        
        <tbody>
            <?foreach ($userQuestions as $userQuestion) : ?>

                    <tr>
                        <td><i class="fa fa-comment"></i> <a href="<?=$this->url->create('questions/id/' . $userQuestion->id)?>"><?=$userQuestion->questionTitle?></a></td>
                        <td class="displaynone"><?= $this->time->timeago($userQuestion->timestamp)?></td>
                        <td><?= $userQuestion->countAnswer ?></td>
                        <td><?= $userQuestion->points ?></td>
                        </tr>

            <?php endforeach; ?>
        </tbody>	
    </table> 
    
    <? else :?>
    <p><?=$user->acronym?> har inte ställt några frågor.</p>
    
    <? endif;?>
</div><!--USERQUESTIONS -->
</div><!--TAB 1-->

<!-- USERS ANSWERS -->
<div id="tab2">
<div id="userAnswers">
    <h4><?if(!empty($userAnswers)):?><?php echo count($userAnswers)?><? endif;?>
    Svar från <?=$user->acronym?></h4>
    <?if(!empty($userAnswers)):?>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>Rubrik</th>
            <th>Svar</th>
            <th>Skriven</th>
            <th>Votes</th>
        </tr>
    </thead>
    <tbody>
        <?foreach ($userAnswers as $userAnswer) :?>
        <tr><td><i class="fa fa-comment"></i><a href="<?=$this->url->create('questions/id/' . $userAnswer->questionId)?>"> <?=$userAnswer->questionTitle?></a></td><td><?=$userAnswer->answer ?></td><td class="displaynone"><?= $this->time->timeago($userAnswer->timestamp) ?></td><td><?= $userAnswer->points ?></td></tr>

        <?php endforeach; ?>
    </tbody>
    </table>
    
    <? else :?>
    <p><?=$user->acronym?> har inte svarat på några frågor.</p>
    
    <? endif;?>
</div><!--USERANSWERS-->
</div><!--- TAB 2-->

<div id="tab3">
<div id="userComments">
   <h4><?if(!empty($userComments OR !empty($userAnswerComments))):?><?php echo $countcomments = count($userComments) + count($userAnswerComments)?><? endif;?>
   Kommentarer gjorda av <?=$user->acronym?> </h4>
   
   <?if(!empty($userComments OR !empty($userAnswerComments))):?>
   <table class="table table-striped">
       <thead>
           <tr>
               <th>Rubrik</th>
               <th>Kommentar</th>
               <th>Skriven</th>
           </tr>
       </thead>
       <tbody>
            <?foreach ($userComments as $userComment) :?>
                <tr><td><i class="fa fa-comment"></i> <?=$userComment->questionTitle ?></td><td><?=$userComment->commentText ?></td><td><?= $this->time->timeago($userComment->timestamp) ?></td></tr>
            <?php endforeach; ?>
            <?foreach ($userAnswerComments as $userComment) :?>
                <tr><td><i class="fa fa-comment"></i> <?=$userComment->questionTitle ?></td><td><?=$userComment->commentText ?></td><td><?= $this->time->timeago($userComment->timestamp) ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <? else: ?>
    <p><?=$user->acronym?> har inte skrivit några kommentarer.</p>
    
    <? endif;?>
</div><!--USERCOMMENTS-->
</div><!-- TAB 3-->


</div><!-- TABS -->