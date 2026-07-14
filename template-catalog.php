<?php
/**
 * Template Name: Каталог товарів
 */

get_header();
?>

<main class="catalog-page">

    <div class="container">

        <nav class="breadcrumbs" aria-label="Навігація">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                Головна
            </a>

            <span aria-hidden="true">/</span>

            <span>Каталог</span>
        </nav>

        <header class="catalog-header">

            <div>
                <h1 class="catalog-header__title">
                    <?php the_title(); ?>
                </h1>

                <p class="catalog-header__count">
                    128 товарів
                </p>
            </div>

            <label class="catalog-sorting">
                <span class="catalog-sorting__label">
                    Сортування
                </span>

                <select class="catalog-sorting__select">
                    <option>За популярністю</option>
                    <option>Від дешевих до дорогих</option>
                    <option>Від дорогих до дешевих</option>
                    <option>Новинки</option>
                </select>
            </label>

        </header>

        <div class="catalog-layout">

           <aside class="catalog-filters">
                <?php
                 get_template_part(
                     'template-parts/components/catalog/filters'
                );
                ?>
            </aside>

            <section class="catalog-products">

                <div class="catalog-products__placeholder">
                    Сітка товарів з’явиться на наступному етапі.
                </div>

            </section>

        </div>

    </div>

</main>

<?php
get_footer();