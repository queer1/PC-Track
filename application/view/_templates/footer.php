        <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.button-collapse').sideNav({menuWidth: 240, activationWidth: 70});
                $('.dropdown-button').dropdown({ hover: false, belowOrigin: true});
            });
        </script>
        <?php dump($_SESSION); ?>
    </body>
</html>