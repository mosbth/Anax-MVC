<h1>Redigera kommentar</h1>

<div class='comment-form card card-1'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($commentFlow)?>">
        <input type=hidden name="id" value="<?=$id?>">
        <input type=hidden name="comment-flow" value="<?=$commentFlow?>">
        <fieldset>
        <legend>Edit comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doUpdate' value='Update' onClick="this.form.action = '<?=$this->url->create('comment/update')?>'"/>
            <input type='reset' value='Reset'/>
            <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
