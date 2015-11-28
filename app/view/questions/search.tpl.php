<h1><?=$title?></h1>

<!--
<div id="tabs">
   <ul class='tabs'>
    <li><a href="timestamp">Nyaste</a></li>
    <li><a href="votes">Votes</a></li>
  </ul>
-->


    <!--Checking to see if there are any questions -->
    <?if(!empty($questions)) :?>
<table class="table table-striped">
    <thead>
         <tr>
             <th>Rubrik</th>
             <th>Skapad</th>
             <th>Skapare</th>
             <th>Svar</th>
             <th>Votes</th>

         </tr>
    </thead>
    <tbody>
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
    <p>Vi hittar tyvärr inget sökresultat. </p>
    <? endif ;?>
    </tbody>
    </table>
</div><!--TAB 2-->
