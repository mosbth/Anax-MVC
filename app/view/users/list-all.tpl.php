<h1><?=$title?></h1>

<table class="users">
    <tr>
        <th>id</th><th>acronym</th><th>Name</th><th>Active</th><th>Deleted</th><th>Manage</th>
    </tr>
<?php foreach ($users as $user) : ?>
<?php $properties = $user->getProperties()?>
    <tr>
        <td><?=$properties['id']?></td>
        <td><?=$properties['acronym']?></td>
        <td><?=$properties['name']?></td>
        <td><?=$properties['active']?'Yes':'No'?></td>
        <td><?=$properties['deleted']?'Yes':'No'?></td>
        <td>
            <a href='<?=$this->url->create('users/id/'.$properties['id'])?>'>View</a>
            <a href='<?=$this->url->create('users/update/'.$properties['id'])?>'>  | Edit</a>
            <a href='<?=$this->url->create('users/activate/'.$properties['id'])?>'>  | Activate</a>
            <a href='<?=$this->url->create('users/deactivate/'.$properties['id'])?>'>  | Deactivate</a>
            <a href='<?=$this->url->create('users/soft-delete/'.$properties['id'])?>'> | Delete</a>
            <a href='<?=$this->url->create('users/undo-delete/'.$properties['id'])?>'> | Undelete</a>
            <a href='<?=$this->url->create('users/delete/'.$properties['id'])?>'> | Hard delete</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<p><a href='<?=$this->url->create('users')?>'>Home</a></p>
