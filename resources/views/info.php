<?php foreach (($cookies ?? null)?->getCategories() as $category): ?>
    <h3><?= $category->title ?></h3>
    <table>
        <thead>
        <th><?= lcc_trans('cookies.cookie') ?></th>
        <th><?= lcc_trans('cookies.purpose') ?></th>
        <th><?= lcc_trans('cookies.duration') ?></th>
        </thead>
        <tbody>
        <?php foreach ($category->getCookies() as $cookie): ?>
            <tr>
                <td><?= $cookie->name ?></td>
                <td><?= $cookie->description ?></td>
                <td><?= lcc_minutesHumanReadable($cookie->duration) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>
