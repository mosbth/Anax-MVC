<h1><?=$title?></h1>

<?php if(!empty($users)) : ?>

    <table class='user-table'>
        <thead>
        <tr>
            <th>id</th>
            <th>Acronym</th>
            <th>Email</th>
            <th>Name</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Deleted</th>
            <th>Active</th>
            <th colspan='5'>Options</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($users as $user) : ?>

            <?php $properties = $user->getProperties(); ?>
            <tr>
                <?php $url = $this->url->create('users/id/' . $properties['id']) ?>
                <td><a href="<?=$url?>"><?=$properties['id']?></a></td>
                <td><?=$properties['acronym']?></td>
                <td><?=$properties['email']?></td>
                <td><?=$properties['name']?></td>
                <td><?= isset($properties['created']) ? $properties['created'] : '-' ?></td>
                <td><?= isset($properties['updated']) ? $properties['updated'] : '-' ?></td>
                <td><?= isset($properties['deleted']) ? $properties['deleted'] : '-' ?></td>
                <td><?= isset($properties['active']) ? $properties['active'] : '-' ?></td>

                <?php $url = $this->url->create('users/update/' . $properties['id']) ?>
                <td><a href="<?=$url?>" title="Edit"> <i class="fa fa-pencil-square-o"></i> </a></td>

                <?php $url = $this->url->create('users/status/' . $properties['id']) ?>
                <td><a href="<?=$url?>" title="Set Active/Inactive"> <i class="fa fa-check-square-o"></i> </a></td>

                <?php $url = $this->url->create('users/soft-delete/' . $properties['id']) ?>
                <td><a href="<?=$url?>" title="Soft-delete"> <i class="fa fa-trash-o"></i> </a></td>

                <?php $url = $this->url->create('users/soft-undo/' . $properties['id']) ?>
                <td><a href="<?=$url?>" title="Undo-delete"> <i class="fa fa-undo"></i> </a></td>

                <?php $url = $this->url->create('users/delete/' . $properties['id']) ?>
                <td><a href="<?=$url?>" title="Remove"> <i class="fa fa-times"></i> </a></td>
            </tr>

        <?php endforeach; ?>

    </tbody>
    </table>

<?php else : ?>

    <p>No users found.</p>

<?php endif; ?>
