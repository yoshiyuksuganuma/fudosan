 
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php bloginfo('name'); wp_title('|', true, 'left'); ?></title>
<meta name="robots" content="noindex" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!-- slick css読み込み -->
<link
	rel="stylesheet"
	type="text/css"
	href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
/>
<link
	rel="stylesheet"
	type="text/css"
	href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
/>
<!-- faviconを設定する場合 type="image/png"にすればpng画像を設定できる -->
<link rel="shortcut icon" href="image/" type="image/vnd.microsoft.icon" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >

<header class="header" id="header">
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
       <?php bloginfo('name'); ?>
       <?php if( has_custom_logo()) : ?>
       <img src="<?php echo esc_url($url); ?>" alt="<?php bloginfo('description'); ?>">
       <?php endif; ?>
      </a>        
       </div>
      <!-- ナビゲーション読み込み -->
     <?php get_template_part('includes/global_nav'); ?>
</header>
    <!-----header END ----->
		




