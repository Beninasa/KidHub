<div class="catalog-filters__header">
    <h2 class="catalog-filters__title">Фільтри</h2>

    <button type="reset" class="catalog-filters__reset">
    Очистити
    </button>
</div>

<form class="filters-form" action="#" method="get">

    <fieldset class="filter-group">
        <legend class="filter-group__title">Категорія</legend>

        <label class="filter-option">
            <input type="checkbox" name="category[]" value="toys">
            <span>Іграшки</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="category[]" value="clothes">
            <span>Одяг</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="category[]" value="newborn">
            <span>Для новонароджених</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="category[]" value="strollers">
            <span>Коляски</span>
        </label>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Ціна</legend>

        <div class="price-filter">
            <label>
                <span>Від</span>
                <input type="number" name="price_min" min="0" placeholder="0">
            </label>

            <label>
                <span>До</span>
                <input type="number" name="price_max" min="0" placeholder="5000">
            </label>
        </div>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Бренд</legend>

        <label class="filter-option">
            <input type="checkbox" name="brand[]" value="chicco">
            <span>Chicco</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="brand[]" value="lego">
            <span>LEGO</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="brand[]" value="fisher-price">
            <span>Fisher-Price</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="brand[]" value="babyono">
            <span>BabyOno</span>
        </label>
    </fieldset>

    <fieldset class="filter-group">
        <legend class="filter-group__title">Вік</legend>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="0-1">
            <span>0–1 рік</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="1-3">
            <span>1–3 роки</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="3-6">
            <span>3–6 років</span>
        </label>

        <label class="filter-option">
            <input type="checkbox" name="age[]" value="6-plus">
            <span>6+ років</span>
        </label>
    </fieldset>

    <button type="submit" class="button filters-form__submit">
        Застосувати фільтри
    </button>

</form>