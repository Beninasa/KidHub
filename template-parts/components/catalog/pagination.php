<?php

$total_pages  = $args['total_pages'] ?? 1;
$current_page = $args['current_page'] ?? 1;
$query_args   = $args['query_args'] ?? [];

if ($total_pages <= 1) {
    return;
}

?>

<nav class="catalog-pagination" aria-label="Навігація сторінками каталогу">

    <?php if ($current_page > 1) : ?>
        <a
            href="<?php echo esc_url(
                add_query_arg(
                    array_merge(
                        $query_args,
                        ['catalog_page' => $current_page - 1]
                    ),
                    get_permalink()
                )
            ); ?>"
            class="catalog-pagination__link"
            aria-label="Попередня сторінка"
        >
            ←
        </a>
    <?php endif; ?>

    <?php for ($page = 1; $page <= $total_pages; $page++) : ?>

        <a
            href="<?php echo esc_url(
                add_query_arg(
                    array_merge(
                        $query_args,
                        ['catalog_page' => $page]
                    ),
                    get_permalink()
                )
            ); ?>"
            class="catalog-pagination__link<?php
            echo $page === $current_page
                ? ' catalog-pagination__link--active'
                : '';
            ?>"
            <?php if ($page === $current_page) : ?>
                aria-current="page"
            <?php endif; ?>
        >
            <?php echo esc_html($page); ?>
        </a>

    <?php endfor; ?>

    <?php if ($current_page < $total_pages) : ?>
        <a
            href="<?php echo esc_url(
                add_query_arg(
                    array_merge(
                        $query_args,
                        ['catalog_page' => $current_page + 1]
                    ),
                    get_permalink()
                )
            ); ?>"
            class="catalog-pagination__link"
            aria-label="Наступна сторінка"
        >
            →
        </a>
    <?php endif; ?>

</nav>