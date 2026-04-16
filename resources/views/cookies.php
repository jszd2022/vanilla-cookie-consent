<?php

use JSzD\VanillaCookieConsent\Cookies;

?>
<aside id="cookies-policy" class="cookies cookies--no-js"
       data-text='<?= json_encode(lcc_trans('details')) ?>'>
    <div class="cookies__alert">
        <div class="cookies__container">
            <div class="cookies__wrapper">
                <h2 class="cookies__title">
                    <?= lcc_trans('title') ?>
                </h2>
                <div class="cookies__intro">
                    <p><?= lcc_trans('intro') ?></p>
                    <?php if ($policy ?? ''): ?>
                        <p><?= lcc_trans('link', ['url' => $policy ?? '']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="cookies__actions">
                    <?= Cookies::renderButton(action: 'accept-essentials', label: lcc_trans('essentials'), attributes: ['class' => 'cookiesBtn cookiesBtn--essentials']) ?>
                    <?= Cookies::renderButton(action: 'accept-all', label: lcc_trans('all'), attributes: ['class' => 'cookiesBtn cookiesBtn--accept']) ?>
                </div>
            </div>
        </div>
        <a href="#cookies-policy-customize" class="cookies__btn cookies__btn--customize">
            <span><?= lcc_trans('customize') ?></span>
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                 aria-hidden="true">
                <path d="M14.7559 11.9782C15.0814 11.6527 15.0814 11.1251 14.7559 10.7996L10.5893 6.63297C10.433 6.47669 10.221 6.3889 10 6.38889C9.77899 6.38889 9.56703 6.47669 9.41075 6.63297L5.24408 10.7996C4.91864 11.1251 4.91864 11.6527 5.24408 11.9782C5.56951 12.3036 6.09715 12.3036 6.42259 11.9782L10 8.40074L13.5774 11.9782C13.9028 12.3036 14.4305 12.3036 14.7559 11.9782Z"
                      fill="#2C2E30"/>
            </svg>
        </a>
        <div class="cookies__expandable cookies__expandable--custom" id="cookies-policy-customize">
            <form action="<?= lcc_route('accept-configuration') ?>" method="post"
                  class="cookies__customize">
                <div class="cookies__sections">
                    <?php foreach (($cookies ?? null)?->getCategories() as $category): ?>
                        <div class="cookies__section">
                            <label for="cookies-policy-check-<?= $category->key() ?>" class="cookies__category">
                                <?php if ($category->key() === 'essentials'): ?>
                                    <input type="hidden" name="categories[]" value="<?= $category->key() ?>"/>
                                    <input type="checkbox" name="categories[]" value="<?= $category->key() ?>"
                                           id="cookies-policy-check-<?= $category->key() ?>" checked="checked"
                                           disabled="disabled"/>
                                <?php else: ?>
                                    <input type="checkbox" name="categories[]" value="<?= $category->key() ?>"
                                           id="cookies-policy-check-<?= $category->key() ?>"/>
                                <?php endif; ?>
                                <span class="cookies__box">
                                    <strong class="cookies__label"><?= $category->title ?></strong>
                                </span>
                                <?php if ($category->description): ?>
                                    <p class="cookies__info"><?= $category->description ?></p>
                                <?php endif; ?>
                            </label>

                            <div class="cookies__expandable" id="cookies-policy-<?= $category->key() ?>">
                                <ul class="cookies__definitions">
                                    <?php foreach ($category->getCookies() as $cookie) : ?>
                                        <li class="cookies__cookie">
                                            <p class="cookies__name"><?= $cookie->name ?></p>
                                            <p class="cookies__duration"><?= Carbon\Carbon::now()->diffForHumans(Carbon\Carbon::now()->addMinutes($cookie->duration), true) ?></p>
                                            <?php if ($cookie->description): ?>
                                                <p class="cookies__description"><?= $cookie->description ?></p>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a href="#cookies-policy-<?= $category->key() ?>"
                               class="cookies__details"><?= lcc_trans('details.more') ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cookies__save">
                    <button type="submit"
                            class="cookiesBtn__link"><?= lcc_trans('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</aside>

<!-- STYLES & SCRIPT: feel free to remove them and add your own -->
<script data-cookie-consent>
    <?php echo file_get_contents(LCC_ROOT . '/resources/js/script.js') ?>
</script>
<style data-cookie-consent>
    <?php echo file_get_contents(LCC_ROOT . '/resources/css/style.css') ?>
</style>
