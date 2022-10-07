<footer class="footer">
    <div class="footer__inner">
    <?php get_template_part('includes/footer_nav'); ?>
        <small class="footer__small">&copy;<?php bloginfo(); ?></small>
    </div>
</footer>  

<?php if ( is_IE() ) : ?>
<div class="ie_alert">
  <span>当サイトはInternet Explorer<br>に対応しておりません。</span>
  <p>最新のブラウザ（EdgeやFirefox、Google Chrome）</b>をお使いください。</p>
  <a href="https://www.google.co.jp/chrome/index.html">Google Chromeをダウンロード</a>
<div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
