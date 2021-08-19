<div class="row">
    <div class="col">
        <form action="<?php echo base_url(); ?>admins/search" method="post" class="search">
            <label for="keyword">Search
                <input class="input" type="text" name="keyword" placeholder="Search Users" label="Search" />
                <input type="submit" value="Search" />
            </label>
        </form>
        <a href="<?php echo base_url(); ?>admins/viewUsers">Reset</a>
        <table id="customers">
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Chat Link</th>
            </tr>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $user['FirstName'] ?></td>
                    <td><?php echo $user['LastName'] ?></td>
                    <td><?php echo $user['Email'] ?></td>
                    <td id="talk"><a href="<?php echo base_url('Messages/') . $user['User_id'] ?>" class="white">Talk</a></td>
                </tr>

            <?php endforeach ?>
        </table>
    </div>

</div>