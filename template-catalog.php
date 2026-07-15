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

           <form class="catalog-sorting-form" method="get">

                <?php
                get_template_part(
                    'template-parts/components/catalog/sorting'
                );
                ?>

            </form>

        </header>

        <div class="catalog-layout">

           <aside class="catalog-filters">
                <?php
                 get_template_part(
                     'template-parts/components/catalog/filters'
                );
                ?>
            </aside>


            <div class="catalog-content">            
                <section class="catalog-products">

                    <?php
                    get_template_part(
                    'template-parts/components/catalog/products'
                    );
                    ?>

                </section>
                    <?php
                    get_template_part(
                        'template-parts/components/catalog/pagination'
                    );
                    ?>
            </div>
        </div>

    </div>

</main>

<?php
get_footer();