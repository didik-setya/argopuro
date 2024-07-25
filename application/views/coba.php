<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $type = [1, 2];
    $all_menu = $this->db->where_in('type', $type)->get('menu')->result();
    $menu = $this->model->get_data_menu()->result();
    // $rr = array_intersect($all_menu, $menu);
    $all_menu_id = [];
    foreach ($all_menu as $am) {
        $all_menu_id[] = $am->id;
    }

    $menu_id = [];
    foreach ($menu as $m) {
        $menu_id[] = $m->id;
    }
    // var_dump($menu_id);
    // var_dump($all_menu_id);
    $c = array_intersect($all_menu_id, $menu_id);
    var_dump($c);
    ?>

    <table style="width: 100%;" border="1">
        <!-- <tr>
            <th colspan="2">Menu</th>
            <th>#</th>
        </tr> -->
        <!-- <?php foreach ($all_menu as $am) { ?>
            <?php foreach ($menu as $m) { ?>
                <tr>
                    <td colspan="2"><?= $am->label ?></td>


                    <td><input type="checkbox" name="check[]" id="check"></td>
                </tr>
            <?php } ?>
        <?php } ?> -->
    </table>


</body>

</html>