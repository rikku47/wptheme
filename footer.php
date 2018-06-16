<button id="btnToTheTop" onclick="topFunction()">Nach oben</button>
</div>
<footer>
        <div id="wrapperFooter">
            <p>E-Mail:
                <a href="mailto:racoon_dr_ak@hotmail.com">racoon_dr_ak@hotmail.com</a>
            </p>
            <p>
                <a href="impressum/">Impressum</a>
            </p>
            <p>
                <a href="datenschutz/">Datenschutz</a>
            </p>
            <p>
                <a href="haftungsausschluss/">Haftungsausschluss</a>
            </p>
        </div>
    </footer>
    <!-- JavaScript -->
    <script scr="<?php wp_enqueue_script( 'script', get_template_directory_uri() . '/js/btnToTheTop.js'); ?>"></script>
    <script scr="<?php wp_enqueue_script( 'script', get_template_directory_uri() . '/js/jquery-3.3.1.min.js'); ?>"></script>
    <!-- <script>
        $(document).scroll(function () {
            if (Math.max(0, ($(this).scrollTop() > $("#menu").position().top))) {
                $("#menu").addClass("scroll");
            } else {
                $("#menu").removeClass("scroll");
            }
        })
    </script> -->
<?php wp_footer(); ?>
</body>

</html>