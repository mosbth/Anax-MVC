<h1><?=$tag->tag?></h1>
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
<div>
	<?if(isset($questions)):?>
			<? foreach ($questions as $question):?>
				
				<tr><td><i class="fa fa-comment"></i> <a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->questionTitle?></a></td> <td><?= $this->time->timeago($question->timestamp)?></td><td><?=$question->userAcronym?></td><td><?= $question->countAnswer ?></td><td><?= $question->points?></td></tr>
				
			<? endforeach;?>
		<? endif;?>
    </tbody>
    </table>
</div>