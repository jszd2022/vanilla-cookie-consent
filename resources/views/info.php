<?php foreach (($cookies ?? null)?->getCategories() as $category): ?>
    <h3><?= $category->title ?></h3>
    <table>
        <thead>
        <th><?= lcc_trans('cookie') ?></th>
        <th><?= lcc_trans('purpose') ?></th>
        <th><?= lcc_trans('duration') ?></th>
        </thead>
        <tbody>
        <?php foreach ($category->getCookies() as $cookie): ?>
            <tr>
                <td><?= $cookie->name ?></td>
                <td><?= $cookie->description ?></td>
                <td><?= \Carbon\CarbonInterval::minutes($cookie->duration)->cascade() ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>
