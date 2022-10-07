<!-- フッターナビ -->
<?php
//カスタムメニューを取得
$menu_name = 'footer_nav';
$locations = get_nav_menu_locations();
$menu = wp_get_nav_menu_object($locations[$menu_name]);
$menu_items = wp_get_nav_menu_items($menu->term_id);

?>
<?php if($menu_items) : ?>
<nav class="footer-nav">
        <ul class="footer-nav__list">
    
      <?php foreach ($menu_items as $item) : ?>
        <li class="footer-nav__item ">
          <a class="footer-nav__link " href="<?php echo $item->url; ?>">
          <?php if($item->description) : ?>
          <!-- カスタムメニューの説明欄の画像パスを出力 -->
          <img src="<?php echo esc_url(get_template_directory()) . '/image/' . $item->description; ?>" alt="">
          <?php endif; ?>
          <?php echo $item->title; ?>
          <!-- カスタムメニューのタイトル属性を出力） -->
          <?php if($item->attr_title) : ?>
          <span class="footer-nav__item-sub"><?php echo $item->attr_title; ?></span>
          <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <!--  フッターナビSP-->
    <?php
      //カスタムメニューを取得
      $menu_name = 'footer_nav_sp';
      $locations = get_nav_menu_locations();
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id);

      ?>
      <?php if ($menu_items) : ?>
    <nav class="footer-nav-sp">
        <ul class="footer-nav-sp__list">
      <?php foreach ($menu_items as $item) : ?>
        <li class="footer-nav-sp__item ">
          <a class="footer-nav-sp__link " href="<?php echo $item->url; ?>">
          <?php if($item->description) : ?>
          <!-- カスタムメニューの説明欄の画像パスを出力 -->
          <img src="<?php echo esc_url(get_template_directory()) . '/image/' . $item->description; ?>" alt="">
          <?php endif; ?>
          <?php echo $item->title; ?>
          <!-- カスタムメニューのタイトル属性を出力） -->
          <?php if($item->attr_title) : ?>
          <span class="footer-nav-sp__item-sub"><?php echo $item->attr_title; ?></span>
          <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
        </ul>
    </nav>
    <?php endif; ?>