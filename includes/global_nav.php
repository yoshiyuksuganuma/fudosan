    <!-- 
        カスタムメニューー使い方 
        functions.phpで使いたい数だけメニュ-名をを登録する
        管理画面カスタムメニューからメニューを作成、チェックボックスを選択してfunctions.phpで作成したメニュー名と紐づける
         画像パスやサブタイを設定したい場合は、管理画面のメニュー設定画面の
         表示オプションからタイトル属性、説明欄が表示されるように設定する
    -->
    
    <!-- グローバルナビ -->
    <?php
      //カスタムメニューを取得
      $menu_name = 'global_nav';
      $locations = get_nav_menu_locations();
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id);

      ?>
      <?php if ($menu_items) : ?>
    <nav class="g-nav">
        <ul class="g-nav__list">
     
      <?php foreach ($menu_items as $item) : ?>
        <li class="g-nav__item ">
          <a class="g-nav__link " href="<?php echo $item->url; ?>">
          <?php if($item->description) : ?>
          <!-- カスタムメニューの説明欄の画像パスを出力 -->
          <img src="<?php echo esc_url(get_template_directory()) . '/image/' . $item->description; ?>" alt="">
          <?php endif; ?>
          <?php echo $item->title; ?>
          <!-- カスタムメニューのタイトル属性を出力） -->
          <?php if($item->attr_title) : ?>
          <span class="g-nav__item-sub"><?php echo $item->attr_title; ?></span>
          <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
        </ul>
    </nav>
    <?php endif; ?>
    <!--  グローバルナビSP-->
    <?php
      //カスタムメニューを取得
      $menu_name = 'global_nav_sp';
      $locations = get_nav_menu_locations();
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id);

      ?>
      <?php if ($menu_items) : ?>
    <nav class="g-nav-sp">
        <ul class="g-nav-sp__list">
     
      <?php foreach ($menu_items as $item) : ?>
        <li class="g-nav-sp__item ">
          <a class="g-nav-sp__link " href="<?php echo $item->url; ?>">
          <?php if($item->description) : ?>
          <!-- カスタムメニューの説明欄の画像パスを出力 -->
          <img src="<?php echo esc_url(get_template_directory()) . '/image/' . $item->description; ?>" alt="">
          <?php endif; ?>
          <?php echo $item->title; ?>
          <!-- カスタムメニューのタイトル属性を出力） -->
          <?php if($item->attr_title) : ?>
          <span class="g-nav-sp__item-sub"><?php echo $item->attr_title; ?></span>
          <?php endif; ?>
          </a>
        </li>
      <?php endforeach; ?>
        </ul>
    </nav>
    <?php endif; ?>
     
      