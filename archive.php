<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
       <h1 class="entry-title"><?php the_title() ?></h1>
       <div>
         <?php the_content(); ?>
      </div>
  </article>
  <hr/>
    <?php endwhile; ?>



<?php get_footer(); ?>