<?php
/**
 * Template Name: Каталог товарів
 */

get_header();

$catalog = require get_template_directory()
    . '/inc/catalog/catalog-query.php';
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
                    <?php
                        printf(
                            esc_html__('%d товарів', 'kidhub'),
                            (int) $catalog['total_products']
                        );
                    ?>
                </p>
            </div>

           <form class="catalog-sorting-form" method="get">

                <?php foreach ((array) ($_GET['category'] ?? []) as $category) : ?>
                    <input
                        type="hidden"
                        name="category[]"
                        value="<?php echo esc_attr(sanitize_key(wp_unslash($category))); ?>"
                    >
                <?php endforeach; ?>

                <?php foreach ((array) ($_GET['brand'] ?? []) as $brand) : ?>
                    <input
                        type="hidden"
                        name="brand[]"
                        value="<?php echo esc_attr(sanitize_key(wp_unslash($brand))); ?>"
                    >
                <?php endforeach; ?>

                <?php foreach ((array) ($_GET['age'] ?? []) as $age) : ?>
                    <input
                        type="hidden"
                        name="age[]"
                        value="<?php echo esc_attr(sanitize_key(wp_unslash($age))); ?>"
                    >
                <?php endforeach; ?>

                <?php if (isset($_GET['price_min']) && $_GET['price_min'] !== '') : ?>
                    <input
                        type="hidden"
                        name="price_min"
                        value="<?php echo esc_attr(max(0, (int) wp_unslash($_GET['price_min']))); ?>"
                    >
                <?php endif; ?>

                <?php if (isset($_GET['price_max']) && $_GET['price_max'] !== '') : ?>
                    <input
                        type="hidden"
                        name="price_max"
                        value="<?php echo esc_attr(max(0, (int) wp_unslash($_GET['price_max']))); ?>"
                    >
                <?php endif; ?>

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
                        'template-parts/components/catalog/products',
                        null,
                        [
                            'products' => $catalog['products'],
                        ]
                    );
                    ?>

                </section>
                    <?php
                    get_template_part(
                        'template-parts/components/catalog/pagination',
                        null,
                        [
                            'total_pages'  => $catalog['total_pages'],
                            'current_page' => $catalog['current_page'],
                            'query_args'   => $catalog['query_args'],
                        ]
                    );
                    ?>
            </div>
        </div>

    </div>

</main>

<?php
get_footer();