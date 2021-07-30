<div class="row">
    <div class="col">
        <table id="customers">
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Chat Link<td>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['FirstName']?></td>
                    <td><?php echo $user['LastName']?></td>
                    <td><?php echo $user['Email']?></td>
                    <td id="talk"><a href="<?php echo base_url('Messages/').$user['User_id'] ?>" class = "white">Talk</a></td>
                </tr>

            <?php endforeach ?>
        </table>
    </div>

</div>
