<h1><?=$title?></h1>

<!--
<div id="tabs">
   <ul class='tabs'>
    <li><a href="timestamp">Nyaste</a></li>
    <li><a href="votes">Votes</a></li>
  </ul>
-->

    <table class="table table-striped">
    <thead>
         <tr>
             <th>Rubrik</th>
             <th><a href="<?=$this->url->create('questions/list/timestamp')?>">Skapad <i class="fa fa-chevron-up"></i></a></th>
             <th>Skapare</th>
             <th>Svar</th>
             <th><a href="<?=$this->url->create('questions/list/votes')?>">Votes <i class="fa fa-chevron-up"></i></a></th>

         </tr>
    </thead>
    <tbody>
    <!--Checking to see if there are any questions -->
    <?if(!empty($questions)) :?>
        <?php foreach ($questions as $question) : ?>

            <div id="questions">
                <tr>
                    <td><i class="fa fa-comment"></i> <a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->questionTitle?></a></td> 
                    <td><?=$this->time->timeago($question->timestamp)?> </td>
                    <td><a href='<?=$this->url->create('users/id/' . $question->userId)?>'><?=$question->userAcronym ?></a></td>
                    <td><?= $question->countAnswer ?></td>
                    <td><?= $question->points?></td>
                </tr>
            </div><!--QUESTIONS-->


        <?php endforeach; ?>
    <? else :?><!--If there arent any questions --->
    <p>Det har inte ställts några frågor i forumet</p>
    <? endif ;?>
    </tbody>
    </table>
</div><!--TAB 2-->

	
