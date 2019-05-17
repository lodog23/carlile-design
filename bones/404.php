<?php
get_header();
$pageContent = get_field('qd_404_content', 'option'); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

	        <section class="entry-content cf" itemprop="articleBody">
                <div class="the-content"><?php echo $pageContent; ?>	</div>

                <div class="search-form">
                    <?php get_search_form(); ?>
                </div>
	        </section>
    </article>

<?php get_footer(); ?>
