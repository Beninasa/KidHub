<?php

defined('ABSPATH') || exit;

$price_min = isset($_GET['price_min'])
    ? max(0, (int) wp_unslash($_GET['price_min']))
    : '';

$price_max = isset($_GET['price_max'])
    ? max(0, (int) wp_unslash($_GET['price_max']))
    : '';

$selected_categories = isset($_GET['category'])
    ? array_map(
        'sanitize_title',
        (array) wp_unslash($_GET['category'])
    )
    : [];

$selected_brands = isset($_GET['brand'])
    ? array_map(
        'sanitize_key',
        (array) wp_unslash($_GET['brand'])
    )
    : [];

$selected_ages = isset($_GET['age'])
    ? array_map(
        'sanitize_key',
        (array) wp_unslash($_GET['age'])
    )
    : [];

$default_category_id = (int) get_option('default_product_cat');

$product_categories = get_terms([
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'exclude'    => $default_category_id
        ? [$default_category_id]
        : [],
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

$brand_terms = taxonomy_exists('pa_brand')
    ? get_terms([
        'taxonomy'   => 'pa_brand',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ])
    : [];

$age_terms = taxonomy_exists('pa_age')
    ? get_terms([
        'taxonomy'   => 'pa_age',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ])
    : [];

if (is_wp_error($product_categories)) {
    $product_categories = [];
}

if (is_wp_error($brand_terms)) {
    $brand_terms = [];
}

if (is_wp_error($age_terms)) {
    $age_terms = [];
}
?>

<div class="catalog-filters__header">
    <h2 class="catalog-filters__title">
        <?php esc_html_e('Фільтри', 'kidhub'); ?>
    </h2>

    <a
        href="<?php echo esc_url(get_permalink()); ?>"
        class="catalog-filters__reset"
    >
        <?php esc_html_e('Очистити', 'kidhub'); ?>
    </a>
</div>

<form
    class="filters-form"
    action="<?php echo esc_url(get_permalink()); ?>"
    method="get"
>
    <input
        type="hidden"
        name="sorting"
        value="<?php echo esc_attr(
            isset($_GET['sorting'])
                ? sanitize_key(wp_unslash($_GET['sorting']))
                : 'popular'
        ); ?>"
    >

    <?php if (! empty($product_categories)) : ?>
        <fieldset class="filter-group">
            <legend class="filter-group__title">
                <?php esc_html_e('Категорія', 'kidhub'); ?>
            </legend>

            <?php foreach ($product_categories as $category) : ?>
                <label class="filter-option">
                    <input
                        type="checkbox"
                        name="category[]"
                        value="<?php echo esc_attr($category->slug); ?>"
                        <?php checked(
                            in_array(
                                $category->slug,
                                $selected_categories,
                                true
                            )
                        ); ?>
                    >

                    <span>
                        <?php echo esc_html($category->name); ?>
                    </span>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>

    <fieldset class="filter-group">
        <legend class="filter-group__title">
            <?php esc_html_e('Ціна', 'kidhub'); ?>
        </legend>

        <div class="price-filter">
            <label>
                <span><?php esc_html_e('Від', 'kidhub'); ?></span>

                <input
                    type="number"
                    name="price_min"
                    min="0"
                    placeholder="0"
                    value="<?php echo esc_attr($price_min); ?>"
                >
            </label>

            <label>
                <span><?php esc_html_e('До', 'kidhub'); ?></span>

                <input
                    type="number"
                    name="price_max"
                    min="0"
                    placeholder="5000"
                    value="<?php echo esc_attr($price_max); ?>"
                >
            </label>
        </div>
    </fieldset>

    <?php if (! empty($brand_terms)) : ?>
        <fieldset class="filter-group">
            <legend class="filter-group__title">
                <?php esc_html_e('Бренд', 'kidhub'); ?>
            </legend>

            <?php foreach ($brand_terms as $brand) : ?>
                <label class="filter-option">
                    <input
                        type="checkbox"
                        name="brand[]"
                        value="<?php echo esc_attr($brand->slug); ?>"
                        <?php checked(
                            in_array(
                                $brand->slug,
                                $selected_brands,
                                true
                            )
                        ); ?>
                    >

                    <span><?php echo esc_html($brand->name); ?></span>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>

    <?php if (! empty($age_terms)) : ?>
        <fieldset class="filter-group">
            <legend class="filter-group__title">
                <?php esc_html_e('Вік', 'kidhub'); ?>
            </legend>

            <?php foreach ($age_terms as $age) : ?>
                <label class="filter-option">
                    <input
                        type="checkbox"
                        name="age[]"
                        value="<?php echo esc_attr($age->slug); ?>"
                        <?php checked(
                            in_array(
                                $age->slug,
                                $selected_ages,
                                true
                            )
                        ); ?>
                    >

                    <span><?php echo esc_html($age->name); ?></span>
                </label>
            <?php endforeach; ?>
        </fieldset>
    <?php endif; ?>

    <button type="submit" class="button filters-form__submit">
        <?php esc_html_e('Застосувати фільтри', 'kidhub'); ?>
    </button>
</form>