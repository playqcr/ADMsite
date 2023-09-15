        <!-- <div class="container-fluid" style="background-color: #1b1145; height: 100px; color: #ffffff; margin-top: 20px; display: flex;"> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

        <script type="text/javascript">

            document.addEventListener("DOMContentLoaded", function (event) {
                const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId);

                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener("click", () => {
                    // show navbar
                    nav.classList.toggle("show");
                    // change icon
                    toggle.classList.toggle("bx-x");
                    // add padding to body
                    bodypd.classList.toggle("body-pd");
                    // add padding to header
                    headerpd.classList.toggle("body-pd");
                    });
                }
                };

                showNavbar("header-toggle", "nav-bar", "body-pd", "header");

                /*===== LINK ACTIVE =====*/
                const linkColor = document.querySelectorAll(".nav_link");

                function colorLink() {
                if (linkColor) {
                    linkColor.forEach((l) => l.classList.remove("active"));
                    this.classList.add("active");
                }
                }
                linkColor.forEach((l) => l.addEventListener("click", colorLink));

                // Your code to run since DOM is loaded and ready
            });
        </script>

        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>

        <footer class="footer">
            <div class="text-center" style="color: #ffffff;">
                Copyright &copy; <?php echo date('Y'); ?> <a href="https://ihnbible.org" target="_blank">IHN Bible Inc</a>. All rights reserved.
            </div>
            <!-- </div> -->
        </footer>

        
        <!-- <script src="js/jquery-ui-min.js"></script>
        <script src="js/jquery.js"></script> -->
    </body>
</html>