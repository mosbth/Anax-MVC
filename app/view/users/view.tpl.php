<h1>User details</h1>

<table class="users">
    <tr>
        <th>Property</th><th>Value</th>
    </tr>
<?php $properties = $user->getProperties()?>
<?php foreach ($properties as $property => $value) {

    echo "<tr><td>{$property}</td><td>{$value}</td></tr>";

} ?>
</table>

<p>
    <a href='<?=$this->url->create('users/edit/'.$properties['id'])?>'>Edit</a>
    <a href='<?=$this->url->create('users/soft-delete/'.$properties['id'])?>'> | Delete</a>
    <a href='<?=$this->url->create('users/delete/'.$properties['id'])?>'> | Hard delete</a>
</p>
<p>
    <a href='<?=$this->url->create('')?>'>Home</a>
    <a href='<?=$this->url->create('users/list')?>'> | All</a>
    <a href='<?=$this->url->create('users/active')?>'> | All Active</a>
    <a href='<?=$this->url->create('users/wastebasket')?>'> | All Deleted</a>
</p>
