<table class="table table-bordered table-sm">
    <thead>
        <tr class="bg-secondary text-light">
            <th colspan="2">Menu</th>
            <th>URL</th>
            <th width="5%"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $menu_access = $this->model->get_data_menu(null, $role)->result();

        $menu_access_id = [];
        foreach ($menu_access as $ma) {
            $menu_access_id[] = $ma->id;
        }

        foreach ($menu as $d) { ?>
            <tr>
                <td colspan="2"><?= $d->icon . ' ' . $d->label  ?></td>
                <td><?= $d->url ?></td>
                <td class="text-center">
                    <?php if (in_array($d->id, $menu_access_id)) { ?>
                        <input type="checkbox" name="check[]" id="check" value="<?= $d->id ?>" checked>
                    <?php } else { ?>
                        <input type="checkbox" name="check[]" id="check" value="<?= $d->id ?>">
                    <?php } ?>
                </td>
            </tr>
            <?php
            if ($d->type == 2) {
                $submenu_access = $this->model->get_data_menu($d->id, $role)->result();
                $submenu_access_id = [];
                foreach ($submenu_access as $sa) {
                    $submenu_access_id[] = $sa->id;
                }

                $sub_menu = $this->db->get_where('menu', ['type' => 3, 'status' => 1, 'parent' => $d->id])->result();
                foreach ($sub_menu as $sm) {
            ?>

                    <tr>
                        <td></td>
                        <td><?= $sm->icon . ' ' . $sm->label ?></td>
                        <td><?= $sm->url ?></td>
                        <td class="text-center">
                            <?php if (in_array($sm->id, $submenu_access_id)) { ?>
                                <input type="checkbox" name="check[]" id="check" value="<?= $sm->id ?>" checked>
                            <?php } else { ?>
                                <input type="checkbox" name="check[]" id="check" value="<?= $sm->id ?>">
                            <?php } ?>
                        </td>
                    </tr>

            <?php }
            } ?>
        <?php } ?>
    </tbody>
</table>