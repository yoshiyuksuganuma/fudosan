


<?php
     get_header();
?>

<main>

<div class="page-404">
  <h2>404 Not Found（ページが見つかりませんでした）</h2>
  <p>指定された以下のページは存在しないか、または移動した可能性があります。</p>
  <p>よろしければ、検索ボックスにお探しのコンテンツに該当するキーワードを入力して下さい。</p>
  <?php get_search_form(); ?><!-- 検索フォームを表示 -->
  <p><a href="<?php echo home_url(); ?>">トップページへ</a></p>
</div>

</main>
<?php get_footer(); ?>