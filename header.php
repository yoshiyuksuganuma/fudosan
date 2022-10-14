 
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php bloginfo('name'); wp_title('|', true, 'left'); ?></title>
<meta name="robots" content="noindex" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">
<!-- faviconを設定する場合 type="image/png"にすればpng画像を設定できる -->
<link rel="shortcut icon" href="image/" type="image/vnd.microsoft.icon" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >

<header class="header" id="header">
    <div class="header__inner">
      <div class="header__logo">
        <!-- カスタムロゴのurlを取得、出力 -->
        <?php 
        if( has_custom_logo() ){ 
        $custom_logo_id = get_theme_mod( 'custom_logo' ); 
        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); 
        $url = $image[0]; 
        } 
        ?> 
        <a href="<?php echo esc_url(home_url('/')); ?>">
        <?php // bloginfo('name'); ?>
        <?php if( has_custom_logo()) : ?>
        <img src="<?php echo esc_url($url); ?>" alt="<?php bloginfo('description'); ?>">
        <?php endif; ?>
        </a>        
      </div>
      <!-- ナビゲーション読み込み -->
     <?php get_template_part('includes/global_nav'); ?>
    </div>
</header>
    <!-----header END ----->
		




