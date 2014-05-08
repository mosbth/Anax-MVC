<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
        <fieldset>
        <legend>Leave a comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comments/add')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
