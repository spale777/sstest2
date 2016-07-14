<footer id="footer">
    <div id="footer-top" class="container">
        <div class="row">
            <div class="block col-sm-3">
                <a href="#"><img src="$ThemeDir/images/logo.png" alt="One Ring Rentals" /></a>
                <br><br>
                <% if $SiteConfig.FooterContent %>
                    <p>$SiteConfig.FooterContent</p>
                <% end_if %>
            </div>
            <div class="block col-sm-3">
                <h3>Helpful Links</h3>
                <ul class="footer-links">
                    <li><a href="#">All rentals</a></li>
                    <li><a href="#">List your rental</a></li>
                    <li><a href="#">Read our FAQs</a></li>
                </ul>
            </div>
            <div class="block col-sm-6">
                <h3>Popular regions</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="footer-listings">
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Rhovanion</a></p>
                            </li>
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Eriador</a></p>
                            </li>
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Bay of Belfalas</a></p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="footer-listings">
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Mordor</a></p>
                            </li>
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Arnor</a></p>
                            </li>
                            <li>
                                <div class="image">
                                    <a href="properties-detail.html"><img src="http://placehold.it/760x670" alt="" /></a>
                                </div>
                                <p><a href="properties-detail.html">Forlindon</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN COPYRIGHT -->
    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    &copy; 2014 One Ring Rentals

                    <!-- BEGIN SOCIAL NETWORKS -->
                    <ul class="social-networks">
                        <% with $SiteConfig %>
                            <% if $FacebookLink %>
                                <li><a href="$FacebookLink"><i class="fa fa-facebook"></i></a></li>
                            <% end_if %>
                            <% if $TwitterLink %>
                                <li><a href="$TwitterLink"><i class="fa fa-twitter"></i></a></li>
                            <% end_if %>
                            <% if $GoogleLink %>
                                <li><a href="$GoogleLink"><i class="fa fa-google"></i></a></li>
                            <% end_if %>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <% if $YoutubeLink %>
                                <li><a href="$YoutubeLink"><i class="fa fa-youtube"></i></a></li>
                            <% end_if %>
                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <% end_with %>
                    </ul>
                    <!-- END SOCIAL NETWORKS -->
                </div>
            </div>
        </div>
    </div>
    <!-- END COPYRIGHT -->

</footer>