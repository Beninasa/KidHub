<?php

$price_min = isset($_GET['price_min'])
    ? max(0, (int) wp_unslash($_GET['price_min']))
    : '';

$price_max = isset($_GET['price_max'])
    ? max(0, (int) wp_unslash($_GET['price_max']))
    : '';

$selected_categories = isset($_GET['category'])
    ? array_map(
        'sanitize_key',
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
?>


<div class="catalog-filters__header">
    <h2 class="catalog-filters__title">Фільтри</h2>

    <a
    href="<?php echo esc_url(get_permalink()); ?>"
    class="catalog-filters__reset"
>
    Очистити
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
    <fieldset class="filter-group">
        <legend class="filter-group__title">Категорія</legend>

        <label class="filter-option">
            <input
                type="checkbox"
                name="category[]"
                value="toys"
                <?php checked(in_array('toys', $selected_categories, true)); ?>
            >
            <span>Іграшки</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="category[]"
                value="clothes"
                <?php checked(in_array('clothes', $selected_categories, true)); ?>
            >
            <span>Одяг</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="category[]"
                value="newborn"
                <?php checked(in_array('newborn', $selected_categories, true)); ?>
            >
            <span>Для новонароджених</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="category[]"
                value="strollers"
                <?php checked(in_array('strollers', $selected_categories, true)); ?>
            >
            <span>Коляски</span>
        </label>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Ціна</legend>

        <div class="price-filter">
            <label>
                <span>Від</span>
                <input
                    type="number"
                    name="price_min"
                    min="0"
                    placeholder="0"
                    value="<?php echo esc_attr($price_min); ?>"
                >
            </label>

            <label>
                <span>До</span>
                <input
                    type="number"
                    name="price_max"
                    min="0"
                    placeholder="5000"
                    value="<?php echo esc_attr($price_max);?>"
                >
            </label>
        </div>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Бренд</legend>

        <label class="filter-option">
            <input
                type="checkbox"
                name="brand[]"
                value="chicco"
                <?php checked(in_array('chicco', $selected_brands, true)); ?>
            >
            <span>Chicco</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="brand[]"
                value="lego"
                <?php checked(in_array('lego', $selected_brands, true)); ?>
            >
            <span>LEGO</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="brand[]"
                value="fisher-price"
                <?php checked(in_array('fisher-price', $selected_brands, true)); ?>
            >
            <span>Fisher-Price</span>
        </label>

        <label class="filter-option">
            <input
                type="checkbox"
                name="brand[]"
                value="babyono"
                <?php checked(in_array('babyono', $selected_brands, true)); ?>
            >
            <span>BabyOno</span>
        </label>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Вік</legend>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="0-1"
            <?php checked(in_array('0-1', $selected_ages, true)); ?>
            >
            <span>0–1 рік</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="1-3"
            <?php checked(in_array('1-3', $selected_ages, true)); ?>
            >
            <span>1–3 роки</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="3-6"
            <?php checked(in_array('3-6', $selected_ages, true)); ?>
            >
            <span>3–6 років</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="6-plus"
            <?php checked(in_array('6-plus', $selected_ages, true)); ?>
            >
            <span>6+ років</span>
        </label>
    </fieldset>

    <button type="submit" class="button filters-form__submit">
        Застосувати фільтри
    </button>

</form>