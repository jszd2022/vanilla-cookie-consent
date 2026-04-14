<form action="<?= $url ?? '' ?>" <?= $attributes ?? '' ?>>
    <button type="submit" class="<?=$basename ?? ''?>__link">
        <span class="<?=$basename ?? ''?>__label"><?= $label ?? '' ?></span>
    </button>
</form>
