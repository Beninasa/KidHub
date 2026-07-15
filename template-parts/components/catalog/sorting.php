<?php

$sorting = isset($_GET['sorting'])
    ? sanitize_key(wp_unslash($_GET['sorting']))
    : 'popular';

?>

<label class="catalog-sorting">
    <span class="catalog-sorting__label">
        Сортування
    </span>

    <select
    class="catalog-sorting__select"
    name="sorting"
    onchange="this.form.submit()">
        <option value="popular" <?php selected($sorting, 'popular'); ?>>
            За популярністю
        </option>

        <option value="price-asc" <?php selected($sorting, 'price-asc'); ?>>
            Від дешевих до дорогих
        </option>

        <option value="price-desc" <?php selected($sorting, 'price-desc'); ?>>
            Від дорогих до дешевих
        </option>

        <option value="newest" <?php selected($sorting, 'newest'); ?>>
            Новинки
        </option>

        <option value="rating" <?php selected($sorting, 'rating'); ?>>
            За рейтингом
        </option>
    </select>
</label>