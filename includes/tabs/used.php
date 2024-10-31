<div class="mt-4 clr ppgbo-used" <?php echo (($page != 'used') ? 'style="display:none;"' : ''); ?>>
        
    <hr class="mt-4">
    <h3 class="mt-3 d-flex">
        <div class="text-start col-sm-10">
            <?php echo sprintf(__( 'Liste des éléments (%d)', 'presta-products'), count($list)); ?>
        </div>
        <div class="col-sm-2 text-end">
            <button type="button" class="btn btn-success btn" id="exportCSV"><?php echo __( 'Exporter en CSV', 'presta-products' ); ?></button>              
        </div>
        </h3>
    <hr>
    
    <table id="usedTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th width="50"><?php echo __( 'ID', 'presta-products' ); ?></th>
                <th><?php echo __( 'Nom', 'presta-products' ); ?></th>
                <th><?php echo __( 'Type', 'presta-products' ); ?></th>
                <th><?php echo __( 'Utilisation(s)', 'presta-products' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($list as $element) {
                    echo '<tr>';
                    echo '<td>' . esc_html($element['id']) . '</td>';
                    echo '<td><a href="' . esc_url($element['slug']) . '" target="_blank">' . esc_html($element['name']) . '</a></td>';
                    echo '<td>' . esc_html($element['type']) . '</td>';
                    echo '<td>' . esc_html($element['ppgbo']) . '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
        
</div>